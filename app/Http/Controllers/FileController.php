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

    // Upload file to specific folder
    public function upload(Request $request, $folderPath = null)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $uploadedBy = auth()->user()->id ?? null;

        $cleanedPath = trim($folderPath ?? '', '/');
        $originalName = $this->sanitizeFilename($file->getClientOriginalName());

        $fullPath = $cleanedPath !== ''
            ? $cleanedPath . '/' . $originalName
            : $originalName;

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json; charset=utf-8',
            'Prefer' => 'return=minimal',
        ])->post($this->supabaseUrl, [
            'name' => $originalName,
            'path' => $fullPath,
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => $uploadedBy,
        ]);

        $storageSuccess = $this->uploadToSupabaseStorage($file, $fullPath);

        if ($response->successful() && $storageSuccess) {
            return redirect()->back()->with('success', 'File uploaded successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to upload file.');
        }
    }

    private function sanitizeFilename($filename)
    {
        $filename = mb_convert_encoding($filename, 'UTF-8', 'UTF-8');
        return preg_replace('/[^\x20-\x7E]/u', '', $filename);
    }

    private function uploadToSupabaseStorage($file, $storagePath)
    {
        $bucket = 'storage';
        $fileContent = file_get_contents($file->getRealPath());

        $encodedPath = implode('/', array_map('rawurlencode', explode('/', $storagePath)));
        $uploadUrl = env('SUPABASE_URL') . "/storage/v1/object/$bucket/$encodedPath";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'apikey' => $this->supabaseKey,
                'Content-Type' => $file->getMimeType(),
            ])->withBody($fileContent, $file->getMimeType())
              ->put($uploadUrl);

            return $response->successful();
        } catch (\Exception $e) {
            logger()->error('Supabase upload error: ' . $e->getMessage());
            return false;
        }
    }

    public function index(Request $request, $folderName = null)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl);

        $files = $response->json() ?? [];
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
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . '?path=eq.' . $itemPath);

            if ($response->successful() && !empty($response->json())) {
                $item = $response->json()[0];
                $oldName = $item['name'];
                $extension = pathinfo($oldName, PATHINFO_EXTENSION);
                $baseName = pathinfo($oldName, PATHINFO_FILENAME);

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

                $parentDir = dirname($itemPath);
                $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;
                $newPath = ltrim($parentDir . '/' . $newName, '/');

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
        $parentDir = dirname($itemPath);
        $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;
        $newPath = ltrim($parentDir . '/' . $newName, '/');
        

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
    public function bulkDelete(Request $request)
{
    $paths = explode("\n", $request->input('bulk-delete'));

    $supabaseUrl = env('SUPABASE_URL');
    $serviceRoleKey = env('SUPABASE_SERVICE_ROLE_KEY');
    $table = 'archives';

    foreach ($paths as $path) {
        $cleanPath = trim($path);

        if (!empty($cleanPath)) {
            // Supabase REST API untuk hapus dengan filter path like
            $response = Http::withHeaders([
                'apikey' => $serviceRoleKey,
                'Authorization' => 'Bearer ' . $serviceRoleKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation', // opsional, untuk mendapatkan response data
            ])->delete("{$supabaseUrl}/rest/v1/{$table}?path=like.{$cleanPath}/%");

            if (!$response->successful()) {
                return back()->with('error', 'Gagal menghapus: ' . $cleanPath);
            }
        }
    }

    return back()->with('success', 'Folder dan isinya berhasil dihapus dari Supabase (archives).');
}
}
