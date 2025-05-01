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

        $currentFolder = trim($folderName ?? '', '/');

        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';

            if ($currentFolder === '') {
                return !Str::contains($path, '/');
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

    // Rename beberapa file sekaligus (via JSON)
    public function renameSelected(Request $request)
    {
        $this->validate($request, [
            'files' => 'required|array',
            'files.*.id' => 'required|uuid',
            'files.*.new_name' => 'required|string',
        ]);

        $results = [];

        foreach ($request->files as $file) {
            $current = Http::withToken($this->supabaseKey)
                ->get($this->supabaseUrl . "?id=eq.{$file['id']}")
                ->json()[0] ?? null;

            if (!$current) {
                $results[] = ['id' => $file['id'], 'success' => false, 'reason' => 'File not found'];
                continue;
            }

            $newPath = preg_replace('/[^\/]+$/', $file['new_name'], $current['path']);

            $response = Http::withToken($this->supabaseKey)
                ->patch($this->supabaseUrl . "?id=eq.{$file['id']}", [
                    'name' => $file['new_name'],
                    'path' => $newPath
                ]);

            $results[] = [
                'id' => $file['id'],
                'success' => $response->successful(),
            ];
        }

        return response()->json(['results' => $results]);
    }

    // Delete beberapa file sekaligus (via JSON)
    public function deleteSelected(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|uuid',
        ]);

        $results = [];

        foreach ($request->ids as $id) {
            $response = Http::withToken($this->supabaseKey)
                ->delete($this->supabaseUrl . "?id=eq.$id");

            $results[] = [
                'id' => $id,
                'success' => $response->successful(),
            ];
        }

        return response()->json(['results' => $results]);
    }
}
