<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth'])->group(function (){
    //dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 7. USER MANAGEMENT / AKSES KONTROL (SYSTEM AREA)
    // Gunakan UserController hanya untuk menampilkan daftar (index), update, dan hapus.
    // Pendaftaran akun baru sudah di-handle oleh KaryawanController@store
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});