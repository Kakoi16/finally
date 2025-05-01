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
        $this->validate($request, [
            'new_name' => 'required|string',
        ]);
    
        // Ambil folder lama
        $folder = Http::withToken(env('SUPABASE_API_KEY'))
            ->get(env('SUPABASE_URL') . "/rest/v1/archives?id=eq.$id&type=eq.folder")
            ->json()[0] ?? null;
    
        if (!$folder) {
            return response()->json(['success' => false, 'message' => 'Folder not found']);
        }
    
        $oldPath = $folder['path'];
        $pathParts = explode('/', $oldPath);
        array_pop($pathParts); // hapus nama lama
        $newPath = implode('/', $pathParts) . '/' . $request->new_name;
    
        // Update semua yang path-nya dimulai dengan oldPath
        $children = Http::withToken(env('SUPABASE_API_KEY'))
            ->get(env('SUPABASE_URL') . "/rest/v1/archives?path=ilike.$oldPath%")
            ->json();
    
        foreach ($children as $child) {
            $updatedPath = preg_replace("#^" . preg_quote($oldPath) . "#", $newPath, $child['path']);
    
            Http::withToken(env('SUPABASE_API_KEY'))
                ->patch(env('SUPABASE_URL') . "/rest/v1/archives?id=eq.{$child['id']}", [
                    'path' => $updatedPath,
                    'name' => ($child['id'] === $id) ? $request->new_name : $child['name'], // ganti name hanya untuk folder utama
                ]);
        }
    
        return response()->json(['success' => true, 'message' => 'Folder renamed successfully']);
    }
    
    public function destroy($id)
    {
        $folder = Http::withToken(env('SUPABASE_API_KEY'))
            ->get(env('SUPABASE_URL') . "/rest/v1/archives?id=eq.$id&type=eq.folder")
            ->json()[0] ?? null;
    
        if (!$folder) {
            return response()->json(['success' => false, 'message' => 'Folder not found']);
        }
    
        $pathPrefix = $folder['path'];
    
        // Ambil semua item yang path-nya dimulai dengan path folder
        $children = Http::withToken(env('SUPABASE_API_KEY'))
            ->get(env('SUPABASE_URL') . "/rest/v1/archives?path=ilike.$pathPrefix%")
            ->json();
    
        foreach ($children as $item) {
            Http::withToken(env('SUPABASE_API_KEY'))
                ->delete(env('SUPABASE_URL') . "/rest/v1/archives?id=eq.{$item['id']}");
        }
    
        return response()->json(['success' => true, 'message' => 'Folder and contents deleted']);
    }
    
}
