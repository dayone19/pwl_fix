<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\absensiController;
use App\Http\Controllers\karyawanController;
use App\http\Controllers\payrollController;
use App\http\Controllers\dashboardController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\pekerjaanController;
use App\Http\Controllers\LandingController;

// Landing
Route::get('/', [LandingController::class, 'index'])->name('landing');

//Login
Route::get('/login', [LoginController::class, 'showLoginForm'])
->middleware([
        'guest',
        'prevent-back-history',
    ])
->name('login');
Route::post('/login', [LoginController::class, 'login'])//cek brp x gagal login
    ->middleware([
        'check.lockout'
    ]);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'prevent-back-history'
])->group(function (){

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //absensi
    Route::get('/absensi', [absensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.pdf');//untuk pdf nya
    Route::get('/absensi/pribadi', [absensiController::class, 'pribadi'])->name('absensi.pribadi');//untuk absensi peibadi
    Route::get('/absensi/pribadi/pdf', [absensiController::class, 'pribadiPdf'])->name('absensi.pribadi.pdf');//untuk expor pdf
    Route::post('/absensi/import', [absensiController::class, 'store'])->name('absensi.store');           // ← ganti dari /store
    Route::get('/absensi/template', [absensiController::class, 'downloadTemplate'])->name('absensi.template'); // ← tambah ini

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

    //pekerjaan teknis
    Route::get('/pekerjaan', [pekerjaanController::class, 'index'])->name('pekerjaan.index');
    Route::post('/pekerjaan/{id}/ambil', [pekerjaanController::class, 'ambil'])->name('pekerjaan.ambil');
    Route::post('/pekerjaan/{id}/selesai', [pekerjaanController::class, 'selesai'])->name('pekerjaan.selesai');
    Route::post('/keluhan/store', [pekerjaanController::class, 'store'])->name('keluhan.store');//  bagian input keluhan (admin service)
});