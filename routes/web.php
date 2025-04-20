<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Rute untuk pendaftaran karyawan
Route::get('/register/karyawan', [AuthController::class, 'showRegisterForm'])->name('register.karyawan');
Route::post('/register/karyawan', [AuthController::class, 'registerKaryawan'])->name('register.karyawan.submit');

// Rute untuk verifikasi OTP setelah pendaftaran
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp.form'); // Form verifikasi OTP
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit'); // Proses verifikasi OTP

// Rute untuk verifikasi email (jika diperlukan)
Route::get('/verify/{id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Rute untuk logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rute untuk tes koneksi ke Supabase
Route::get('/test-supabase', [AuthController::class, 'testSupabaseConnection']);

// Rute untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.session');

// Rute untuk halaman utama
Route::get('/', function () {
    return view('archive');
});

// Rute untuk login menggunakan Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
