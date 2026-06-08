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
        ? collect() 
        : $riwayatCuti;

    $totalCutiDiambil = $cutiSaya
    ->where('status_persetujuan', 'Disetujui')
    ->where('jenis_pengajuan', 'Cuti')
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
    'jenis_pengajuan' => 'required|in:Keperluan,Cuti',
    'bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
]);

$namaFile = null;

if ($request->hasFile('bukti')) {
    $namaFile = time().'_'.$request->file('bukti')->getClientOriginalName();

    $request->file('bukti')->move(
        public_path('uploads/bukti_cuti'),
        $namaFile
    );
}

    // Cek pengajuan cuti yang bentrok
    $adaCutiBentrok = Cuti::where('id_pegawai', auth()->id())
        ->whereIn('status_persetujuan', ['Menunggu', 'Disetujui'])
        ->where(function ($query) use ($request) {
            $query->whereBetween('tanggal_mulai', [
                    $request->tanggal_mulai,
                    $request->tanggal_selesai
                ])
                ->orWhereBetween('tanggal_selesai', [
                    $request->tanggal_mulai,
                    $request->tanggal_selesai
                ])
                ->orWhere(function ($q) use ($request) {
                    $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                      ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                });
        })
        ->exists();

    if ($adaCutiBentrok) {
        return back()->with(
            'error',
            'Pengajuan cuti tidak dapat diproses karena terdapat pengajuan cuti lain pada rentang tanggal yang sama.'
        );
    }

    // Hitung total cuti yang sudah disetujui
    $totalCutiDiambil = Cuti::where('id_pegawai', auth()->id())
        ->where('status_persetujuan', 'Disetujui')
        ->where('jenis_pengajuan', 'Cuti')
        ->get()
        ->sum(function ($cuti) {
            return Carbon::parse($cuti->tanggal_mulai)
                ->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;
        });

    if ($totalCutiDiambil >= 12) {
        return back()->with(
            'error',
            'Kuota cuti tahunan Anda telah habis (12/12 hari).'
        );
    }

    // Durasi cuti yang diajukan
    $durasiPengajuan = Carbon::parse($request->tanggal_mulai)
        ->diffInDays(Carbon::parse($request->tanggal_selesai)) + 1;

    $sisaCuti = 12 - $totalCutiDiambil;

    if ($durasiPengajuan > $sisaCuti) {
        return back()->with(
            'error',
            "Pengajuan cuti melebihi kuota yang tersedia. Sisa cuti Anda hanya {$sisaCuti} hari."
        );
    }

    Cuti::create([
        'id_pegawai'         => auth()->id(),
        'tanggal_mulai'      => $request->tanggal_mulai,
        'tanggal_selesai'    => $request->tanggal_selesai,
        'alasan'             => $request->alasan,
        'status_persetujuan' => 'Menunggu', 
        'jenis_pengajuan' => $request->jenis_pengajuan,
        'bukti' => $namaFile,
    ]);

    return back()->with(
        'success',
        'Pengajuan cuti berhasil dikirim dan menunggu persetujuan.'
    );
}

public function approve($id)
{
    abort_if(auth()->user()->id_divisi != 2, 403);

    $cuti = Cuti::findOrFail($id);

    if ($cuti->status_persetujuan === 'Disetujui') {
        return back()->with('warning', 'Pengajuan ini sudah disetujui sebelumnya.');
    }

    $cuti->update([
        'status_persetujuan' => 'Disetujui',
        'disetujui_oleh_id'  => auth()->id(),
    ]);

    $pengguna = \App\Models\Pengguna::find($cuti->id_pegawai);

    if ($pengguna && $pengguna->nip) {

        // Tentukan status absensi
        $statusAbsensi =
            $cuti->jenis_pengajuan === 'Keperluan'
                ? 'Izin'
                : 'Cuti';

        $periode = CarbonPeriod::create(
            $cuti->tanggal_mulai,
            $cuti->tanggal_selesai
        );

        foreach ($periode as $tanggal) {

            Absensi::updateOrCreate(
                [
                    'nip'     => $pengguna->nip,
                    'tanggal' => $tanggal->format('Y-m-d')
                ],
                [
                    'status_kehadiran' => $statusAbsensi,
                    'jam_masuk'        => null,
                    'jam_keluar'       => null,
                    'menit_terlambat'  => 0
                ]
            );

        }
    }

    return back()->with(
        'success',
        'Pengajuan berhasil disetujui dan absensi diperbarui.'
    );
}

public function tolak($id)
{
    abort_if(auth()->user()->id_divisi != 2, 403);

    $cuti = Cuti::findOrFail($id);
    $cuti->update(['status_persetujuan' => 'Ditolak']); 

    return back()->with('success', 'Pengajuan cuti telah ditolak.');
}
};