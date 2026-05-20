<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Ambil riwayat cuti (Kunci hanya untuk user login)
        $riwayatCuti = Cuti::where('id_pegawai', $userId)
                            ->orderBy('tanggal_mulai', 'desc')
                            ->get();

        // 2. Hitung Sisa Kuota (Asumsi jatah 12 hari setahun)
        // Kita hanya hitung yang statusnya 'disetujui'
        $totalCutiDiambil = $riwayatCuti->where('status', 'disetujui')->sum('durasi');
        $sisaCuti = 12 - $totalCutiDiambil;

        return view('halaman.cuti', compact('riwayatCuti', 'sisaCuti', 'totalCutiDiambil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        // Hitung durasi hari
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $durasi = $mulai->diffInDays($selesai) + 1; // +1 agar hari mulai ikut dihitung

        // Simpan data
        Cuti::create([
            'id_pegawai' => auth()->id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $durasi,
            'alasan' => $request->alasan,
            'status' => 'pending', // Default saat diajukan
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil dikirim!');
    }
}