<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response; // Pastikan Response di-import

class FileAccessController extends Controller
{
    /**
     * Menampilkan file lampiran dari storage.
     * Path yang diterima adalah path relatif setelah 'uploads/'
     * Misalnya: 'karyawan/namafile.pdf'
     */
    public function showArchiveAttachment($category, $filename)
    {
        // $category akan menjadi 'karyawan' atau subfolder lain di dalam 'uploads'
        // $filename akan menjadi nama file sebenarnya
        $filePath = 'uploads/' . $category . '/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            \Log::warning('File not found attempt: public/' . $filePath); // Logging
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::disk('public')->get($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $mimeType);

        // Untuk PDF, biasanya browser akan menampilkannya inline
        // Jika ingin memaksa download untuk tipe lain, bisa ditambahkan:
        // $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        
        // Khusus untuk PDF agar ditampilkan inline di browser
        if ($mimeType == 'application/pdf') {
            $response->header('Content-Disposition', 'inline; filename="' . $filename . '"');
        }

        return $response;
    }
}