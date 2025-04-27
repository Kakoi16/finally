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

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        // Simpan file ke local storage sementara
        $path = $file->store('uploads', 'public');

        // Ambil user ID (kalau pakai Auth::user())
        $uploadedBy = auth()->user()->id ?? null; // Asumsi kamu udah login pakai UUID
        
        // Kirim ke Supabase
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

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $uploadedBy = auth()->user()->id ?? null;

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ])->post($this->supabaseUrl, [
            'name' => $request->folder_name,
            'path' => 'uploads/' . Str::slug($request->folder_name),
            'type' => 'folder',
            'size' => 0,
            'uploaded_by' => $uploadedBy,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Folder berhasil dibuat.');
        } else {
            return redirect()->back()->with('error', 'Gagal membuat folder.');
        }
    }
    public function index()
{
    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
    $headers = [
        'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        'apikey'        => env('SUPABASE_API_KEY'),
    ];

    try {
        $response = Http::withHeaders($headers)
            ->get("$supabaseUrl/rest/v1/archives?select=*");

        if (!$response->successful()) {
            throw new \Exception('Supabase API error: ' . $response->body());
        }

        $archives = $response->json();

        // Tambahkan url untuk setiap file
        $supabaseStorageUrl = 'https://jnsxbikmccdbxfxbqpso.supabase.co/storage/v1/object/public/storage/';

        foreach ($archives as &$file) {
            if (($file['type'] ?? '') !== 'folder') {
                $file['url'] = $supabaseStorageUrl . $file['path'];
            } else {
                $file['url'] = '#';
            }
        }

        return view('archive.pages.all-files', ['files' => $archives]);

    } catch (\Exception $e) {
        return response()->view('errors.custom', ['message' => $e->getMessage()], 500);
    }
}

    

}
