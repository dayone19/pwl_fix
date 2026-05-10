<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\pengguna; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    public function index()
    {
        $data_karyawan = DB::table('pengguna')
            ->leftJoin('profil_pegawai', 'pengguna.nip', '=', 'profil_pegawai.nip')
            ->select(
                'pengguna.nip', 
                'pengguna.nama', 
                'pengguna.email', 
                'pengguna.role', 
                'pengguna.foto',
                'profil_pegawai.nama_lengkap',
                'profil_pegawai.id as id_profil'
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
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'role'       => $request->role,
            'foto'       => $request->foto ?? 'default.jpg',
        ]);

        return redirect()->back()->with('success', 'User ' . $request->nama . ' berhasil ditambahkan!');
    }

    public function update(Request $request, $nip) 
    {
        // Cari user berdasarkan NIP
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
        DB::transaction(function () use ($nip) {
            // Hapus detail profil
            DB::table('profil_pegawai')->where('nip', $nip)->delete();
            
            // hapus akun penggunanya
            $user = pengguna::where('nip', $nip)->firstOrFail();
            $user->delete();
        });

        return redirect()->back()->with('success', 'User dan Profil terkait telah dihapus!');
    }
}