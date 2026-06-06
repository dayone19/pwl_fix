<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\StatistikBulanan;
use App\Models\pengguna; 
use App\Models\ProfilPegawai;
use App\Models\Jabatan;
use App\Models\Penggajian;
use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        $cutiDiambil = Cuti::where('id_pegawai', $user->id)
        ->where('status_persetujuan', 'Disetujui')
        ->get()
        ->sum(function ($cuti) {
            return Carbon::parse($cuti->tanggal_mulai)
                ->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;
        });

        $cutiPending = Cuti::where('id_pegawai', $user->id)
        ->where('status_persetujuan', 'Menunggu')
        ->get()
        ->sum(function ($cuti) {
            return Carbon::parse($cuti->tanggal_mulai)
                ->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;
        });

        $tahunDipilih = $request->input('tahun', date('Y'));

        $rawDatabaseData = DB::table('statistik_bulanan')
                    ->where('tahun', $tahunDipilih)
                    ->orderBy('bulan', 'asc')
                    ->get();

        $gajiBulanan = array_fill(1, 12, 0);   
        
        foreach ($rawDatabaseData as $data) {
            $gajiBulanan[$data->bulan] = $data->total_biaya;
        }

        $chartData = array_values($gajiBulanan);

        $namaBulan = Carbon::now()->translatedFormat('F');

        $bulanSekarang = now()->month;
        $tahunSekarang = now()->year;

        $totalPayroll = StatistikBulanan::where('bulan', $bulanSekarang)
            ->where('tahun', $tahunSekarang)
            ->value('total_biaya') ?? 0;

        return view('dashboard', compact(
            'user',
            'users', 
            'totalPegawai', 
            'stats',
            'namaJabatan',
            'sudahDibayar',
            'belumDibayar',
            'cutiDiambil',
            'cutiPending', 
            'tahunDipilih', 
            'chartData',
            'totalPayroll',
            'namaBulan',
        ));
    }
}