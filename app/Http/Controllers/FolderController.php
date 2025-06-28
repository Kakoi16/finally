<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // <--- Tambahkan ini
use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class FolderController extends Controller
{
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $uploadedBy = auth()->user()->id ?? null;
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
            'name' => $request->folder_name,
            'path' => $folderName,
            'type' => 'folder',
            'uploaded_by' => $uploadedBy,
            'size' => 0,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Folder berhasil dibuat.');
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
    }
   
}
