<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\ProfilPegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // dom pdf untuk ekspor
use Carbon\Carbon; // untuk carbon (tgl)

class AbsensiController extends Controller
{

    public function index(Request $request)
    {
        $query = $this->applyFilter($request);

        $dataAbsen = $query->paginate(7)->onEachSide(1);

        $dataAbsen->getCollection()->transform(function ($item) {
            $item->nama_pegawai = $item->profilPegawai->nama_lengkap ?? 'Tanpa Nama';
            $item->nip = $item->profilPegawai->nip ?? '-';
            return $item;
        });

        return view('halaman.absensi', compact('dataAbsen'));
    }

  
    public function exportPdf(Request $request)
    {
        $dataAbsen = $this->applyFilter($request)->get();

        $dataAbsen->transform(function ($item) {
            $item->nama_pegawai = $item->profilPegawai->nama_lengkap ?? 'Tanpa Nama';
            $item->nip = $item->profilPegawai->nip ?? '-';
            return $item;
        });

        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));
        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        $totalHariKerja = cal_days_in_month(CAL_GREGORIAN, $bulanPilihan, $tahunPilihan);
        $totalKaryawan = $dataAbsen->pluck('nip')->unique()->count();

        $totalHadir = $dataAbsen->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $totalData = $totalKaryawan * $totalHariKerja;
        
        $rataRata = $totalData > 0 ? ($totalHadir / $totalData) * 100 : 0;
        
        $totalTidakHadir = $dataAbsen->whereIn('status', ['Izin', 'Sakit', 'Alpha'])->count();

        $pdf = Pdf::loadView('halaman.absensi_pdf', compact(
            'dataAbsen', 'periodeCarbon', 'bulanPilihan', 'tahunPilihan', 
            'totalKaryawan', 'totalHariKerja', 'rataRata', 'totalTidakHadir'
        ));
        
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Rekap_Absensi_' . $periodeCarbon->format('M_Y') . '.pdf');
    }

    public function pribadi(Request $request)
    {
        // Ambil data Auth user (pengguna) yang login
        $user = Auth::user(); 
        $idUser = $user->id;

        // Filter bulan & tahun
        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));

        $dataAbsensi = Absensi::where('nip', $user->nip ?? $idUser)
                            ->whereMonth('tanggal', $bulanPilihan)
                            ->whereYear('tanggal', $tahunPilihan)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        $pegawai = ProfilPegawai::with('jabatan')->where('nip', $user->nip)->first();
        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        // Pakai carbon biar template tgl dan thn bisa diambil dari tahun dan bulan yg dipilih
        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        return view('halaman.absensi_pribadi', compact(
            'dataAbsensi',
            'user',
            'namaJabatan',
            'bulanPilihan',
            'tahunPilihan',
            'periodeCarbon'
        ));
    }

    public function pribadiPdf(Request $request)
    {
        $user = Auth::user();
        $idUser = $user->id;

        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));

        $dataAbsensi = Absensi::where('nip', $user->nip ?? $idUser) 
                            ->whereMonth('tanggal', $bulanPilihan)
                            ->whereYear('tanggal', $tahunPilihan)
                            ->orderBy('tanggal', 'desc')
                            ->get();

        $pegawai = ProfilPegawai::with('jabatan')->where('nip', $user->nip)->first();
        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';
        
        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        $pdf = Pdf::loadView('halaman.absensi_pribadi_pdf', [
            'dataAbsensi' => $dataAbsensi,
            'user' => $user,
            'namaJabatan' => $namaJabatan,
            'periodeCarbon' => $periodeCarbon
        ]);

        $namaFile = $user->name ?? ($pegawai->nama_lengkap ?? 'Karyawan');
        return $pdf->download('Rekap_Absensi_' . $periodeCarbon->format('M_Y') . '_' . str_replace(' ', '_', $namaFile) . '.pdf');
    }

    private function applyFilter(Request $request)
    {
        $query = Absensi::with('ProfilPegawai');

        // 1. Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereRaw('DAY(tanggal) = ?', [$request->tanggal]);
        }

        // 2. Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // 3. Filter Tahun 
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        return $query->orderBy('tanggal', 'desc');
    }
}