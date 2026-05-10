<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\pengguna; // Panggil model pengguna kamu

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
{
    // 1. Validasi input
    $credentials = $request->validate([
        'nip'        => 'required',
        'kata_sandi' => 'required',
        'role'       => 'required'
    ]);

    // 2. Cek login 
    if (Auth::attempt([
    'nip'      => $request->nip, 
    'password' => $request->kata_sandi, 
    'role'     => $request->role
])) {
    $request->session()->regenerate();
    return redirect()->intended('dashboard');
}

    // 3. Jika gagal
    return back()->withErrors(['nip' => 'Kombinasi ID, Password, atau Posisi salah.'])->withInput();
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}