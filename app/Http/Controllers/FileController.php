<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi input
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Tidak ada file yang diupload.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->with('error', 'File tidak valid.');
        }

        // Baca file
        $fileContent = file_get_contents($file->getRealPath());
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileType = $file->getClientOriginalExtension(); // Misal pdf, jpg, dll

        // Upload ke Supabase Storage
        $bucketName = 'storage'; // <- sesuaikan dengan nama bucket kamu
        $path = 'uploads/' . $fileName;
        $storageUrl = env('SUPABASE_URL') . '/storage/v1/object/' . $bucketName . '/' . $path;

        $storageResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/octet-stream',
        ])->put($storageUrl, $fileContent);

        if (!$storageResponse->successful()) {
            return back()->with('error', 'Gagal upload ke Supabase Storage: ' . $storageResponse->body());
        }

        // Simpan metadata ke tabel 'archives' di Supabase via REST API
        $supabaseInsertUrl = env('SUPABASE_URL') . '/rest/v1/archives'; // Tabel archives
        $userId = Auth::id(); // ID user yang upload (pastikan user sudah login)

        $insertResponse = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal', // Biar Supabase lebih cepat (tidak kembalikan data)
        ])->post($supabaseInsertUrl, [
            'name' => $fileName,
            'path' => $path,
            'type' => $fileType,
            'size' => $fileSize,
            'uploaded_by' => $userId,
        ]);

        if (!$insertResponse->successful()) {
            return back()->with('error', 'Gagal simpan metadata file: ' . $insertResponse->body());
        }

        return back()->with('success', 'File berhasil diupload dan disimpan!');
    }
}
