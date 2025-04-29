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
    // Method untuk create folder
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

    public function show($folderName)
    {
        // Query ke Supabase atau database untuk mendapatkan data file dalam folder
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->get($this->supabaseUrl . '?path=like.uploads/' . $folderName . '/%');
    
        if ($response->successful()) {
            $files = $response->json();
        } else {
            $files = [];
        }
    
        // Path folder saat ini
        $currentFolder = 'uploads/' . $folderName;
    
        // FILTER supaya hanya tampil file/folder di dalam folder ini saja (bukan subfolder/subfile lebih dalam)
        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';
    
            // Harus mulai dengan current folder
            if (Str::startsWith($path, $currentFolder . '/')) {
                $remainingPath = Str::after($path, $currentFolder . '/');
    
                // Pastikan tidak ada "/" lagi (artinya langsung di dalam folder ini, bukan subfolder)
                return !Str::contains($remainingPath, '/');
            }
    
            return false;
        });
    
        return view('archive.pages.folder-detail', [
            'folderName' => $folderName,
            'files' => $filteredFiles
        ]);
    }
    
    
    public function createSubfolder(Request $request, $parentFolder)
{
    $request->validate([
        'folder_name' => 'required|string|max:255',
    ]);

    $uploadedBy = auth()->user()->id ?? null;

    $newPath = 'uploads/' . $parentFolder . '/' . Str::slug($request->folder_name);

    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
        'Content-Type' => 'application/json',
        'Prefer' => 'return=minimal',
    ])->post($this->supabaseUrl, [
        'name' => $request->folder_name,
        'path' => $newPath,
        'type' => 'folder',
        'size' => 0,
        'uploaded_by' => $uploadedBy,
    ]);

    if ($response->successful()) {
        return redirect()->back()->with('success', 'Subfolder berhasil dibuat.');
    } else {
        return redirect()->back()->with('error', 'Gagal membuat subfolder.');
    }
}
public function showAnyFolder($any)
{
    // Path sesuai struktur di Supabase
    $supabasePath = 'uploads/' . $any;

    $response = Http::withHeaders([
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
        'Content-Type' => 'application/json',
    ])->get($this->supabaseUrl . '?path=like.' . $supabasePath . '/%');

    if ($response->successful()) {
        $files = $response->json();
    } else {
        $files = [];
    }

    // Path folder saat ini
    $currentFolder = $supabasePath;

    // FILTER hanya file/folder LANGSUNG di folder saat ini (bukan yang lebih dalam)
    $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
        $path = $file['path'] ?? '';

        if (Str::startsWith($path, $currentFolder . '/')) {
            $remainingPath = Str::after($path, $currentFolder . '/');

            // Jika sisa path tidak mengandung "/", artinya ini langsung di dalam currentFolder
            return !Str::contains($remainingPath, '/');
        }

        return false;
    });

    // Untuk breadcrumb, ambil daftar semua segment folder
    $segments = explode('/', $any);
    $breadcrumbs = [];
    $pathSoFar = '';

    foreach ($segments as $segment) {
        if ($pathSoFar === '') {
            $pathSoFar = $segment;
        } else {
            $pathSoFar .= '/' . $segment;
        }

        $breadcrumbs[] = [
            'name' => urldecode($segment),
            'path' => $pathSoFar,
        ];
    }

    // Nama folder terakhir
    $folderName = urldecode(end($segments));

    return view('archive.pages.folder-detail', [
        'folderName' => $folderName,
        'folderPath' => $any,
        'files' => $filteredFiles,
        'breadcrumbs' => $breadcrumbs,
    ]);
}


}
