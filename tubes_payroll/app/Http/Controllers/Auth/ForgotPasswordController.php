<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgotpw');
    }
}