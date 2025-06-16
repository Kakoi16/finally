<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // <--- Tambahkan ini
use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class FolderController extends Controller
{
=======

class FolderController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL') . '/rest/v1/archives';
        $this->supabaseKey = env('SUPABASE_API_KEY');
    }

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);
    
        $uploadedBy = auth()->user()->id ?? null;
<<<<<<< HEAD
        $folderName = Str::slug($request->folder_name);
        $localPath = storage_path('app/public/uploads/' . $folderName);

        if (file_exists($localPath)) {
            return redirect()->back()->with('warning', 'Folder sudah ada.');
        }

        if (!Storage::disk('public')->makeDirectory('uploads/' . $folderName)) {
            return redirect()->back()->with('error', 'Gagal membuat folder secara lokal.');
        }

        Archive::create([
            'id' => Str::uuid(),
=======
    
        // Sanitasi nama folder
        $folderName = Str::slug($request->folder_name);
        $localPath = storage_path('app/public/uploads/' . $folderName);
    
        // Cek jika folder sudah ada
        if (file_exists($localPath)) {
            return redirect()->back()->with('warning', 'Folder sudah ada.');
        }
    
        // Buat folder secara lokal
        if (!Storage::disk('public')->makeDirectory('uploads/' . $folderName)) {
            return redirect()->back()->with('error', 'Gagal membuat folder secara lokal.');
        }
    
        // Simpan metadata ke Supabase (hanya data, bukan file)
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ])->post($this->supabaseUrl, [
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            'name' => $request->folder_name,
            'path' => $folderName,
            'type' => 'folder',
            'uploaded_by' => $uploadedBy,
            'size' => 0,
            'created_at' => Carbon::now(),
        ]);
<<<<<<< HEAD

        return redirect()->back()->with('success', 'Folder berhasil dibuat.');
=======
    
        return $response->successful()
            ? redirect()->back()->with('success', 'Folder berhasil dibuat.')
            : redirect()->back()->with('error', 'Folder dibuat lokal, tapi gagal simpan metadata.');
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    }
    

    public function show($folderName)
    {
<<<<<<< HEAD
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?path=like.' . $folderName . '/%');

        $files = $response->successful() ? $response->json() : [];

        $currentFolder = $folderName;
=======
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
        $localSubfolderPath = storage_path('app/public/uploads/' . $newPath);

        if (!Storage::disk('public')->makeDirectory('uploads/' . $newPath)) {
            return redirect()->back()->with('error', 'Gagal membuat subfolder secara lokal.');
        }
        
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
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819

        $filteredFiles = array_filter($files, function ($file) use ($currentFolder) {
            $path = $file['path'] ?? '';
            if (Str::startsWith($path, $currentFolder . '/')) {
                $remainingPath = Str::after($path, $currentFolder . '/');
                return !Str::contains($remainingPath, '/');
            }
            return false;
        });
<<<<<<< HEAD

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

    // Buat folder di storage lokal
    if (!Storage::disk('public')->makeDirectory('uploads/' . $newPath)) {
        return redirect()->back()->with('error', 'Gagal membuat subfolder secara lokal.');
    }

    // Simpan ke database dengan UUID manual
    $created = Archive::create([
        'id' => (string) Str::uuid(),
        'name' => $request->folder_name,
        'path' => $newPath,
        'type' => 'folder',
        'size' => 0, // folder size default 0
        'uploaded_by' => $uploadedBy,
    ]);

    return $created
        ? redirect()->back()->with('success', 'Subfolder berhasil dibuat.')
        : redirect()->back()->with('error', 'Gagal menyimpan data folder ke database.');
}
public function showAnyFolder($any)
{
    $currentFolder = $any;

    // Ambil semua file/folder yang path-nya dimulai dengan currentFolder + '/'
    $files = Archive::where('path', 'like', $currentFolder . '/%')->get();

    // Filter agar hanya menampilkan file/folder langsung di dalam currentFolder (bukan subfolder)
    $filteredFiles = $files->filter(function ($file) use ($currentFolder) {
        $path = $file->path ?? '';
        if (Str::startsWith($path, $currentFolder . '/')) {
            $remainingPath = Str::after($path, $currentFolder . '/');
            return !Str::contains($remainingPath, '/');
        }
        return false;
    });

    // Generate breadcrumbs
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
        $parts = explode('➡️', $line);

        if (count($parts) < 2) {
            continue; // Format tidak valid
        }

        [$oldPath, $newName] = array_map('trim', $parts);

        $item = Archive::where('path', $oldPath)->first();
        if (!$item) continue;

        $parentDir = dirname($oldPath);
        $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;
        $newPath = ltrim($parentDir . '/' . $newName, '/');

        $oldStoragePath = 'uploads/' . ltrim($oldPath, '/');
        $newStoragePath = 'uploads/' . $newPath;

        // Rename fisik folder/file
        if (Storage::disk('public')->exists($oldStoragePath)) {
            Storage::disk('public')->move($oldStoragePath, $newStoragePath);
        }

        // Update data utama
        $item->update([
            'name' => $newName,
            'path' => $newPath,
        ]);

        // Jika item adalah folder, update seluruh isinya
        if ($item->type === 'folder') {
            $childItems = Archive::where('path', 'like', $oldPath . '/%')->get();

            foreach ($childItems as $child) {
                $newChildPath = preg_replace('#^' . preg_quote($oldPath, '#') . '#', $newPath, $child->path);
                $oldChildStoragePath = 'uploads/' . $child->path;
                $newChildStoragePath = 'uploads/' . $newChildPath;

                // Update path di database
                $child->update(['path' => $newChildPath]);

                // Pindah file/folder fisik
                if (Storage::disk('public')->exists($oldChildStoragePath)) {
                    // Pastikan direktori tujuan ada
                    Storage::disk('public')->makeDirectory(dirname($newChildStoragePath));
                    Storage::disk('public')->move($oldChildStoragePath, $newChildStoragePath);
                }
            }
        }

        $successCount++;
    }

    return redirect()->back()->with('success', "$successCount item berhasil di-rename.");
}





public function testRenameFolder(Request $request)
{
    // Folder lama dan nama baru folder (slug)
    $oldFolderPath = 'folderlama'; // contoh folder lama
    $newFolderName = 'folderbaru'; // nama baru yang ingin dipakai
    $parentDir = ''; // jika folder di root uploads

    $oldFullPath = storage_path('app/public/uploads/' . $oldFolderPath);
    $newFullPath = storage_path('app/public/uploads/' . ($parentDir ? $parentDir . '/' : '') . $newFolderName);

    \Log::info("Rename folder dari $oldFullPath ke $newFullPath");

    // Cek folder lama ada atau tidak
    if (!file_exists($oldFullPath)) {
        return "Folder lama tidak ditemukan: $oldFullPath";
    }

    // Cek folder baru sudah ada atau belum
    if (file_exists($newFullPath)) {
        return "Folder baru sudah ada: $newFullPath";
    }

    // Rename folder secara fisik
    if (!rename($oldFullPath, $newFullPath)) {
        \Log::error("Gagal rename folder fisik");
        return "Gagal rename folder fisik";
    }

    \Log::info("Rename folder fisik berhasil");

    // Update database path folder utama
    $folder = Archive::where('path', $oldFolderPath)->where('type', 'folder')->first();
    if (!$folder) {
        return "Folder database tidak ditemukan";
    }

    $folder->update([
        'name' => $newFolderName,
        'path' => ($parentDir ? $parentDir . '/' : '') . $newFolderName,
    ]);

    \Log::info("Update database folder utama berhasil");

    // Update semua anak folder/file yang path-nya diawali oldFolderPath
    $children = Archive::where('path', 'like', $oldFolderPath . '/%')->get();

    foreach ($children as $child) {
        $newChildPath = preg_replace('#^' . preg_quote($oldFolderPath, '#') . '#', ($parentDir ? $parentDir . '/' : '') . $newFolderName, $child->path);
        \Log::info("Update child path: {$child->path} => $newChildPath");
        $child->update(['path' => $newChildPath]);
    }

    return "Rename folder dan update path berhasil.";
}

   public function deleteFolder(Request $request, $folderPath)
    {
        $folder = Archive::where('path', $folderPath)->where('type', 'folder')->first();
        if (!$folder) {
            return redirect()->back()->with('error', 'Folder tidak ditemukan.');
        }

        $children = Archive::where('path', 'like', $folderPath . '/%')->get();
        foreach ($children as $child) {
            $childStoragePath = 'uploads/' . ltrim($child->path, '/');
            if (Storage::disk('public')->exists($childStoragePath)) {
                Storage::disk('public')->delete($childStoragePath);
            }
            $child->delete();
        }

        $folderStoragePath = 'uploads/' . ltrim($folderPath, '/');
        if (Storage::disk('public')->exists($folderStoragePath)) {
            Storage::disk('public')->deleteDirectory($folderStoragePath);
        }

        $folder->delete();

        return redirect()->route('archive')->with('success', 'Folder dan isinya berhasil dihapus.');
=======

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
            $parts = explode('➡️', $line);
    
            if (count($parts) < 2) {
                continue; // Format tidak valid
            }
    
            [$oldPath, $newName] = array_map('trim', $parts);
    
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . '?path=eq.' . $oldPath);
    
            if (!$response->successful() || empty($response->json())) {
                continue;
            }
    
            $item = $response->json()[0];
            $parentDir = dirname($oldPath);
            $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;
    
            $oldStoragePath = 'uploads/' . ltrim($oldPath, '/');
            $newStoragePath = 'uploads/' . ltrim($parentDir . '/' . $newName, '/');
    
            $updateResponse = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
            ])->patch($this->supabaseUrl . '?id=eq.' . $item['id'], [
                'name' => $newName,
                'path' => ltrim($parentDir . '/' . $newName, '/'),
            ]);
    
            if ($updateResponse->successful()) {
                // Rename file di storage lokal
                if (Storage::disk('public')->exists($oldStoragePath)) {
                    Storage::disk('public')->move($oldStoragePath, $newStoragePath);
                }
    
                $successCount++;
            }
        }
    
        return redirect()->back()->with('success', "$successCount item berhasil di-rename.");
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
        $parentDir = dirname($folderPath);
        $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;
        $newPath = ltrim($parentDir . '/' . Str::slug($request->new_name), '/');

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
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    }
   
}
