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

        // Upload file ke Supabase Storage
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

        $data = [
            'name' => $this->cleanUtf8($fileName),
            'path' => $this->cleanUtf8($path),
            'type' => $this->cleanUtf8($fileType),
            'size' => $fileSize,
            'uploaded_by' => $userId,
        ];

        // Encode manual JSON untuk menghindari error UTF-8
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

        if ($jsonData === false) {
            return back()->with('error', 'Gagal encode data JSON: ' . json_last_error_msg());
        }

        // Kirim request ke Supabase
        $insertResponse = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ])->withBody($jsonData, 'application/json')->post($supabaseInsertUrl);

        if (!$insertResponse->successful()) {
            return back()->with('error', 'Gagal simpan metadata file: ' . $insertResponse->body());
        }

        return back()->with('success', 'File berhasil diupload dan disimpan!');
    }

    private function cleanUtf8($string)
    {
        // Konversi ke UTF-8 dan hapus karakter tak terlihat
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        return preg_replace('/[^\P{C}\n]+/u', '', $string);
    }
}
