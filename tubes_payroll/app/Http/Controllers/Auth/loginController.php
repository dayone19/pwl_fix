<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\pengguna; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip'         => 'required',
            'kata_sandi'  => 'required',
            'id_divisi'   => 'required' 
        ]);

        if (Auth::attempt([
            'nip'      => $request->nip, 
            'password' => $request->kata_sandi, 
        ])) {
            
            $user = Auth::user();

            if ($user->id_divisi == $request->id_divisi) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            Auth::logout();
        }

        return back()->withErrors(['nip' => 'Kombinasi ID, Password, atau Divisi salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}