<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // ── Halaman form forgot password (publik) ─────────────────────────────────
    public function index()
    {
        return view('auth.forgotpw');
    }

    // ── Karyawan submit permintaan reset (AJAX dari forgotpw) ─────────────────
    public function submit(Request $request)
    {
        $request->validate(['nip' => ['required', 'digits_between:6,20']]);

        $nip  = $request->nip;

        // Pakai DB facade langsung ke tabel 'pengguna' (bukan 'users')
        $user = DB::table('pengguna')->where('nip', $nip)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'NIP tidak ditemukan dalam sistem.',
            ], 404);
        }

        // Tolak jika sudah ada request aktif
        $existing = AccessRequest::where('nip', $nip)
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Sudah ada permintaan aktif untuk NIP ini. Harap tunggu proses selesai.',
            ], 422);
        }

        AccessRequest::create(['nip' => $nip, 'status' => 'pending']);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil dikirim.',
        ]);
    }

    // ── Daftar permintaan akses (HRD & Manajemen) ────────────────────────────
    public function requestList()
    {
        $this->authorizeHrd();

        $requests = AccessRequest::with('pengguna.divisi')
            ->latest()
            ->paginate(15);

        // Siapkan JSON di controller — hindari anonymous function di dalam
        // @json() pada Blade yang menyebabkan ParseError "Unclosed '['"
        $requestsJson = $requests->getCollection()->map(function ($r) {
            $badge = $r->statusBadge();
            return [
                'id'           => $r->id,
                'nip'          => $r->nip,
                'nama'         => $r->pengguna?->nama ?? '–',
                'divisi'       => $r->pengguna?->divisi?->nama_divisi ?? '–',
                'tanggal'      => $r->created_at->format('d M Y'),
                'status'       => $r->status,
                'badgeLabel'   => $badge['label'],
                'badgeColor'   => $badge['color'],
                'catatan_hr'   => $r->catatan_hr,
                'token_expiry' => $r->token_expires_at
                    ? $r->token_expires_at->format('d M Y, H:i') . ' WIB'
                    : null,
                'approveUrl'   => route('access-requests.approve', $r->id),
                'rejectUrl'    => route('access-requests.reject', $r->id),
            ];
        })->values()->toArray();

        return view('auth.accessrequest', compact('requests', 'requestsJson'));
    }

    // ── HRD: setujui permintaan ───────────────────────────────────────────────
    public function approve(Request $request, $id)
    {
        $this->authorizeHrd();

        $request->validate([
            'catatan_hr' => ['nullable', 'string', 'max:255'],
        ]);

        $ar = AccessRequest::findOrFail($id);

        if ($ar->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $token = Str::random(64);

        $ar->update([
            'status'             => 'disetujui',
            'token'              => $token,
            'token_expires_at'   => now()->addHours(24),
            'catatan_hr'         => $request->catatan_hr,
            'petugas_hr'         => auth()->user()->nama,
            'tanggal_verifikasi' => now(),
        ]);

        $resetLink = route('password.reset.form', ['token' => $token]);

        return back()->with('success_link', $resetLink)->with('success_nip', $ar->nip);
    }

    // ── HRD: tolak permintaan ─────────────────────────────────────────────────
    public function reject(Request $request, $id)
    {
        $this->authorizeHrd();

        $request->validate([
            'catatan_hr' => ['nullable', 'string', 'max:255'],
        ]);

        $ar = AccessRequest::findOrFail($id);

        if ($ar->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $ar->update([
            'status'             => 'ditolak',
            'catatan_hr'         => $request->catatan_hr,
            'petugas_hr'         => auth()->user()->nama,
            'tanggal_verifikasi' => now(),
        ]);

        return back()->with('success', 'Permintaan telah ditolak.');
    }

    // ── Karyawan: form buat password baru via token ───────────────────────────
    public function resetForm($token)
    {
        $ar = AccessRequest::where('token', $token)
            ->where('status', 'disetujui')
            ->first();

        if (! $ar || ! $ar->isTokenValid()) {
            abort(403, 'Link tidak valid atau sudah kadaluarsa. Hubungi HRD.');
        }

        return view('auth.resetpassword', compact('ar', 'token'));
    }

    // ── Karyawan: simpan password baru ────────────────────────────────────────
    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $ar = AccessRequest::where('token', $token)
            ->where('status', 'disetujui')
            ->first();

        if (! $ar || ! $ar->isTokenValid()) {
            return back()->withErrors(['token' => 'Link tidak valid atau sudah kadaluarsa.']);
        }

        // Update langsung ke tabel 'pengguna'
        DB::table('pengguna')->where('nip', $ar->nip)->update([
            'kata_sandi'     => Hash::make($request->password),
            'login_attempts' => 0,
            'lockout_time'   => null,
            'updated_at'     => now(),
        ]);

        $ar->update([
            'status'           => 'selesai',
            'token'            => null,
            'token_expires_at' => null,
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }

    // ── Helper: pastikan hanya HRD/Manajemen yang bisa akses ─────────────────
    private function authorizeHrd()
    {
        $divisi = strtoupper(auth()->user()->divisi?->nama_divisi ?? '');
        if (! in_array($divisi, ['HRD', 'MANAJEMEN'])) {
            abort(403, 'Akses ditolak.');
        }
    }
}