<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\absensiController;
use App\Http\Controllers\karyawanController;
use App\http\Controllers\penggajianController;
use App\http\Controllers\dashboardController;


//landingPage
Route::get('/', function () {
    return view('landing');
});

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function (){

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //absensi
    Route::get('/absensi', [absensiController::class, 'index'])->name('absensi.index');

    //data karyawan
    Route::resource('karyawan', KaryawanController::class);

    //kelola akses(1)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    //kelola akses(2)
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    //kelola akses(3)
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //penggajian
    Route::get('/penggajian', [PenggajianController::class, 'index']);
    Route::put('/penggajian/{id}/bayar', [PenggajianController::class, 'bayar']);
});