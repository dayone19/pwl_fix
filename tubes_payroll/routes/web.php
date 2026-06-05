<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\absensiController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\payrollController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\pekerjaanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\pengeluaranController;

// Landing
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware(['guest', 'prevent-back-history'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware(['check.lockout']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot Password (publik)
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])
    ->name('password.forgot');
Route::post('/forgotPassword/submit', [ForgotPasswordController::class, 'submit'])
    ->name('password.forgot.submit');

// Reset Password via token (link dikirim HR ke karyawan)
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetForm'])
    ->name('password.reset.form');
Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.reset.submit');
Route::get('/ganti-password', [UserController::class, 'formGantiPassword'])->name('password.form');
Route::post('/ganti-password', [UserController::class, 'prosesGantiPassword'])->name('password.update');

// ── AUTH GROUP ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    // Absensi
    Route::get('/absensi',              [absensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/pdf',          [absensiController::class, 'exportPdf'])->name('absensi.pdf');
    Route::get('/absensi/pribadi',      [absensiController::class, 'pribadi'])->name('absensi.pribadi');
    Route::get('/absensi/pribadi/pdf',  [absensiController::class, 'pribadiPdf'])->name('absensi.pribadi.pdf');
    Route::post('/absensi/import',      [absensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/template',     [absensiController::class, 'downloadTemplate'])->name('absensi.template');
    Route::post('/absensi/{id}',         [absensiController::class, 'update'])->name('absensi.update');
    Route::post('/cuti/{id}/approve', [CutiController::class, 'approve'])->name('cuti.approve');
    Route::post('/cuti/{id}/tolak',   [CutiController::class, 'tolak'])->name('cuti.tolak');

    // Data Karyawan (Route Resource dipecah manual menggunakan parameter {nip})
    Route::get('/karyawan', [karyawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [karyawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan', [karyawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{nip}', [karyawanController::class, 'show'])->name('karyawan.show');
    Route::get('/karyawan/{nip}/edit', [karyawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{nip}', [karyawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{nip}', [karyawanController::class, 'destroy'])->name('karyawan.destroy');
    
    // Kartu Pegawai
    Route::get('/kartu_pegawai/{nip}', [karyawanController::class, 'kartuPegawai'])->name('kartu.pegawai');

    // Kelola Akses / Users
    Route::get('/users',          [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}',     [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}',  [UserController::class, 'destroy'])->name('users.destroy');

    // Payroll
    Route::get('/hitung-payroll', [payrollController::class, 'dataPayroll'])->name('payroll.index'); 
    Route::get('/payroll/manage', [payrollController::class, 'manage'])->name('payroll.manage');
    Route::post('/payroll/generate', [payrollController::class, 'generateGaji'])->name('payroll.generate');
    Route::put('/payroll/update-draft/{id}', [payrollController::class, 'updateDraft'])->name('payroll.update-draft');
    Route::post('/payroll/submit/{id}', [payrollController::class, 'submitGaji'])->name('payroll.submit');
    Route::post('/payroll/aksi/{id}', [payrollController::class, 'keputusanManajemen'])->name('payroll.aksi');
    Route::delete('/payroll/delete/{id}', [payrollController::class, 'destroyDraft'])->name('payroll.destroy-draft');
    Route::post('/payroll/mass-action', [payrollController::class, 'massAction'])->name('payroll.mass-action');
    Route::post('/payroll/{id}/bayar', [payrollController::class, 'bayarGaji'])->name('payroll.bayar');
    Route::get('/payroll/slip/{id}',[payrollController::class, 'downloadSlip'])->name('payroll.slip');
    Route::get('/payroll/log-pembayaran', [payrollController::class, 'logPembayaran'])->name('payroll.log');

    // Cuti
    Route::get('/cuti',           [CutiController::class, 'index'])->name('cuti.index');
    Route::post('/cuti/ajukan',   [CutiController::class, 'store'])->name('cuti.store');

    // Pekerjaan Teknis
    Route::get('/pekerjaan',                    [pekerjaanController::class, 'index'])->name('pekerjaan.index');
    Route::post('/pekerjaan/{id}/ambil',        [pekerjaanController::class, 'ambil'])->name('pekerjaan.ambil');
    Route::post('/pekerjaan/{id}/selesai',      [pekerjaanController::class, 'selesai'])->name('pekerjaan.selesai');
    Route::post('/keluhan/store',               [pekerjaanController::class, 'store'])->name('keluhan.store');

    // Permintaan Akses (HRD & Manajemen)
    Route::get('/access-requests',               [ForgotPasswordController::class, 'requestList'])->name('access-requests.index');
    Route::post('/access-requests/{id}/approve', [ForgotPasswordController::class, 'approve'])->name('access-requests.approve');
    Route::post('/access-requests/{id}/reject',  [ForgotPasswordController::class, 'reject'])->name('access-requests.reject');

});