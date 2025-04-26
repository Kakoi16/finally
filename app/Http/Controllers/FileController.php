<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FileController extends Controller
{
    public function uploadToSupabase(Request $request)
    {
        // Validasi input
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Tidak ada file yang diupload.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->with('error', 'File tidak valid.');
        }

        // Baca isi file
        $fileContent = file_get_contents($file->getRealPath());
        $fileName = $file->getClientOriginalName();

        // Konfigurasi Supabase
        $bucketName = 'storage'; // GANTI sesuai nama bucket kamu di Supabase
        $path = 'uploads/' . $fileName; // Path dalam bucket

        $url = env('SUPABASE_URL') . '/storage/v1/object/' . $bucketName . '/' . $path;

        // Kirim file ke Supabase menggunakan Laravel HTTP client
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/octet-stream',
        ])->put($url, $fileContent);

        // Respon ke pengguna
        if ($response->successful()) {
            return back()->with('success', 'File berhasil diupload ke Supabase!');
        } else {
            return back()->with('error', 'Gagal upload ke Supabase: ' . $response->body());
        }
    }
}
