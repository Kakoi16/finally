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
    public function rename(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'required|string',
        ]);

        $folder = Http::withToken($this->supabaseKey)
            ->get($this->supabaseUrl . "?id=eq.$id&type=eq.folder")
            ->json()[0] ?? null;

        if (!$folder) {
            return response()->json(['success' => false, 'message' => 'Folder not found'], 404);
        }

        $oldPath = $folder['path'];
        $pathParts = explode('/', $oldPath);
        array_pop($pathParts);
        $newPath = implode('/', $pathParts) . '/' . Str::slug($request->new_name);

        $children = Http::withToken($this->supabaseKey)
            ->get($this->supabaseUrl . "?path=ilike.$oldPath%")
            ->json();

        foreach ($children as $child) {
            $updatedPath = preg_replace("#^" . preg_quote($oldPath) . "#", $newPath, $child['path']);

            Http::withToken($this->supabaseKey)
                ->patch($this->supabaseUrl . "?id=eq.{$child['id']}", [
                    'path' => $updatedPath,
                    'name' => ($child['id'] === $id) ? $request->new_name : $child['name'],
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Folder renamed successfully']);
    }
    
    public function destroy($id)
    {
        $folder = Http::withToken($this->supabaseKey)
            ->get($this->supabaseUrl . "?id=eq.$id&type=eq.folder")
            ->json()[0] ?? null;

        if (!$folder) {
            return response()->json(['success' => false, 'message' => 'Folder not found'], 404);
        }

        $pathPrefix = $folder['path'];

        $children = Http::withToken($this->supabaseKey)
            ->get($this->supabaseUrl . "?path=ilike.$pathPrefix%")
            ->json();

        foreach ($children as $item) {
            Http::withToken($this->supabaseKey)
                ->delete($this->supabaseUrl . "?id=eq.{$item['id']}");
        }

        return response()->json(['success' => true, 'message' => 'Folder and contents deleted']);
    }
    
}
