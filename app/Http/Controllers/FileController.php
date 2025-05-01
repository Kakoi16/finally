<?php

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

    // Upload file ke folder tertentu
    public function upload(Request $request, $folderName = null)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $uploadedBy = auth()->user()->id ?? null;

        $path = '';
        if ($folderName) {
            $path .= trim($folderName, '/') . '/';
        }
        $path .= $file->getClientOriginalName();

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

    // Menampilkan isi folder tertentu
    public function index(Request $request, $folderName = null)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl);

        $files = $response->json();

        $currentFolder = trim($folderName ?? '', '/'); // kosong jika root

        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';

            if ($currentFolder === '') {
                return !Str::contains($path, '/'); // hanya root-level
            }

            if (Str::startsWith($path, $currentFolder . '/')) {
                $remainingPath = Str::after($path, $currentFolder . '/');
                return !Str::contains($remainingPath, '/');
            }

            return false;
        });

        return view('all-files', [
            'archives' => $filteredFiles,
            'currentFolder' => $folderName,
        ]);
    }

    public function rename(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
        'Content-Type' => 'application/json',
    ])->patch($this->supabaseUrl . '?id=eq.' . $id, [
        'name' => $request->name,
    ]);

    return response()->json(['success' => $response->successful()]);
}

public function delete(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
    ]);

    $ids = $request->ids;
    $query = implode(',', array_map(fn($id) => '"' . $id . '"', $ids));

    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ])->delete($this->supabaseUrl . '?id=in.(' . $query . ')');

    return response()->json(['success' => $response->successful()]);
}

}
