<?php

namespace App\Services;

use App\Models\Penggajian;
use App\Models\RincianGaji;
use App\Models\Gaji; 
use Illuminate\Support\Facades\DB;

class LogikaGaji
{
    public function hitungDanSimpanGaji($karyawan, $bulan, $tahun)
    {
        return DB::transaction(function () use ($karyawan, $bulan) {
            $totalPayrollPerusahaan = 0;

            foreach ($karyawan as $k) {
                $jabatan = $k->profil->jabatan ?? null; 
                $idGajiMaster = $jabatan ? $jabatan->id_gaji : null;

                $slip = Penggajian::updateOrCreate(
                    ['id_pegawai' => $k->id, 'bulan' => $bulan],
                    [
                        'id_gaji'      => $idGajiMaster,
                        'nip'          => $k->nip,
                        'status_bayar' => 'Draft',
                        'gaji_bersih'  => 0 
                    ]
                );

                $masterGaji = $idGajiMaster ? Gaji::find($idGajiMaster) : null;
                $gapok = $masterGaji ? $masterGaji->gaji : 0;

                $this->simpanRincian($slip->id, 1, $gapok);

                if (strtolower($k->role ?? '') === 'magang') {
                    $tunjangan = ($k->absensi_count ?? 0) * 35000;
                } else {
                    $tunjangan = $gapok * 0.15;
                }
                $this->simpanRincian($slip->id, 2, $tunjangan);

                $potonganAlpha = $this->hitungPotonganAlpha($k, $gapok);
                $potonganTelat = $this->hitungPotonganTelat($k);
                $this->simpanRincian($slip->id, 5, $potonganAlpha + $potonganTelat);

                $gajiBruto = $gapok + $tunjangan - ($potonganAlpha + $potonganTelat);
                $pajak = $this->hitungPPh21($gajiBruto);
                $this->simpanRincian($slip->id, 6, $pajak);

                $gajiBersih = $gajiBruto - $pajak;
                $slip->update(['gaji_bersih' => $gajiBersih]);

                $totalPayrollPerusahaan += $gajiBersih;
            }

            return $totalPayrollPerusahaan;
        });
    }

    private function simpanRincian($idPenggajian, $idKomponen, $jumlah)
    {
        if ($jumlah > 0) {
            RincianGaji::create([
                'id_penggajian' => $idPenggajian,
                'id_komponen'   => $idKomponen,
                'jumlah'        => $jumlah
            ]);
        }
    }

    private function hitungPotonganAlpha($k, $gapok)
    {
        $gajiHarian = ($gapok > 0) ? $gapok / 22 : 0;
        return ($k->jumlah_alpha ?? 0) * $gajiHarian;
    }

    private function hitungPotonganTelat($k)
    {
        $denda = (strtolower($k->role ?? '') === 'magang') ? 15000 : 50000;
        return ($k->jumlah_telat ?? 0) * $denda;
    }

    private function hitungPPh21($bruto)
    {
        return ($bruto > 5000000) ? ($bruto - 5000000) * 0.05 : 0;
    }
}