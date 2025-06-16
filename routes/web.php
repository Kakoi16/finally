<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use Faker\Core\File;
use Illuminate\Http\Request; 
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SubfolderController;
use App\Http\Controllers\ArchiveShareController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\Admin\InformasiAdminController;



use App\Http\Controllers\PengajuanSuratController;



// Asumsi route ini untuk admin dan mungkin perlu prefix dan middleware
Route::prefix('admin')->middleware(['auth', /* middleware admin lainnya jika ada */])->group(function () {
    // Route untuk menampilkan halaman daftar pengajuan (jika ada view khusus admin)
    Route::post('/pengajuan-surat/reject', [PengajuanSuratController::class, 'reject'])->name('pengajuan-surat.reject');

    Route::get('/submissions-page', function () {
        return view('archive.pages.submission'); // Sesuaikan path view jika beda
    })->name('admin.submissions.page');
    
Route::name('admin.')->group(function () {
        Route::resource('informasi', InformasiAdminController::class);
    });
    
    // Route API untuk mengambil data pengajuan (digunakan oleh JavaScript)
    Route::get('/submissions', [PengajuanSuratController::class, 'indexForAdmin'])->name('admin.submissions.index');

    // Route API untuk update status pengajuan (digunakan oleh JavaScript)
    Route::patch('/submissions/{pengajuanSurat}/status', [PengajuanSuratController::class, 'updateStatus'])->name('admin.submissions.updateStatus');
    Route::get('uploads/{category}/{filename}', [FileAccessController::class, 'showArchiveAttachment'])
    ->where('filename', '.*') // Memungkinkan filename mengandung titik atau karakter lain
    ->name('file.view');
});

    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

Route::middleware('guest')->group(function () {

Route::get('/shared-page', [ArchiveShareController::class, 'index'])->name('shared.page');

Route::post('/shared-page/share', [ArchiveShareController::class, 'share'])->name('shared.page.share');
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/loginKaryawan', [AuthController::class, 'loginKaryawan']);


    // Register (UI & API AJAX)\

Route::get ('/template/editonline/{encodedPath}', [SubfolderController::class, 'editOnl'])
     ->where('encodedPath', '.*')
     ->name('template.edit');

Route::post('/zoho-save', [SubfolderController::class, 'saveFromZoho'])->name('zoho.save');

// atau jika ingin bisa GET juga (opsional dan tidak direkomendasikan untuk prohd)
Route::post('/zoho/template/save-callback/{docId}', [App\Http\Controllers\ArchiveController::class, 'handleZohoTemplateSaveCallback'])
    ->name('zoho.template.saveCallback');
    
Route::match(['get', 'post'], '/zoho-callback', [TemplateController::class, 'zohoCallback']);

Route::match(['get', 'post'], '/zoho-call-back', [SubfolderController::class, 'zohoCallbackk']);
 
// Rute untuk Lupa Password
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Rute login Anda yang sebelumnya
});

Route::post('/archives/create-template-doc', [ArchiveController::class, 'createTemplateDoc'])->name('archives.createTemplateDoc');


// Logout
Route::middleware('auth')->group(function () {
    
   Route::get('/archives/{archive}/view-pdf', [ArchiveController::class, 'showPdfPage'])
        ->name('archives.showPdfPage');

    // Rute untuk streaming konten PDF
    Route::get('/archives/{archive}/stream-pdf', [ArchiveController::class, 'streamPdf'])
        ->name('archives.streamPdf');

    
 Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // routes/web.php
Route::post('/archives/create-doc', [ArchiveController::class, 'createDoc'])->name('archives.createDoc');

    Route::post('/create-zoho-file', [FileController::class, 'createFileViaZoho'])->name('zoho.create');

    Route::get('/archive/trash', [ArchiveController::class, 'trash'])->name('archive.trash');
Route::post('/archive/trash/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
Route::post('/archive/trash/delete-permanent', [ArchiveController::class, 'deletePermanent'])->name('archive.deletePermanent');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

     Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/register', [AuthController::class, 'registerKaryawan'])->name('register.karyawan');

    // Email Verificationa


Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/older', [ActivityController::class, 'older']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['cors'])->post('/loginKaryawan', function (Request $request) {
    return response()->json(['message' => 'Tes CORS'])->header('Access-Control-Allow-Origin', '*');
});


// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.session');

// Route untuk halaman utama
Route::get('/', function () {
    return view('home');
});

Route::get('/archive', [ArchiveController::class, 'index'])
    ->middleware(['auth', 'admin.only'])
    ->name('archive');



// routes/web.php

Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload');
Route::post('/folders/create', [FileController::class, 'createFolder'])->name('folders.create');

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

    Route::get('/download/folder/{folderPath}', [DownloadController::class, 'downloadFolder'])
        ->where('folderPath', '.*')
        ->name('download.folder');
    Route::get('/download/file/{filePath}', [DownloadController::class, 'downloadFile'])
        ->where('filePath', '.*')
        ->name('download.file');
    Route::get('/template/edit-online/{filePath}', [TemplateController::class, 'editOnline'])->name('template.edit.online');
    Route::get(
    '/template/editonline/{encodedPath}',
    [SubfolderController::class, 'editOnl']
)
->where('encodedPath', '.*')      // ← biar slug apa pun diterima
->name('template.edit');

    Route::post('/template/zoho/save', [TemplateController::class, 'zohoSave'])->name('template.zoho.save');
Route::get('/edit-online/{encodedPath}', [TemplateController::class, 'editOnline'])->name('template.editOnline');


    Route::put('/folders/{id}/rename', [FolderController::class, 'rename']);
    Route::delete('/folders/{id}', [FolderController::class, 'destroy']);
    // Route::post('/folders/bulk-delete', [FolderController::class, 'bulkDelete'] )->name('folders.bulk.delete');
    Route::post('/folders/bulk-rename', [FolderController::class, 'bulkRename'])->name('folders.bulk.rename');
});
Route::get('/test-rename-folder', [FolderController::class, 'testRenameFolder']);

Route::get('/files', [FileController::class, 'index'])->name('files.index');

// Google login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    Route::post('/log-activity', [ActivityController::class, 'store'])->name('activity.log');

