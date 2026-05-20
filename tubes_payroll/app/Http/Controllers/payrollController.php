<?php

namespace App\Http\Controllers;

use App\Models\Penggajian; 
use App\Models\Pengguna;
use App\Services\LogikaGaji; 
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $LogikaGaji;

    public function __construct(LogikaGaji $LogikaGaji)
    {
        $this->LogikaGaji = $LogikaGaji;
    }

    public function dataPayroll()
    {
        $userId = auth()->id(); 
        
        $user = Pengguna::with(['profil.jabatan.gajiMaster', 'divisi'])->find($userId);

        $bulan = date('m');
        $tahun = date('Y');
        
        $this->LogikaGaji->hitungDanSimpanGaji(collect([$user]), $bulan, $tahun);

        $bulanTerbaru = Penggajian::where('id_pegawai', $userId)
                                    ->where('bulan', $bulan)
                                    ->first();
                                    
        $bulanLalu = Penggajian::where('id_pegawai', $userId) 
                                ->orderBy('bulan', 'desc')
                                ->get();
                                        
        return view('halaman.payroll', compact('bulanTerbaru', 'bulanLalu', 'user'));
    }

    public function manage()
    {
        $karyawan = Pengguna::with(['profil.jabatan.gajiMaster'])
                            ->withCount(['absensi', 'cuti'])
                            ->get();

        $bulan = date('m');
        $tahun = date('Y');

        $totalPengeluaran = $this->LogikaGaji->hitungDanSimpanGaji($karyawan, $bulan, $tahun);

        return view('halaman.manage', [
            'karyawan'         => $karyawan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPegawai'     => $karyawan->count()
        ]);
    }

    public function bayar($id)
    {
        $gaji = Penggajian::findOrFail($id);
        $gaji->status_bayar = 'Dibayar';
        $gaji->save();

        return back();
    }
}