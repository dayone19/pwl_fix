<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\absensi;
use App\Models\profil_pegawai;

class AbsensiController extends Controller
{
    public function index()
    {
        $dataAbsen = absensi::with('pegawai')
            ->orderBy('tanggal', 'desc')
            ->paginate(7) 
            ->onEachSide(1);

        $dataAbsen->getCollection()->transform(function ($item) {
            $item->nama_pegawai = $item->pegawai->nama_lengkap ?? 'Tanpa Nama';
            $item->nip = $item->pegawai->nip ?? '-';
            return $item;
        });

        return view('halaman.absensi', compact('dataAbsen'));
    }
}