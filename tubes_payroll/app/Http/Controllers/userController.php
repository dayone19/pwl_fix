<?php

namespace App\Http\Controllers;

use App\Models\pengguna; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan NIP agar rapi
        $users = pengguna::orderBy('nip', 'asc')->paginate(7); 
        return view('halaman.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'        => 'required|string|unique:pengguna,nip', // Pakai NIP
            'nama'       => 'required|string|max:255',             // Pakai nama
            'kata_sandi' => 'required|string|min:8',
            'role'       => 'required',
            'foto'       => 'nullable|string'                      // Bisa dikosongi dulu
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

    public function update(Request $request, $nip) // Parameter pakai $nip
    {
        // Cari user berdasarkan NIP (karena primary key kita nip)
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
        $user = pengguna::where('nip', $nip)->firstOrFail();
        $namaUser = $user->nama;
        $user->delete();

        return redirect()->back()->with('success', 'User ' . $namaUser . ' telah dihapus!');
    }
}