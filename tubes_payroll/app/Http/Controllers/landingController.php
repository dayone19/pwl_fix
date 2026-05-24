<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPegawai;
use App\Models\Pekerjaan; 
use Exception;

class LandingController extends Controller
{
    public function index()
    {
        try {
            $totalKaryawan = ProfilPegawai::count();

            $totalJobOffers = Pekerjaan::where('status', 'waiting')->count();


        } catch (Exception $e) {
            $totalKaryawan = 42;
            $totalJobOffers = 15;
        }

        return view('landing', compact(
            'totalKaryawan', 
            'totalJobOffers'
        ));
    }
}