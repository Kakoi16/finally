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


public function index()
{
    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ])->get($this->supabaseUrl);

    $files = $response->json();

    // Filter hanya yang ada langsung di dalam "uploads"
    $filteredFiles = array_filter($files, function ($file) {
        $path = $file['path'] ?? '';

        // Hanya ambil yang berada LANGSUNG di uploads/ (tidak ada / lagi setelah uploads/xxx)
        if (Str::startsWith($path, 'uploads/')) {
            $remainingPath = Str::after($path, 'uploads/');

            // Kalau tidak ada "/" lagi setelah uploads/xxx
            return !Str::contains($remainingPath, '/');
        }

        return false;
    });

    return view('all-files', [
        'archives' => $filteredFiles
    ]);
}

   
}
