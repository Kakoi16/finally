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

    // Ambil data folder utama (path persis)
    $folder = Http::withHeaders([
    'apikey' => $this->supabaseKey,
    'Authorization' => 'Bearer ' . $this->supabaseKey,
])->get($this->supabaseUrl . '?path=eq.' . $currentFolder)->json();

$folder = $folder[0] ?? null;

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
        'folderId' => $folder['id'] ?? null,
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

    // Ambil data folder utama (path persis)
    $folder = Http::withHeaders([
    'apikey' => $this->supabaseKey,
    'Authorization' => 'Bearer ' . $this->supabaseKey,
])->get($this->supabaseUrl . '?path=eq.' . $currentFolder)->json();

$folder = $folder[0] ?? null;

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
        'folderId' => $folder['id'] ?? null,
        'folderName' => $folderName,
        'folderPath' => $any,
        'files' => $filteredFiles,
        'breadcrumbs' => $breadcrumbs,
    ]);
}

    public function rename(Request $request, $id)
{
    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
        'Content-Type' => 'application/json',
    ])->patch($this->supabaseUrl . '?id=eq.' . $id, [
        'name' => $request->name,
    ]);

    return response()->json(['success' => $response->successful()]);
}

public function bulkDelete(Request $request)
{
    $ids = $request->ids;

    $query = implode(',', array_map(fn($id) => '"' . $id . '"', $ids));
    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ])->delete($this->supabaseUrl . '?id=in.(' . $query . ')');

    return response()->json(['success' => $response->successful()]);
}

}
