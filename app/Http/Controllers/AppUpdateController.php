<?php

// app/Http/Controllers/AppUpdateController.php

namespace App\Http\Controllers;

use App\Models\AppUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AppUpdateController extends Controller
{
    public function showUploadForm()
    {
        // Ambil data update terakhir untuk ditampilkan di form jika perlu
        $current_update = AppUpdate::find(1);
        return view('archive', compact('current_update'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required|string|max:255',
            'app_file' => [
                'required',
                'file',
                'max:204800', // maksimal 200MB
                function ($attribute, $value, $fail) {
                    $extension = $value->getClientOriginalExtension();
                    if (strtolower($extension) !== 'apk') {
                        $fail('File harus berformat .apk');
                    }
                },
            ],
        ]);

        $file = $request->file('app_file');
        // Buat nama file unik atau gunakan nama original, tapi pastikan folder bersih jika perlu
        $fileName = 'app-release-' . time() . '.' . $file->getClientOriginalExtension();

        // **[PERBAIKAN 1] Simpan file ke disk 'public'**
        // Ini akan menyimpan file di dalam folder `storage/app/public/uploads/app_updates`
        // Pastikan Anda sudah menjalankan `php artisan storage:link`
        $path = $file->storeAs('uploads/app_updates', $fileName, 'public');

        // Hapus file lama jika ada, untuk menjaga kebersihan storage
        $old_update = AppUpdate::find(1);
        if ($old_update && $old_update->file_path && Storage::disk('public')->exists($old_update->file_path)) {
            Storage::disk('public')->delete($old_update->file_path);
        }

        // **[PERBAIKAN 2] Gunakan updateOrCreate dengan path yang benar**
        // Metode ini akan mencari record dengan id = 1. Jika ada, akan di-update. Jika tidak, akan dibuat.
        // Ini adalah cara yang paling tepat untuk kasus Anda.
        AppUpdate::updateOrCreate(
            ['id' => 1], // Kondisi untuk mencari record
            [
                'version'   => $request->version,
                'file_path' => $path, // Simpan path yang dikembalikan oleh storeAs()
                // created_at akan terisi otomatis saat pertama kali dibuat
                // updated_at akan terisi otomatis oleh Eloquent
            ]
        );

        return back()->with('success', 'Versi aplikasi berhasil diperbarui ke ' . $request->version);
    }

   public function getLatestVersion()
{
    $latest = \App\Models\AppUpdate::orderBy('created_at', 'desc')->first();

    if (!$latest) {
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada versi aplikasi yang ditemukan.',
        ], 404);
    }

    // Ambil path dari database dan siapkan path relatif dari storage/app/public/
    $filePathFromDb = $latest->file_path;

    // Buat URL yang sesuai, misal: https://domain.com/storage/uploads/app_updates/namafile.zip
    $publicRelativePath = str_replace('storage/app/public/', '', $filePathFromDb);
    $downloadUrl = asset('storage/app/public/' . $publicRelativePath);

    return response()->json([
        'success' => true,
        'latestVersion' => $latest->version,
        'downloadUrl' => $downloadUrl,
    ]);
}


    public function checkUpdate(Request $request)
    {
        $request->validate([
            'current_version' => 'required|string',
        ]);

        $clientVersion = $request->current_version;

        // **[PERBAIKAN 5] Langsung cari ID 1**
        $latest = AppUpdate::find(1);

        if (!$latest) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada versi aplikasi yang ditemukan di server.',
            ], 404);
        }

        $latestVersion = $latest->version;
        // Gunakan version_compare untuk perbandingan versi yang aman (misal: "1.10.0" > "1.9.0")
        $isUpdateAvailable = version_compare($latestVersion, $clientVersion, '>');

        if ($isUpdateAvailable) {
            return response()->json([
                'update_available' => true,
                'latest_version'   => $latestVersion,
                'download_url'     => Storage::url($latest->file_path),
                'message'          => 'Versi baru tersedia: ' . $latestVersion,
            ]);
        }

        return response()->json([
            'update_available' => false,
            'latest_version'   => $latestVersion,
            'message'          => 'Aplikasi Anda sudah menggunakan versi terbaru.',
        ]);
    }
}
