<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\absensiController;
use App\Http\Controllers\karyawanController;
use App\http\Controllers\payrollController;
use App\http\Controllers\dashboardController;
use App\Http\Controllers\CutiController;

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
    Route::get('/hitung-payroll', [PayrollController::class, 'dataPayroll'])->name('payroll.index');
    Route::get('/payroll/manage', [PayrollController::class, 'manage'])->name('payroll.manage');
    
    //pengajuan cuti
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');

    // Proses kirim formulir pengajuan cuti
    Route::post('/cuti/ajukan', [CutiController::class, 'store'])->name('cuti.store');
});