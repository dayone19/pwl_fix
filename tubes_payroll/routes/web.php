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

// Edit Karyawan
Route::get('/karyawan/{nip}/edit', [KaryawanController::class, 'edit'])
    ->name('karyawan.edit');

Route::put('/karyawan/{nip}', [KaryawanController::class, 'update'])
    ->name('karyawan.update');
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

    // Data Karyawan
    Route::resource('karyawan', karyawanController::class);

    // Kelola Akses / Users
    Route::get('/users',          [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}',     [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}',  [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/hitung-payroll', [payrollController::class, 'dataPayroll'])->name('payroll.index'); 
    Route::get('/payroll/manage', [payrollController::class, 'manage'])->name('payroll.manage');
    Route::post('/payroll/generate', [payrollController::class, 'generateGaji'])->name('payroll.generate');
    Route::put('/payroll/update-draft/{id}', [PayrollController::class, 'updateDraft'])
    ->name('payroll.update-draft');
    Route::post('/payroll/submit/{id}', [PayrollController::class, 'submitGaji'])
    ->name('payroll.submit');
    Route::post('/payroll/aksi/{id}', [PayrollController::class, 'keputusanManajemen'])
    ->name('payroll.aksi');
    Route::delete('/payroll/delete/{id}', [PayrollController::class, 'destroyDraft'])
    ->name('payroll.destroy-draft');
    Route::post('/payroll/mass-action', [PayrollController::class, 'massAction'])
    ->name('payroll.mass-action');
    Route::post('/payroll/{id}/bayar', [PayrollController::class, 'bayarGaji'])
    ->name('payroll.bayar');
    Route::get('/payroll/slip/{id}',[PayrollController::class, 'downloadSlip'])
    ->name('payroll.slip');

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