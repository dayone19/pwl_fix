<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\StatistikBulanan;
use App\Models\pengguna; 
use App\Models\ProfilPegawai;
use App\Models\Jabatan;
use App\Models\Penggajian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idUser = $user->id;

        if (!$user) {
            return redirect()->route('login');
        }

        $users = pengguna::orderBy('nip', 'asc')->paginate(7);

        $pegawai = ProfilPegawai::with('jabatan')->where('nip', $user->nip)->first();
        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        $totalPegawai = pengguna::count();
        $stats = StatistikBulanan::orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        $sudahDibayar = Penggajian::where('status_bayar', 'Dibayar')
            ->count();

        $belumDibayar = Penggajian::whereIn('status_bayar', [
            'Draft',
            'Terbit',
            'Approved'
        ])->count();

        return view('dashboard', compact(
            'user',
            'users', 
            'totalPegawai', 
            'stats',
            'namaJabatan',
            'sudahDibayar',
            'belumDibayar'
        ));
    }
}