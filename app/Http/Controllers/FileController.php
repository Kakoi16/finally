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
        $fileName = $this->sanitizeFileName($originalFileName);

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
            'name' => $this->fixEncoding($fileName),
            'path' => $this->fixEncoding($path),
            'type' => $this->fixEncoding($fileType),
            'size' => $fileSize,
            'uploaded_by' => $userId,
        ];
        
        // Tambahin debug sementara
        dd($data); // uncomment ini untuk lihat isi $data di browser pas error.
        
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        
        if ($jsonData === false) {
            return back()->with('error', 'Gagal encode data JSON: ' . json_last_error_msg());
        }
        foreach ($data as $key => $val) {
            if (!mb_check_encoding($val, 'UTF-8')) {
                dd("Field $key bukan UTF-8", $val);
            }
        }
        

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
    private function fixEncoding($value)
    {
        if (!is_string($value)) {
            return $value;
        }
    
        // Paksa convert ke UTF-8, buang karakter invalid
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    
        // Hapus karakter non-printable (selain spasi)
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
    
        return $value;
    }
    
    
    private function sanitizeFileName($fileName)
    {
        // Pastikan UTF-8
        $fileName = $this->ensureUtf8($fileName);
    
        // Replace spasi jadi dash (-), tapi JANGAN ubah huruf kapital
        $fileName = str_replace(' ', '-', $fileName);
    
        // Hapus karakter yang tidak wajar, tapi biarkan huruf besar/kecil, angka, dash, underscore, titik
        $fileName = preg_replace('/[^\p{L}\p{N}\.\_\-]/u', '', $fileName);
    
        return $fileName;
    }
    

    private function ensureUtf8($string)
    {
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'auto');
        }
        return $string;
    }
}