<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\pengguna; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function index()
    {
        $data_karyawan = DB::table('pengguna')
    ->leftJoin('profil_pegawai', 'pengguna.nip', '=', 'profil_pegawai.nip')
    ->leftJoin('jabatan', 'profil_pegawai.id_jabatan', '=', 'jabatan.id')
    ->select(
        'pengguna.nip',
        'pengguna.nama',
        'pengguna.email',
        'pengguna.id_divisi',
        'pengguna.foto',
        'pengguna.apakah_aktif',
        'profil_pegawai.nama_lengkap',
        'profil_pegawai.id as id_profil',
        'jabatan.nama_jabatan as jabatan'
    )
    ->orderBy('pengguna.nip', 'asc')
    ->paginate(7);

        return view('halaman.users', compact('data_karyawan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nip'        => 'required|string|unique:pengguna,nip',
        'nama'       => 'required|string|max:255',
        'kata_sandi' => 'required|string|min:8',
        'role'       => 'required',
        'foto'       => 'nullable|string' 
    ]);

    pengguna::create([
        'nip'                  => $request->nip,
        'nama'                 => $request->nama,
        'kata_sandi'           => Hash::make($request->kata_sandi),
        'role'                 => $request->role,
        'foto'                 => $request->foto ?? 'default.jpg',
        'harus_ganti_password' => 1,             
        'batas_ganti_password' => now()->addDays(3), 
    ]);

    return redirect()->back()->with('success', 'User ' . $request->nama . ' berhasil ditambahkan!');
}

    public function update(Request $request, $nip) 
    {
        
        $user = pengguna::where('nip', $nip)->firstOrFail();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required',
            'nip'  => ['required', Rule::unique('pengguna')->ignore($user->nip, 'nip')],
        ]);

        $user->update([
            'nip'  => $request->nip,
            'nama' => $request->nama,
            'role' => $request->role,
        ]);

        if ($request->filled('kata_sandi')) {
            $request->validate(['kata_sandi' => 'min:8']);
            $user->update(['kata_sandi' => Hash::make($request->kata_sandi)]);
        }

        return redirect()->back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($nip)
    {
        try {

            $user = pengguna::where('nip', $nip)->firstOrFail();

            $user->update([
                'apakah_aktif' => 0
            ]);

            return redirect()->back()->with(
                'success',
                'Akun berhasil dinonaktifkan!'
            );

        } catch (\Exception $e) {

            return redirect()->back()->with(
                'error',
                'Gagal menonaktifkan akun: ' . $e->getMessage()
            );
        }
    }

    public function formGantiPassword()
    {
        return view('halaman.ganti_password');
    }

    public function prosesGantiPassword(Request $request)
    {
        $request->validate([
        'password_baru' => ['required', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'confirmed'],
        ]);

        pengguna::where('nip', Auth::user()->nip)
            ->update([
                'kata_sandi'           => Hash::make($request->password_baru),
                'harus_ganti_password' => 0,
                'batas_ganti_password' => null,
            ]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diperbarui!');
    }
}