<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Absensi;
use App\Models\ProfilPegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CutiController extends Controller
{
public function index()
{
    $user   = auth()->user();
    $isHrd  = $user->id_divisi == 2;

    // HRD lihat semua pengajuan, karyawan hanya milik sendiri
    $query = Cuti::orderBy('tanggal_mulai', 'desc');

    if (!$isHrd) {
        $query->where('id_pegawai', $user->id);
    }

    $riwayatCuti = $query->get();

    // Hitung kuota hanya untuk karyawan yang login
    $cutiSaya = $isHrd
        ? collect() // HRD tidak perlu hitung kuota diri sendiri di sini
        : $riwayatCuti;

    $totalCutiDiambil = $cutiSaya
        ->where('status_persetujuan', 'Disetujui')
        ->sum(function ($c) {
            return \Carbon\Carbon::parse($c->tanggal_mulai)
                ->diffInDays(\Carbon\Carbon::parse($c->tanggal_selesai)) + 1;
        });

    $sisaCuti = 12 - $totalCutiDiambil;

    return view('halaman.cuti', compact('riwayatCuti', 'sisaCuti', 'totalCutiDiambil'));
}

public function store(Request $request)
{
    $request->validate([
        'tanggal_mulai'   => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'alasan'          => 'required|string|max:255',
    ]);

    Cuti::create([
        'id_pegawai'         => auth()->id(), // ← pakai id_pegawai
        'tanggal_mulai'      => $request->tanggal_mulai,
        'tanggal_selesai'    => $request->tanggal_selesai,
        'alasan'             => $request->alasan,
        'status_persetujuan' => 'Menunggu', // ← sesuai ENUM
    ]);

    return back()->with('success', 'Pengajuan cuti berhasil dikirim!');
}

public function approve($id)
{
    abort_if(auth()->user()->id_divisi != 2, 403);

    $cuti = Cuti::findOrFail($id);

    if ($cuti->status_persetujuan === 'Disetujui') {
        return back()->with('warning', 'Cuti ini sudah disetujui sebelumnya.');
    }

    $cuti->update([
        'status_persetujuan' => 'Disetujui',
        'disetujui_oleh_id'  => auth()->id(),
    ]);

    // Cari NIP lewat tabel pengguna (bukan profil_pegawai)
    $pengguna = \App\Models\Pengguna::find($cuti->id_pegawai);

    if ($pengguna && $pengguna->nip) {
        $periode = \Carbon\CarbonPeriod::create($cuti->tanggal_mulai, $cuti->tanggal_selesai);
        foreach ($periode as $tanggal) {
            Absensi::updateOrCreate(
                ['nip'     => $pengguna->nip, 'tanggal' => $tanggal->format('Y-m-d')],
                ['status_kehadiran' => 'Cuti', 'jam_masuk' => null, 'jam_keluar' => null, 'menit_terlambat' => 0]
            );
        }
    }

    return back()->with('success', 'Cuti disetujui dan absensi telah diperbarui.');
}

public function tolak($id)
{
    abort_if(auth()->user()->id_divisi != 2, 403);

    $cuti = Cuti::findOrFail($id);
    $cuti->update(['status_persetujuan' => 'Ditolak']); // ← huruf kapital

    return back()->with('success', 'Pengajuan cuti telah ditolak.');
}
};