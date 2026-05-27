<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\ProfilPegawai;
use App\Models\AbsensiImport;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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

        $pegawai = ProfilPegawai::orderBy('nama_lengkap')->get();

        return view('halaman.absensi', compact('dataAbsen', 'pegawai'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->id_divisi != 2, 403);

        $request->validate([
            'file_absen' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file_absen.required' => 'File absen wajib diupload.',
            'file_absen.mimes'    => 'Format file harus XLS, XLSX, atau CSV.',
            'file_absen.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $import = new \App\Models\AbsensiImport();

        \Maatwebsite\Excel\Facades\Excel::import(
            $import,
            $request->file('file_absen')
        );

        $pesan = "Berhasil import {$import->berhasil} data absen.";

        if (!empty($import->gagal)) {

            $pesanGagal = implode(' | ', $import->gagal);

            return back()
                ->with('success', $pesan)
                ->with('warning', "Baris dilewati: {$pesanGagal}");
        }

        return back()->with('success', $pesan);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_absensi.csv"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            // Header kolom
            fputcsv($file, [
                'nip',
                'nama',
                'tanggal',
                'jam_masuk',
                'jam_keluar',
                'status'
            ]);

            // Ambil semua pegawai
            $pegawai = ProfilPegawai::orderBy('nama_lengkap')->get();

            // Isi otomatis
            foreach ($pegawai as $p) {

                fputcsv($file, [
                    $p->nip,
                    $p->nama_lengkap,
                    now()->format('d/m/Y'),
                    '',
                    '',
                    ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Absensi::with('profilPegawai');

if ($request->filled('bulan')) {
    $query->whereMonth('tanggal', $request->bulan);
}

if ($request->filled('tahun')) {
    $query->whereYear('tanggal', $request->tahun);
}

$dataAbsen = $query->orderBy('tanggal')->get();

        $dataAbsen->transform(function ($item) {
            $item->nama_pegawai = $item->profilPegawai->nama_lengkap ?? 'Tanpa Nama';
            $item->nip = $item->profilPegawai->nip ?? '-';
            return $item;
        });

        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));

        $periodeCarbon = Carbon::createFromDate(
            $tahunPilihan,
            $bulanPilihan,
            1
        );

        $totalHariKerja = cal_days_in_month(
            CAL_GREGORIAN,
            $bulanPilihan,
            $tahunPilihan
        );

        $totalKaryawan = $dataAbsen->pluck('nip')->unique()->count();

        $totalHadir = $dataAbsen->filter(function ($item) {
    $status = strtoupper(trim($item->status_kehadiran));

    return in_array($status, [
        'HADIR',
        'H',
        'TERLAMBAT',
        'TL'
    ]);
})->count();

        $totalData = $totalKaryawan * $totalHariKerja;

        $rataRata = $totalData > 0
            ? ($totalHadir / $totalData) * 100
            : 0;

        $totalTidakHadir = $dataAbsen->filter(function ($item) {
    $status = strtoupper(trim($item->status_kehadiran));

    return in_array($status, [
        'IZIN',
        'I',
        'SAKIT',
        'S',
        'ALPHA',
        'ALPA',
        'A'
    ]);
})->count();

        $pdf = Pdf::loadView(
            'halaman.absensi_pdf',
            compact(
                'dataAbsen',
                'periodeCarbon',
                'bulanPilihan',
                'tahunPilihan',
                'totalKaryawan',
                'totalHariKerja',
                'rataRata',
                'totalTidakHadir'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'Rekap_Absensi_' .
            $periodeCarbon->format('M_Y') .
            '.pdf'
        );
    }

    public function pribadi(Request $request)
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

        $pegawai = ProfilPegawai::with('jabatan')
            ->where('nip', $user->nip)
            ->first();

        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        $periodeCarbon = Carbon::createFromDate(
            $tahunPilihan,
            $bulanPilihan,
            1
        );

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

        $pegawai = ProfilPegawai::with('jabatan')
            ->where('nip', $user->nip)
            ->first();

        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        $periodeCarbon = Carbon::createFromDate(
            $tahunPilihan,
            $bulanPilihan,
            1
        );

        $pdf = Pdf::loadView('halaman.absensi_pribadi_pdf', [
            'dataAbsensi'   => $dataAbsensi,
            'user'          => $user,
            'namaJabatan'   => $namaJabatan,
            'periodeCarbon' => $periodeCarbon,
        ]);

        $namaFile = $user->name
            ?? ($pegawai->nama_lengkap ?? 'Karyawan');

        return $pdf->download(
            'Rekap_Absensi_' .
            $periodeCarbon->format('M_Y') .
            '_' .
            str_replace(' ', '_', $namaFile) .
            '.pdf'
        );
    }

    private function applyFilter(Request $request)
    {
        $query = Absensi::with('profilPegawai');

        if ($request->filled('tanggal')) {
            $query->whereRaw(
                'DAY(tanggal) = ?',
                [$request->tanggal]
            );
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        return $query->orderBy('tanggal', 'desc');
    }
}