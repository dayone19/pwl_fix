<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;
use App\Models\Keluhan; 
use App\Models\ProfilPegawai; 
use App\Models\Jabatan; 
use App\Models\TerimaKerjaan; 
use Illuminate\Support\Facades\DB;

class pekerjaanController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $idTeknisi = auth()->user()->id;
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

        $selesai = TerimaKerjaan::where('teknisi_id', $idTeknisi) 
                                ->where('status', 'done')
                                ->whereMonth('selesai_pada', date('m'))
                                ->whereYear('selesai_pada', date('Y'))
                                ->count();

        $targetHarian = 5;
        $bonusPerpekerjaan = 20000;

        $bonus = 0;

        if ($selesai >= $targetHarian) {
            $kelipatan = floor($selesai / $targetHarian);
            $bonus = $kelipatan * $bonusPerpekerjaan;
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

        $teknisiId = Auth::user()->profilPegawai?->id;

        TerimaKerjaan::create([
            'pekerjaan_id' => $pekerjaan->pekerjaan_id,
            'teknisi_id' => $teknisiId,
            'status' => 'in_progress',
        ]);

        return redirect()->back()
            ->with('success', 'Pekerjaan berhasil diambil');
    }

    public function selesai($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);

        $pekerjaan->status = 'done';

        $pekerjaan->save();

        TerimaKerjaan::where('pekerjaan_id', $id)
        ->where('status', 'in_progress')
        ->update([
            'status' => 'done',
            'selesai_pada'   => now() 
        ]);

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
            'id_jabatan' => $keluhan->jabatan_id,
            'status' => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Keluhan berhasil ditambahkan');
    }
}