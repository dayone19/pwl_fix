<?php

use Illuminate\Support\Facades\Route;

//landingPage
Route::get('/', function () {
    return view('landingPage'); 
});

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
<<<<<<< HEAD
})->name('register');

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
=======
})->name('register');
>>>>>>> e38b9265fce7bbff01ba75a29d670295788eff97
