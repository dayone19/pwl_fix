<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\statistik_bulanan;
use App\Models\pengguna; 

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login (untuk bagian Header/Profil)
        $user = Auth::user();

        // Proteksi jika session hilang
        if (!$user) {
            return redirect()->route('login');
        }

        // 2. Ambil daftar semua user untuk tabel
        $users = pengguna::orderBy('nip', 'asc')->paginate(7);

        // 3. Ambil data statistik pendukung
        $totalPegawai = pengguna::count();
        $stats = statistik_bulanan::orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        // 4. Kirim ke view 
        return view('dashboard', compact('user', 'users', 'totalPegawai', 'stats'));
    }
}