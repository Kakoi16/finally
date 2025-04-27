<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;

// =================== Guest ===================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register (UI & API AJAX)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerKaryawan'])->name('register.karyawan');

    // Email Verification
    Route::get('/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// =================== Authenticated User ===================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.session');

    // Archive (admin only)
    Route::middleware('admin.only')->group(function () {
        Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');

        // Folder routes
        Route::get('/folders/{folderName}', [FolderController::class, 'show'])->name('folders.open');
        Route::post('/folders', [FolderController::class, 'createFolder'])->name('folders.create');
        Route::post('/folders/{parentFolder}/create-subfolder', [FolderController::class, 'createSubfolder'])->name('folders.createSubfolder');

        // File routes
        Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
        Route::post('/folders/{folderName}/upload', [FileController::class, 'upload'])->name('files.uploadToFolder');
        Route::get('/files', [FileController::class, 'index'])->name('files.index');
    });
});

// =================== Public Pages ===================
Route::get('/', function () {
    return view('layouts.home');
});

// =================== Google Login ===================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
