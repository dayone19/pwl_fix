<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\StatistikBulanan;
use App\Models\pengguna; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $users = pengguna::orderBy('nip', 'asc')->paginate(7);

        $totalPegawai = pengguna::count();
        $stats = StatistikBulanan::orderBy('tahun', 'desc')
                                    ->orderBy('bulan', 'desc')
                                    ->first();

        return view('dashboard', compact('user', 'users', 'totalPegawai', 'stats'));
    }
}