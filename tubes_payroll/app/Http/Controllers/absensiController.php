<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absensi;
use App\Models\profil_pegawai;

class AbsensiController extends Controller
{
    public function index()
    {
        // 1. Ganti .get() menjadi .paginate(10) agar pagination muncul
        // 2. Tambahkan .onEachSide(1) agar angka tidak kepanjangan
        $dataAbsen = absensi::with('pegawai')
            ->orderBy('tanggal', 'desc')
            ->paginate(7) 
            ->onEachSide(1);

        // Mapping manual (Opsional) jika di Blade kamu memanggil $item->nama_pegawai 
        // secara langsung (bukan $item->pegawai->nama_lengkap)
        $dataAbsen->getCollection()->transform(function ($item) {
            $item->nama_pegawai = $item->pegawai->nama_lengkap ?? 'Tanpa Nama';
            $item->nip = $item->pegawai->nip ?? '-';
            return $item;
        });

        return view('halaman.absensi', compact('dataAbsen'));
    }
}