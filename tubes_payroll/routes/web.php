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
})->name('register');

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

