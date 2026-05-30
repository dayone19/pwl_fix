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

    public function downloadTemplate(Request $request)
    {
        $tanggal = $request->input('tanggal', now('Asia/Jakarta')->format('d'));
        $bulan   = $request->input('bulan', now('Asia/Jakarta')->format('m'));
        $tahun   = $request->input('tahun', now('Asia/Jakarta')->format('Y'));

        $hari = sprintf('%02d/%02d/%04d', $tanggal, $bulan, $tahun);

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_absensi_' . sprintf('%02d-%02d-%04d', $tanggal, $bulan, $tahun) . '.csv"',
        ];

        $callback = function () use ($hari) {
            $file    = fopen('php://output', 'w');
            $pegawai = ProfilPegawai::orderBy('nama_lengkap')->get();

            fputcsv($file, ['nip', 'nama', 'tanggal', 'jam_masuk', 'jam_keluar', 'status']);

            foreach ($pegawai as $p) {
                fputcsv($file, [
                    $p->nip,
                    $p->nama_lengkap,
                    $hari,
                    '08:00',
                    '17:00',
                    'Hadir',
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

        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        $totalHariKerja = cal_days_in_month(CAL_GREGORIAN, $bulanPilihan, $tahunPilihan);

        $totalKaryawan = $dataAbsen->pluck('nip')->unique()->count();

        $totalHadir = $dataAbsen->filter(function ($item) {
            $status = strtoupper(trim($item->status_kehadiran));
            return in_array($status, ['HADIR', 'H', 'TERLAMBAT', 'TL']);
        })->count();

        $totalData = $totalKaryawan * $totalHariKerja;
        $rataRata  = $totalData > 0 ? ($totalHadir / $totalData) * 100 : 0;

        $totalTidakHadir = $dataAbsen->filter(function ($item) {
            $status = strtoupper(trim($item->status_kehadiran));
            return in_array($status, ['IZIN', 'I', 'SAKIT', 'S', 'ALPHA', 'ALPA', 'A']);
        })->count();

        $pdf = Pdf::loadView('ekspor_pdf.absensi_pdf', compact(
            'dataAbsen', 'periodeCarbon', 'bulanPilihan', 'tahunPilihan',
            'totalKaryawan', 'totalHariKerja', 'rataRata', 'totalTidakHadir'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Rekap_Absensi_' . $periodeCarbon->format('M_Y') . '.pdf');
    }

    public function pribadi(Request $request)
    {
        $user   = Auth::user();
        $idUser = $user->id;

        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));

        $dataAbsensi = Absensi::where('nip', $user->nip ?? $idUser)
            ->whereMonth('tanggal', $bulanPilihan)
            ->whereYear('tanggal', $tahunPilihan)
            ->orderBy('tanggal', 'desc')
            ->get();

        $pegawai     = ProfilPegawai::with('jabatan')->where('nip', $user->nip)->first();
        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        return view('halaman.absensi_pribadi', compact(
            'dataAbsensi', 'user', 'namaJabatan',
            'bulanPilihan', 'tahunPilihan', 'periodeCarbon'
        ));
    }

    public function pribadiPdf(Request $request)
    {
        $user   = Auth::user();
        $idUser = $user->id;

        $bulanPilihan = $request->input('bulan', date('m'));
        $tahunPilihan = $request->input('tahun', date('Y'));

        $dataAbsensi = Absensi::where('nip', $user->nip ?? $idUser)
            ->whereMonth('tanggal', $bulanPilihan)
            ->whereYear('tanggal', $tahunPilihan)
            ->orderBy('tanggal', 'desc')
            ->get();

        $pegawai     = ProfilPegawai::with('jabatan')->where('nip', $user->nip)->first();
        $namaJabatan = $pegawai?->jabatan?->nama_jabatan ?? 'Karyawan';

        $periodeCarbon = Carbon::createFromDate($tahunPilihan, $bulanPilihan, 1);

        $pdf = Pdf::loadView('ekspor_pdf.absensi_pribadi_pdf', [
            'dataAbsensi'   => $dataAbsensi,
            'user'          => $user,
            'namaJabatan'   => $namaJabatan,
            'periodeCarbon' => $periodeCarbon,
        ]);

        $namaFile = $user->name ?? ($pegawai->nama_lengkap ?? 'Karyawan');

        return $pdf->download(
            'Rekap_Absensi_' . $periodeCarbon->format('M_Y') . '_' . str_replace(' ', '_', $namaFile) . '.pdf'
        );
    }

    public function update(Request $request, $id)
    {
        abort_if(auth()->user()->id_divisi != 2, 403);

        $request->validate([
            'jam_masuk'        => 'nullable|date_format:H:i',
            'jam_keluar'       => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpha',
        ]);

        $absensi = Absensi::findOrFail($id);

        $menitTerlambat = 0;
        $status         = $request->status_kehadiran;
        $jamMasukInput  = $request->jam_masuk ? substr($request->jam_masuk, 0, 5) : null;

        if ($jamMasukInput && in_array($status, ['Hadir', 'Terlambat'])) {
            [$jam, $menit] = explode(':', $jamMasukInput);
            $totalMenitMasuk = ((int)$jam * 60) + (int)$menit;
            $totalMenitBatas = 8 * 60;

            if ($totalMenitMasuk > $totalMenitBatas) {
                $menitTerlambat = $totalMenitMasuk - $totalMenitBatas;
                $status         = 'Terlambat';
            }
        }

        $absensi->update([
            'jam_masuk'        => $jamMasukInput,
            'jam_keluar'       => $request->jam_keluar ? substr($request->jam_keluar, 0, 5) : null,
            'status_kehadiran' => $status,
            'menit_terlambat'  => $menitTerlambat,
        ]);

        return back()->with('success', 'Data absensi berhasil diperbarui.');
    }

    // ↓↓↓ HANYA BAGIAN INI YANG DIUBAH ↓↓↓
    private function applyFilter(Request $request)
    {
        $query = Absensi::with('profilPegawai');

        if ($request->filled('tanggal')) {
            $query->whereRaw('DAY(tanggal) = ?', [$request->tanggal]);
        }

        // Default bulan & tahun sekarang kalau tidak ada filter
        $bulan = $request->filled('bulan') ? $request->bulan : date('m');
        $tahun = $request->filled('tahun') ? $request->tahun : date('Y');

        $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);

        return $query->orderBy('tanggal', 'desc');
    }
}