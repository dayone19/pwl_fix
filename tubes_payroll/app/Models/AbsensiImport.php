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

        // 1. Konversi Tanggal
        try {
            if (is_numeric($tanggal)) {
                $tanggalParsed = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal))->format('Y-m-d');
            } else {
                $tanggalParsed = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            $tanggalParsed = Carbon::now()->format('Y-m-d');
        }

        // 2. Cek Duplikasi
        $cekDuplikasi = Absensi::where('nip', $nip)->where('tanggal', $tanggalParsed)->first();
        if ($cekDuplikasi) {
            $this->gagal[] = "NIP {$nip}: sudah ada absen tanggal {$tanggalParsed}";
            return null;
        }

        // 3. Bersihkan jam_masuk & jam_keluar untuk tipe data TIME
        if ($masuk == '-' || $masuk == '?' || trim($masuk) == '') {
            $masuk = null;
        }
        if ($keluar == '-' || $keluar == '?' || trim($keluar) == '') {
            $keluar = null;
        }

        // 4. Hitung Keterlambatan
        $menitTerlambat = 0;
        if ($masuk && strtolower($status) == 'hadir') {
            try {
                $jamMasukCarbon = Carbon::parse($masuk);
                $jamBatas = Carbon::parse('08:00');
                
                if ($jamMasukCarbon->gt($jamBatas)) {
                    $menitTerlambat = $jamMasukCarbon->diffInMinutes($jamBatas);
                }
            } catch (\Exception $e) {
                $menitTerlambat = 0;
            }
        }

        // 5. Validasi String ENUM agar Sesuai dengan Database ('Hadir', 'Izin', 'Sakit', 'Alpha')
        $statusClean = ucfirst(strtolower(trim($status))); 
        if (!in_array($statusClean, ['Hadir', 'Izin', 'Sakit', 'Alpha'])) {
            $statusClean = 'Hadir';
        }

        $this->berhasil++;

        return new Absensi([
            'nip'              => (string)$nip,
            'tanggal'          => $tanggalParsed,
            'jam_masuk'        => $masuk,
            'jam_keluar'       => $keluar,
            'status_kehadiran' => $statusClean, 
            'menit_terlambat'  => (int)$menitTerlambat,
        ]);
    }
}