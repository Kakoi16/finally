<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\PengajuanSuratController; // Pastikan ini di-import
use App\Http\Controllers\Api\UserProfileController; // Pastikan ini di-import
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\PengajuanController; // Pastikan ini di-import
use App\Http\Controllers\Api\DashboardController; // Pastikan ini di-import
use App\Http\Controllers\Api\NotificationController;
=======

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::get('/categories', [PengajuanSuratController::class, 'getCategories']);
Route::get('/riwayat-surat', [PengajuanController::class, 'riwayatSuratt']);


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('/dashboard/surat-stats', [DashboardController::class, 'getSuratStats']);
// Rute untuk Informasi Admin
Route::get('/admin-info', [DashboardController::class, 'getAdminInfo']);


// Endpoint untuk halaman Aktivitas
Route::get('/aktivitas-terbaru', [PengajuanController::class, 'getRecentActivities']);

// Endpoint untuk menghapus satu sura
Route::delete('/riwayat-surat/{id}', [PengajuanController::class, 'destroy']);

// Endpoint untuk menghapus semua riwayat
// Route untuk registrasi dan login karyawan (tidak perlu auth:sanctum di sini)
Route::post('/register-karyawan', [AuthController::class, 'registerKaryawan']);
Route::post('/login-karyawan', [AuthController::class, 'loginKaryawan']); // ✅ Ini yang digunakan Ionic
    Route::get('/pengajuan-surat/latest', [PengajuanController::class, 'getRecentActivities']);
Route::middleware('auth:sanctum')->post('/profile/change-password', [UserProfileController::class, 'changePassword']);



// Route yang memerlukan otentikasi Sanctum
     Route::middleware('auth:sanctum')->post('/profile/save', [UserProfileController::class, 'saveProfile']);
Route::middleware('auth:sanctum')->group(function () {
    
     Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead']);

// Tambahkan route ini

    Route::get('/profile/display-picture', [UserProfileController::class, 'displayProfilePicture'])->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->post('/profile/upload-picture', [UserProfileController::class, 'uploadProfilePicture']);
    Route::get('/profile/download', [UserProfileController::class, 'downloadProfileFile']);
    Route::get('/profile/current', [UserProfileController::class, 'getCurrentUserProfile']);
    
    
    
Route::delete('riwayat-surat/clear-all', [PengajuanController::class, 'clearAll']);

// Route untuk menghapus satu surat
// ID surat akan ditangkap oleh {id}
Route::delete('riwayat-surat/{id}', [PengajuanController::class, 'destroy']);
    
     Route::get('/pengajuan-surats/{pengajuan}/download', [PengajuanSuratController::class, 'downloadGeneratedPdf'])
         ->name('pengajuan.download'); 
    

    
    Route::get('/user', function (Request $request) {
        return $request->user(); // Mengembalikan detail user yang sedang login
    });

Route::post('/pengajuan-surats', [PengajuanSuratController::class, 'store']);
    Route::post('/logout-api', [AuthController::class, 'logoutApi']); // ✅ Route untuk logout API

    // Route Anda yang sudah ada
    Route::get('/pengajuan-surats/check-status', [PengajuanSuratController::class, 'checkPendingSubmission']);

    // Tambahkan route API lain yang butuh otentikasi di sini
    Route::get('/pengajuan-surats/status-by-user', [PengajuanSuratController::class, 'statusByUser']);

});
<<<<<<< HEAD
Route::post('/pengajuan-surats/generate-pdf', [App\Http\Controllers\PengajuanSuratController::class, 'generatePdfPreview'])->middleware('auth:sanctum');
// Route verifikasi email (biasanya diakses dari link email, tidak perlu Sanctum)
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify.api');

// Route untuk login admin web (jika masih ada dan terpisah dari API)
// Route::post('/login/admin', [AuthController::class, 'login']);

// Route untuk upload attachment (jika terpisah dan butuh auth)
// Route::post('/upload-attachment', [PengajuanSuratController::class, 'uploadAttachment'])->middleware('auth:sanctum');
=======
Route::post('/login/admin', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginViaSupabase']); // untuk karyawan

Route::post('/loginKaryawan', [AuthController::class, 'loginKaryawan']);

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
