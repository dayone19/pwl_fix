<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    private function isHRD(): bool
    {
        return Str::upper(Auth::user()->divisi?->nama_divisi) === 'HRD';
    }

    public function index()
    {
        $data_karyawan = DB::table('profil_pegawai')
            ->join('pengguna', 'profil_pegawai.nip', '=', 'pengguna.nip')
            ->select('profil_pegawai.*', 'pengguna.foto', 'pengguna.email')
            ->paginate(7)
            ->onEachSide(1);

        return view('halaman.karyawan', compact('data_karyawan'));
    }

    public function create()
    {
        abort_unless($this->isHRD(), 403);

        $list_divisi  = DB::table('divisi')->get();
        $list_jabatan = DB::table('jabatan')->get();

        return view('halaman.tambah', compact('list_divisi', 'list_jabatan'));
    }

    public function store(Request $request)
    {
        abort_unless($this->isHRD(), 403);

        $request->validate([
            'nip'                  => 'required|min:6|unique:pengguna,nip',
            'email'                => 'required|email|unique:pengguna,email',
            'kata_sandi'           => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            'nama_lengkap'         => 'required|string',
            'id_divisi'            => 'required',
            'id_jabatan'           => 'required',
            'nik'                  => 'required|digits:16',
            'status_kerja'         => 'required',
            'tempat_lahir'         => 'required|string',
            'tanggal_lahir'        => 'required|date',
            'foto'                 => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $tempatTanggalGabung = strtoupper($request->tempat_lahir) . ', ' . $request->tanggal_lahir;

            $namaFoto = 'default.jpg';
            if ($request->hasFile('foto')) {
                $file     = $request->file('foto');
                $namaFoto = time() . '_' . $request->nip . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/profil'), $namaFoto);
            }

            $roleOtomatis = match ((string)$request->id_divisi) {
                '1'     => 'manajemen',
                '2'     => 'hrd',
                '3'     => 'accounting',
                '4'     => 'teknis',
                default => 'teknis',
            };

            DB::table('pengguna')->insert([
                'nip'                  => $request->nip,
                'id_divisi'            => $request->id_divisi,
                'nama'                 => $request->nama_lengkap,
                'email'                => $request->email,
                'kata_sandi'           => Hash::make($request->kata_sandi ?? $request->nip),
                'foto'                 => $namaFoto,
                'apakah_aktif'         => 1,
                'harus_ganti_password' => 1,
                'batas_ganti_password' => now()->addDays(3),
            ]);

            DB::table('profil_pegawai')->insert([
                'nip'                  => $request->nip,
                'nama_lengkap'         => $request->nama_lengkap,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'nik'                  => $request->nik,
                'email'                => $request->email,
                'nomor_telepon'        => $request->nomor_telepon ?? '-',
                'id_jabatan'           => $request->id_jabatan,
                'id_divisi'            => $request->id_divisi,
                'agama'                => $request->agama,
                'tempat_tanggal_lahir' => $tempatTanggalGabung,
                'pendidikan'           => $request->pendidikan,
                'status_kerja'         => $request->status_kerja,
                'foto'                 => $namaFoto,
                'dibuat_pada'          => now(),
                'apakah_digaji'        => 1,
            ]);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Pegawai ' . $request->nama_lengkap . ' Berhasil Didaftarkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show($nip)
    {
        $p = DB::table('profil_pegawai')
            ->join('pengguna', 'profil_pegawai.nip', '=', 'pengguna.nip')
            ->join('divisi', 'profil_pegawai.id_divisi', '=', 'divisi.id')
            ->join('jabatan', 'profil_pegawai.id_jabatan', '=', 'jabatan.id')
            ->select(
                'profil_pegawai.*',
                'pengguna.foto as foto_akun',
                'pengguna.email as email_akun',
                'divisi.nama_divisi',
                'jabatan.nama_jabatan as jabatan'
            )
            ->where('profil_pegawai.nip', $nip)
            ->first();

        if (!$p) { abort(404); }

        return view('halaman.detail_karyawan', compact('p'));
    }

    public function destroy($nip)
    {
        abort_unless($this->isHRD(), 403);

        DB::beginTransaction();

        try {
            $pegawai = DB::table('profil_pegawai')->where('nip', $nip)->first();

            if (!$pegawai) {
                return back()->with('error', 'Pegawai tidak ditemukan');
            }

            DB::table('riwayat_pegawai')->where('pegawai_id', $pegawai->id)->delete();
            DB::table('penggajian')->where('id_pegawai', $pegawai->id)->delete();
            DB::table('profil_pegawai')->where('id', $pegawai->id)->delete();
            DB::table('pengguna')->where('nip', $nip)->delete();

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Data pegawai berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function edit($nip)
    {
        abort_unless($this->isHRD(), 403);

        $pegawai = DB::table('profil_pegawai')
            ->join('pengguna', 'profil_pegawai.nip', '=', 'pengguna.nip')
            ->where('profil_pegawai.nip', $nip)
            ->select('profil_pegawai.*', 'pengguna.email')
            ->first();

        if (!$pegawai) { abort(404); }

        $list_divisi  = DB::table('divisi')->get();
        $list_jabatan = DB::table('jabatan')->get();

        return view('halaman.tambah', compact('pegawai', 'list_divisi', 'list_jabatan'));
    }

    public function update(Request $request, $nip)
    {
        abort_unless($this->isHRD(), 403);

        $request->validate([
            'nama_lengkap'  => 'required|string',
            'id_divisi'     => 'required',
            'id_jabatan'    => 'required',
            'nik'           => 'required|digits:16',
            'status_kerja'  => 'required',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email'         => 'required|email|unique:pengguna,email,' . $nip . ',nip',
        ]);

        try {
            DB::beginTransaction();

            $tempatTanggalGabung = strtoupper($request->tempat_lahir) . ', ' . $request->tanggal_lahir;

            $pegawai  = DB::table('profil_pegawai')->where('nip', $nip)->first();
            $namaFoto = $pegawai->foto;

            if ($request->hasFile('foto')) {
                $file     = $request->file('foto');
                $namaFoto = time() . '_' . $nip . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/profil'), $namaFoto);
            }

            DB::table('pengguna')->where('nip', $nip)->update([
                'nama'      => $request->nama_lengkap,
                'email'     => $request->email,
                'id_divisi' => $request->id_divisi,
                'foto'      => $namaFoto,
            ]);

            DB::table('profil_pegawai')->where('nip', $nip)->update([
                'nama_lengkap'         => $request->nama_lengkap,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'nik'                  => $request->nik,
                'email'                => $request->email,
                'nomor_telepon'        => $request->nomor_telepon ?? '-',
                'id_jabatan'           => $request->id_jabatan,
                'id_divisi'            => $request->id_divisi,
                'agama'                => $request->agama,
                'tempat_tanggal_lahir' => $tempatTanggalGabung,
                'pendidikan'           => $request->pendidikan,
                'status_kerja'         => $request->status_kerja,
                'foto'                 => $namaFoto,
            ]);

            DB::commit();

            return redirect()->route('karyawan.index')
                ->with('success', 'Data ' . $request->nama_lengkap . ' berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function kartuPegawai($nip)
    {
        $pegawai = DB::table('profil_pegawai')
            ->join('pengguna', 'profil_pegawai.nip', '=', 'pengguna.nip')
            ->join('divisi', 'profil_pegawai.id_divisi', '=', 'divisi.id')
            ->join('jabatan', 'profil_pegawai.id_jabatan', '=', 'jabatan.id')
            ->select(
                'profil_pegawai.*',
                'pengguna.foto as foto_akun',
                'pengguna.email as email_akun',
                'divisi.nama_divisi',
                'jabatan.nama_jabatan as jabatan'
            )
            ->where('profil_pegawai.nip', $nip)
            ->first();

        if (!$pegawai) { abort(404); }

        $pdf = Pdf::loadView('ekspor_pdf.kartu_pegawai', compact('pegawai'));

        return $pdf->download('Kartu-Pegawai-' . $pegawai->nip . '.pdf');
    }
}