<?php

// app/Http/Controllers/AppVersionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppVersionController extends Controller
{
    public function getAppVersion()
    {
        // Ganti '1.0.1' dengan versi terbaru aplikasi Anda yang sebenarnya.
        // Anda bisa menyimpannya di database, di file config, atau variabel lingkungan.
        $latestVersion = '1.0.1'; // Contoh: Ganti ini dengan versi terbaru yang ingin Anda distribusikan

        // **Tambahkan URL Google Drive untuk unduhan pembaruan**
        // Ganti URL ini dengan tautan Google Drive atau tautan unduhan APK/IPA yang sebenarnya
        $downloadUrl = 'https://drive.google.com/file/d/12kvT1xT8D3N6BynRw7GSdEhOpATqRBlJ/view'; // Ganti YOUR_GOOGLE_DRIVE_FILE_ID

        return response()->json([
            'latestVersion' => $latestVersion,
            'downloadUrl' => $downloadUrl // Tambahkan ini
        ]);
    }
    public function downloadApp()
{
    $filePath = public_path('downloads/simpap.apk'); // Pastikan path ini benar
    if (file_exists($filePath)) {
        return response()->download($filePath, 'simpap.apk');
    }
    return response()->json(['message' => 'File not found'], 404);
}
}
