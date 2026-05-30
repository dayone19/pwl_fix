<?php

namespace App\Models;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class AbsensiImport implements ToModel, WithHeadingRow
{
    public $berhasil = 0;
    public $gagal = [];

    public function model(array $row)
    {
        $nip     = $row['nip'] ?? null;
        $tanggal = $row['tanggal'] ?? null;
        $masuk   = $row['jam_masuk'] ?? null;
        $keluar  = $row['jam_keluar'] ?? null;
        $status  = $row['status'] ?? 'Hadir';

        if (!$nip || !$tanggal) {
            return null;
        }

        // 1. Konversi tanggal
try {
    if (is_numeric($tanggal)) {
        $tanggalParsed = Carbon::instance(
            \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)
        )->format('Y-m-d');
    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
        $tanggalParsed = $tanggal;
    } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggal)) {
        $tanggalParsed = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');
    } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $tanggal)) {
        $tanggalParsed = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');
    } else {
        $tanggalParsed = Carbon::parse($tanggal)->format('Y-m-d');
    }
} catch (\Exception $e) {
    $this->gagal[] = "NIP {$nip}: format tanggal tidak dikenali ({$tanggal})";
    return null;
}

        // 2. Cek duplikasi
        $cekDuplikasi = Absensi::where('nip', $nip)
            ->where('tanggal', $tanggalParsed)
            ->first();

        if ($cekDuplikasi) {
            $this->gagal[] = "NIP {$nip}: sudah ada absen tanggal {$tanggalParsed}";
            return null;
        }

        // 3. Bersihkan jam masuk & keluar
        if ($masuk == '-' || $masuk == '?' || trim((string)$masuk) == '') {
            $masuk = null;
        }

        if ($keluar == '-' || $keluar == '?' || trim((string)$keluar) == '') {
            $keluar = null;
        }

        // 4. Bersihkan status
        $statusClean = ucfirst(strtolower(trim($status)));

        if (!in_array($statusClean, [
            'Hadir',
            'Izin',
            'Sakit',
            'Alpha'
        ])) {
            $statusClean = 'Hadir';
        }

        // 5. Hitung keterlambatan otomatis
        $menitTerlambat = 0;

        if ($masuk && $statusClean == 'Hadir') {
            try {
                $jamMasukCarbon = Carbon::parse($masuk);
                $jamBatas = Carbon::parse('08:00');

                if ($jamMasukCarbon->gt($jamBatas)) {
                    $menitTerlambat = $jamBatas->diffInMinutes($jamMasukCarbon);

                    // otomatis ubah status jadi terlambat
                    $statusClean = 'Terlambat';
                }
            } catch (\Exception $e) {
                $menitTerlambat = 0;
            }
        }

        $this->berhasil++;

        return new Absensi([
            'nip'                 => (string)$nip,
            'tanggal'             => $tanggalParsed,
            'jam_masuk'           => $masuk,
            'jam_keluar'          => $keluar,
            'status_kehadiran'    => $statusClean,
            'menit_terlambat'     => (int)$menitTerlambat,
]);
    }
}