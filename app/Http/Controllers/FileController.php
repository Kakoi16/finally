<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Tidak ada file yang diupload.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->with('error', 'File tidak valid.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];
        $fileExtension = strtolower($file->getClientOriginalExtension());
        if (!in_array($fileExtension, $allowedExtensions)) {
            return back()->with('error', 'Tipe file tidak diperbolehkan.');
        }

        $originalFileName = $file->getClientOriginalName();
        $fileName = preg_replace('/[^\p{L}\p{N}\.\_\-]/u', '', $originalFileName); // hanya huruf, angka, titik, underscore, dash
        $fileName = str_replace(' ', '-', $fileName); 
        $fileName = strtolower($fileName); 

        $fileContent = file_get_contents($file->getRealPath());
        $fileSize = $file->getSize();
        $fileType = $fileExtension;

        $bucketName = 'storage';
        $path = 'uploads/' . $fileName;

        $storageUrl = env('SUPABASE_URL') . '/storage/v1/object/' . $bucketName . '/' . $path;

        $storageResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/octet-stream',
        ])->put($storageUrl, $fileContent);

        if (!$storageResponse->successful()) {
            return back()->with('error', 'Gagal upload ke Supabase Storage: ' . $storageResponse->body());
        }

        // Insert metadata ke table Supabase (table: archives)
        $supabaseInsertUrl = env('SUPABASE_URL') . '/rest/v1/archives';
        $userId = Auth::id();

        // Prepare safe UTF-8 data
        $data = [
            'name' => $this->cleanUtf8($fileName),
            'path' => $this->cleanUtf8($path),
            'type' => $this->cleanUtf8($fileType),
            'size' => $fileSize,
            'uploaded_by' => $userId,
        ];

        $insertResponse = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Prefer' => 'return=minimal',
        ])->post($supabaseInsertUrl, [
            'json' => $data, // << INI PENTING
        ]);
        

        if (!$insertResponse->successful()) {
            return back()->with('error', 'Gagal simpan metadata file: ' . $insertResponse->body());
        }

        return back()->with('success', 'File berhasil diupload dan disimpan!');
    }

    private function cleanUtf8($string)
    {
        // Hilangkan karakter non-UTF8 atau konversi aman
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]/u', '', $string);
    }
}
