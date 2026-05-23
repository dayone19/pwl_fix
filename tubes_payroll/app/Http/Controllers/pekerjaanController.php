<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;
use App\Models\Keluhan; 
use App\Models\ProfilPegawai; 
use App\Models\Jabatan; 

class pekerjaanController extends Controller
{
   
    public function index()
    {
        $user = Auth::user();

        $jabatanId = $user->profilPegawai?->id_jabatan;

        $pekerjaanList = Pekerjaan::with('keluhan')
                            ->where('id_jabatan', $jabatanId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $totalPekerjaan = $pekerjaanList->count();

        $belumDiambil = $pekerjaanList
                            ->where('status', 'waiting')
                            ->count();

        $sedangDikerjakan = $pekerjaanList
                                ->where('status', 'in_progress')
                                ->count();

        $selesai = $pekerjaanList
                        ->where('status', 'done')
                        ->count();

        $targetHarian = 5;

        $bonus = 0;

        if ($selesai >= $targetHarian) {
            $bonus = 150000;
        }

        $divisi = strtoupper($user->divisi?->nama_divisi);
        $jabatan = strtoupper($user->profilPegawai?->jabatan?->nama_jabatan); 

        $keluhanList = Keluhan::all();

        return view('halaman.pekerjaan', compact(
            'pekerjaanList',
            'totalPekerjaan',
            'belumDiambil',
            'sedangDikerjakan',
            'selesai',
            'targetHarian',
            'bonus',
            'keluhanList',
            'divisi',
            'jabatan',
        ));
    }

    public function ambil($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);

        $pekerjaan->status = 'in_progress';

        $pekerjaan->save();

        return redirect()->back()
            ->with('success', 'Pekerjaan berhasil diambil');
    }

    public function selesai($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);

        $pekerjaan->status = 'done';

        $pekerjaan->save();

        return redirect()->back()
            ->with('success', 'Pekerjaan selesai dikerjakan');
    }

    //untuk input keluhan 
    public function store(Request $request) 
    {
        $request->validate([
            'plat_nomor' => 'required',
            'kendaraan' => 'required',
            'keluhan_id' => 'required',
            'detail_keluhan' => 'required',
        ]);

         $keluhan = Keluhan::find($request->keluhan_id);

        Pekerjaan::create([
            'plat_nomor' => $request->plat_nomor,
            'kendaraan' => $request->kendaraan,
            'keluhan_id' => $request->keluhan_id,
            'detail_keluhan' => $request->detail_keluhan,
            'jabatan_id' => $keluhan->jabatan_id,
            'status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Keluhan berhasil ditambahkan');
    }
}