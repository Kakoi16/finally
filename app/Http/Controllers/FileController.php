<?php

// app/Http/Controllers/FileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FileController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL') . '/rest/v1/archives';
        $this->supabaseKey = env('SUPABASE_API_KEY');
    }

    public function upload(Request $request, $folderName = null)
{
    $request->validate([
        'file' => 'required|file',
    ]);

    $file = $request->file('file');
    $uploadedBy = auth()->user()->id ?? null;

    // Path penempatan
    $path = 'uploads';
    if ($folderName) {
        $path .= '/' . $folderName;
    }
    $path .= '/' . $file->getClientOriginalName(); // Nama file

    // Kirim metadata file ke Supabase
    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
        'Content-Type' => 'application/json',
        'Prefer' => 'return=minimal',
    ])->post($this->supabaseUrl, [
        'name' => $file->getClientOriginalName(),
        'path' => $path,
        'type' => $file->getClientMimeType(),
        'size' => $file->getSize(),
        'uploaded_by' => $uploadedBy,
    ]);

    if ($response->successful()) {
        return redirect()->back()->with('success', 'File berhasil diupload.');
    } else {
        return redirect()->back()->with('error', 'Gagal upload file.');
    }
}


public function index(Request $request, $folderName = null)
{
    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ])->get($this->supabaseUrl);

    $files = $response->json();

    // Path folder yang sedang dibuka
    $currentFolder = 'uploads';
    if ($folderName) {
        $currentFolder .= '/' . $folderName;
    }

    $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
        $path = $file['path'] ?? '';

        // Pastikan file berada di folder saat ini
        if (Str::startsWith($path, $currentFolder . '/')) {
            $remainingPath = Str::after($path, $currentFolder . '/');

            // Kalau setelah path folder saat ini tidak ada '/' lagi (artinya langsung file/folder)
            return !Str::contains($remainingPath, '/');
        }

        return false;
    });

    return view('all-files', [
        'archives' => $filteredFiles,
        'currentFolder' => $folderName,
    ]);
}

   
}
