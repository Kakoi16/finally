<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL') . '/rest/v1/archives';
        $this->supabaseKey = env('SUPABASE_API_KEY');
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
            'path' => Str::slug($request->folder_name),
            'type' => 'folder',
            'uploaded_by' => $uploadedBy,
        ]);

        return $response->successful()
            ? redirect()->back()->with('success', 'Folder berhasil dibuat.')
            : redirect()->back()->with('error', 'Gagal membuat folder.');
    }

    public function show($folderName)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=like.' . $folderName . '/%');

        $files = $response->successful() ? $response->json() : [];

        $currentFolder = $folderName;

        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';
            if (Str::startsWith($path, $currentFolder . '/')) {
                $remainingPath = Str::after($path, $currentFolder . '/');
                return !Str::contains($remainingPath, '/');
            }
            return false;
        });

        $segments = explode('/', $folderName);
        $breadcrumbs = [];
        $pathSoFar = '';

        foreach ($segments as $segment) {
            $pathSoFar = $pathSoFar === '' ? $segment : $pathSoFar . '/' . $segment;
            $breadcrumbs[] = [
                'name' => urldecode($segment),
                'path' => $pathSoFar,
            ];
        }

        return view('archive.pages.folder-detail', [
            'folderName' => $folderName,
            'files' => $filteredFiles,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function createSubfolder(Request $request, $path)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $uploadedBy = auth()->user()->id ?? null;
        $newPath = trim($path, '/') . '/' . Str::slug($request->folder_name);

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ])->post($this->supabaseUrl, [
            'name' => $request->folder_name,
            'path' => $newPath,
            'type' => 'folder',
            'uploaded_by' => $uploadedBy,
        ]);

        return $response->successful()
            ? redirect()->back()->with('success', 'Subfolder berhasil dibuat.')
            : redirect()->back()->with('error', 'Gagal membuat subfolder.');
    }

    public function showAnyFolder($any)
    {
        $supabasePath = $any;

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=like.' . $supabasePath . '/%');

        $files = $response->successful() ? $response->json() : [];

        $currentFolder = $supabasePath;

        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';
            if (Str::startsWith($path, $currentFolder . '/')) {
                $remainingPath = Str::after($path, $currentFolder . '/');
                return !Str::contains($remainingPath, '/');
            }
            return false;
        });

        $segments = explode('/', $any);
        $breadcrumbs = [];
        $pathSoFar = '';

        foreach ($segments as $segment) {
            $pathSoFar = $pathSoFar === '' ? $segment : $pathSoFar . '/' . $segment;
            $breadcrumbs[] = [
                'name' => urldecode($segment),
                'path' => $pathSoFar,
            ];
        }

        $folderName = urldecode(end($segments));

        return view('archive.pages.folder-detail', [
            'folderName' => $folderName,
            'folderPath' => $any,
            'files' => $filteredFiles,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function bulkRename(Request $request)
{
    $request->validate([
        'renames' => 'required|string'
    ]);

    $lines = explode("\n", trim($request->renames));
    $successCount = 0;

    foreach ($lines as $line) {
        $parts = explode('-->', $line);

        // Cek apakah format valid
        if (count($parts) < 2) {
            continue; // Lewati baris yang tidak valid
        }

        [$oldPath, $newName] = $parts;
        $oldPath = trim($oldPath);
        $newName = trim($newName);

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=eq.' . $oldPath);

        if (!$response->successful() || empty($response->json())) {
            continue;
        }

        $item = $response->json()[0];
        $newPath = dirname($oldPath) . '/' . Str::slug($newName);

        $updateResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->patch($this->supabaseUrl . '?id=eq.' . $item['id'], [
            'name' => $newName,
            'path' => $newPath,
        ]);

        if ($updateResponse->successful()) {
            $successCount++;
        }
    }

    return redirect()->back()->with('success', "$successCount item berhasil di-rename.");
}


    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|string'
        ]);

        $paths = explode("\n", trim($request->input('selected_items'))); // explode manual dari textarea
        $paths = array_map('trim', $paths);
        
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . '?path=in.(' . implode(',', $paths) . ')');
        

        return $response->successful()
            ? redirect()->back()->with('success', 'Item terpilih berhasil dihapus.')
            : redirect()->back()->with('error', 'Gagal menghapus item terpilih.');
    }
    public function renameFolder(Request $request, $folderPath)
    {
        $request->validate([
            'new_name' => 'required|string|max:255',
        ]);

        // Get the folder to rename
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=eq.' . $folderPath);

        if (!$response->successful() || empty($response->json())) {
            return redirect()->back()->with('error', 'Folder tidak ditemukan.');
        }

        $folder = $response->json()[0];
        $newPath = dirname($folderPath) . '/' . Str::slug($request->new_name);

        // Update the folder
        $updateResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->patch($this->supabaseUrl . '?id=eq.' . $folder['id'], [
            'name' => $request->new_name,
            'path' => $newPath,
        ]);

        // Update all files/folders inside this folder
        $childrenResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=like.' . $folderPath . '/%');
        
        if ($childrenResponse->successful()) {
            foreach ($childrenResponse->json() as $child) {
                $newChildPath = Str::replaceFirst($folderPath, $newPath, $child['path']);
        
                Http::withHeaders([
                    'apikey' => $this->supabaseKey,
                    'Authorization' => 'Bearer ' . $this->supabaseKey,
                    'Content-Type' => 'application/json',
                ])->patch($this->supabaseUrl . '?id=eq.' . $child['id'], [
                    'path' => $newChildPath,
                ]);
            }
        }
        
        return $updateResponse->successful()
            ? redirect()->route('folders.showAny', ['any' => $newPath])->with('success', 'Folder berhasil diubah nama.')
            : redirect()->back()->with('error', 'Gagal mengubah nama folder.');
    }

    /**
     * Delete a folder and its contents
     */
    public function deleteFolder(Request $request, $folderPath)
    {
        // First delete all contents of the folder
        $deleteContentsResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . '?path=like.' . $folderPath . '/%');

        // Then delete the folder itself
        $deleteFolderResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . '?path=eq.' . $folderPath);

        return $deleteFolderResponse->successful()
            ? redirect()->route('archive')->with('success', 'Folder dan isinya berhasil dihapus.')
            : redirect()->back()->with('error', 'Gagal menghapus folder.');
    }
    
}
