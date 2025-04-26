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

        $fileContent = file_get_contents($file->getRealPath());
        $fileName = $file->getClientOriginalName();
        $fileName = mb_convert_encoding($fileName, 'UTF-8', 'UTF-8'); 
        $fileName = preg_replace('/[^\x20-\x7E]/', '', $fileName); // optional: lebih aman
        
        $fileSize = $file->getSize();
        $fileType = $file->getClientOriginalExtension();

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

        $supabaseInsertUrl = env('SUPABASE_URL') . '/rest/v1/archives';
        $userId = Auth::id();

        $insertResponse = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
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
