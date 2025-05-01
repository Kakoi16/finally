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

    public function bulkRename(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'string',
            'rename_pattern' => 'required|string',
            'rename_value' => 'required|string',
        ]);

        $items = $request->selected_items;
        $pattern = $request->rename_pattern;
        $value = $request->rename_value;
        
        foreach ($items as $index => $itemPath) {
            // Get the item
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . '?path=eq.' . $itemPath);

            if ($response->successful() && !empty($response->json())) {
                $item = $response->json()[0];
                $oldName = $item['name'];
                $extension = pathinfo($oldName, PATHINFO_EXTENSION);
                $baseName = pathinfo($oldName, PATHINFO_FILENAME);
                
                // Apply rename pattern
                switch ($pattern) {
                    case 'prefix':
                        $newName = $value . $oldName;
                        break;
                    case 'suffix':
                        $newName = $extension 
                            ? $baseName . $value . '.' . $extension
                            : $oldName . $value;
                        break;
                    case 'replace':
                        $newName = str_replace($value, $request->replace_with, $oldName);
                        break;
                    case 'custom':
                        $newName = str_replace('{n}', $index + 1, $value);
                        if ($extension) {
                            $newName .= '.' . $extension;
                        }
                        break;
                    default:
                        $newName = $oldName;
                }
                
                $newPath = dirname($itemPath) . '/' . $newName;
                
                // Update the item
                Http::withHeaders([
                    'apikey' => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Content-Type' => 'application/json',
                ])->patch($this->supabaseUrl . '?id=eq.' . $item['id'], [
                    'name' => $newName,
                    'path' => $newPath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Item terpilih berhasil diubah nama.');
    }
    public function deleteItem(Request $request, $itemPath)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . '?path=eq.' . $itemPath);

        return $response->successful()
            ? redirect()->back()->with('success', 'Item berhasil dihapus.')
            : redirect()->back()->with('error', 'Gagal menghapus item.');
    }
    public function renameItem(Request $request, $itemPath)
    {
        $request->validate([
            'new_name' => 'required|string|max:255',
        ]);

        // Get the item to rename
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=eq.' . $itemPath);

        if (!$response->successful() || empty($response->json())) {
            return redirect()->back()->with('error', 'Item tidak ditemukan.');
        }

        $item = $response->json()[0];
        $newName = $request->new_name;
        $newPath = dirname($itemPath) . '/' . $newName;

        // Update the item
        $updateResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->patch($this->supabaseUrl . '?id=eq.' . $item['id'], [
            'name' => $newName,
            'path' => $newPath,
        ]);

        // If it's a folder, update all its contents
        if ($item['type'] === 'folder') {
            $updateChildrenResponse = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
            ])->patch($this->supabaseUrl, [
                'path' => Str::replaceFirst($itemPath, $newPath, 'path'),
            ])->where('path', 'like', $itemPath . '/%');
        }

        return $updateResponse->successful()
            ? redirect()->back()->with('success', 'Item berhasil diubah nama.')
            : redirect()->back()->with('error', 'Gagal mengubah nama item.');
    }
}
