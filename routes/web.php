<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use Faker\Core\File;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/loginKaryawan', [AuthController::class, 'loginKaryawan']);
    

    
    // Register (UI & API AJAX)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerKaryawan'])->name('register.karyawan');

    // Email Verificationa
    Route::get('/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['cors'])->post('/loginKaryawan', function (Request $request) {
    return response()->json(['message' => 'Tes CORS'])->header('Access-Control-Allow-Origin', '*');
});


// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.session');

// Home page
// Route untuk halaman utama
Route::get('/', function () {
    return view('layouts.home');
});

Route::get('/archive', [ArchiveController::class, 'index'])->name('archive')->middleware('admin.only');

// routes/web.php

Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
Route::post('/folders/create', [FileController::class, 'createFolder'])->name('folders.create');

Route::get('/local', [FolderController::class, 'listLocalFolders'])->name('local.folders');

// routes/folders
// routes/web.php
Route::middleware(['admin.only'])->group(function () {
    Route::delete('/folders/bulk-delete', [FileController::class, 'bulkDelete'])->name('folders.bulk.delete');
    Route::get('/api/folder-contents', [FileController::class, 'getFolderContents']);

    Route::post('/folders/{path}/subfolder', [FolderController::class, 'createSubfolder'])
        ->where('path', '.*')
        ->name('folders.subfolder.create');
        Route::post('/archive/upload/{folderPath?}', [FileController::class, 'upload'])
        ->where('folderPath', '.*')
        ->name('files.uploadToFolder');
        Route::post('/folders/{folderPath}/upload', [FileController::class, 'upload'])->where('folderPath', '.*');    
    // Folder
    Route::get('/folders/{any?}', [FolderController::class, 'showAnyFolder'])->where('any', '.*')->name('folders.showAny');


    Route::post('/folders/{parentFolder}/create-subfolder', [FolderController::class, 'createSubfolder'])->name('folders.createSubfolder');

    // File Upload
    Route::post('/folders/{folderName}/upload', [FileController::class, 'upload'])->name('files.uploadToFolder');

    Route::get('/folders/{folderName}', [FolderController::class, 'show'])->name('folders.open');
    Route::post('/folders', [FolderController::class, 'createFolder'])->name('folders.create');
    
    // web.php
Route::put('/folders/{id}/rename', [FolderController::class, 'rename']);
Route::delete('/folders/{id}', [FolderController::class, 'destroy']);
// Route::post('/folders/bulk-delete', [FolderController::class, 'bulkDelete'] )->name('folders.bulk.delete');
Route::post('/folders/bulk-rename', [FolderController::class, 'bulkRename'])->name('folders.bulk.rename');

});


Route::get('/files', [FileController::class, 'index'])->name('files.index');

// Google login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

