<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerKaryawan'])->name('register.karyawan');

    Route::get('/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Dashboard route menampilkan view dashboard.blade.php dari folder partials
Route::get('/dashboard', function () {
    return view('partials.dashboard');
})->name('dashboard')->middleware('auth.session');

// Halaman default (/) juga arahkan ke dashboard
Route::get('/', function () {
    return view('partials.dashboard');
});

// Setelah login berhasil, arahkan ke archive (khusus admin)
Route::get('/archive', [DashboardController::class, 'index'])->name('archive')->middleware('admin.only');

// Google login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
