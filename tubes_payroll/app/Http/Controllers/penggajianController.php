<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::all();

        return view('penggajian.index', compact('penggajian'));
    }

    public function bayar($id)
    {
        $gaji = Penggajian::findOrFail($id);

        $gaji->status_bayar = 'Dibayar';
        $gaji->save();

        return back();
    }
}