<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Str as StrAlias;


class FileController extends Controller
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
  public function upload(Request $request, $folderPath = null)
{
    $request->validate([
        'file' => 'required|file',
    ]);

    $file = $request->file('file');
    $uploadedBy = auth()->user()->id ?? null;

    $cleanedPath = trim($folderPath ?? '', '/');
    $originalName = $this->sanitizeFilename($file->getClientOriginalName());

    $relativePath = $cleanedPath !== '' ? $cleanedPath . '/' . $originalName : $originalName;
    $storagePath = 'uploads/' . ($cleanedPath !== '' ? $cleanedPath . '/' : '');
    $storedFilePath = $file->storeAs($storagePath, $originalName, 'public');

    if (!$storedFilePath) {
        return redirect()->back()->with('error', 'Gagal menyimpan file secara lokal.');
    }

    // Simpan metadata ke database lokal
    Archive::create([
        'id' => Str::uuid(),
        'name' => $originalName,
        'path' => $relativePath,
        'type' => $file->getClientMimeType(),
        'size' => $file->getSize(),
        'uploaded_by' => $uploadedBy,
        'created_at' => Carbon::now(),
    ]);

    return redirect()->back()->with('success', 'File berhasil di-upload.');
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
    $currentFolder = trim($folderName ?? '', '/');

    $files = Archive::all();

    $filteredFiles = $files->filter(function ($file) use ($currentFolder) {
        $path = $file->path;

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
    $baseName = $request->base_name;
    $items = $request->items;
    $startingNumber = $request->starting_number;

    foreach ($items as $index => $itemPath) {
        $item = Archive::where('path', $itemPath)->first();

        if (!$item) continue;

        $extension = pathinfo($item->name, PATHINFO_EXTENSION);
        $number = $startingNumber + $index;
        $newName = "{$baseName} {$number}" . ($extension ? ".{$extension}" : '');

        $parentDir = dirname($itemPath);
        $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;

        $newPath = ltrim($parentDir . '/' . $newName, '/');

        // Rename file/folder di storage
        $oldStoragePath = storage_path('app/public/uploads/' . $itemPath);
        $newStoragePath = storage_path('app/public/uploads/' . $newPath);

        if (File::exists($oldStoragePath)) {
            File::move($oldStoragePath, $newStoragePath);
        }

        // Update di database
        $item->update([
            'name' => $newName,
            'path' => $newPath,
        ]);
    }

    return redirect()->back()->with('success', 'Item berhasil diubah namanya.');
}


public function deleteItem(Request $request, $itemPath)
{
    $decodedPath = urldecode($itemPath);
    $fullStoragePath = storage_path('app/public/uploads/' . $decodedPath);

    // Hapus dari database
    Archive::where('path', $decodedPath)->delete();

    // Hapus file/folder dari storage
    if (File::isFile($fullStoragePath)) {
        File::delete($fullStoragePath);
    } elseif (File::isDirectory($fullStoragePath)) {
        File::deleteDirectory($fullStoragePath);
    }

    return redirect()->back()->with('success', 'Item berhasil dihapus.');
}

    public function renameItem(Request $request, $itemPath)
{
    $request->validate([
        'new_name' => 'required|string|max:255',
    ]);

    $decodedPath = urldecode($itemPath);
    $item = Archive::where('path', $decodedPath)->first();

    if (!$item) {
        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }

    $newName = $request->new_name;
    $parentDir = dirname($decodedPath);
    $parentDir = ($parentDir === '.' || $parentDir === './') ? '' : $parentDir;

    $newPath = ltrim($parentDir . '/' . $newName, '/');

    $oldStoragePath = storage_path('app/public/uploads/' . $decodedPath);
    $newStoragePath = storage_path('app/public/uploads/' . $newPath);

    if (File::exists($oldStoragePath)) {
        File::move($oldStoragePath, $newStoragePath);
    }

    $item->update([
        'name' => $newName,
        'path' => $newPath,
    ]);

    return redirect()->back()->with('success', 'Item berhasil diubah namanya.');
}

public function bulkDelete(Request $request)
{
    $rawInput = $request->input('bulk-delete');
    $paths = preg_split('/\r\n|\r|\n/', $rawInput);

    foreach ($paths as $path) {
        $cleanPath = trim($path);
        if (empty($cleanPath)) continue;

        // Tandai sebagai sampah
        Archive::where('path', $cleanPath)
            ->orWhere('path', 'like', $cleanPath . '/%')
            ->update([
                'is_deleted' => true,
                'deleted_at' => Carbon::now(),
            ]);
    }

    return redirect()->back()->with('success', 'Item berhasil dipindahkan ke sampah.');
}
// Menampilkan halaman sampah
public function viewTrash()
{
    $trashedItems = Archive::where('is_deleted', true)->get();
    return view('archive.pages.trash', compact('trashedItems'));
}

// Restore file
public function restore(Request $request)
{
    $id = $request->input('id');
    Archive::where('id', $id)->update([
        'is_deleted' => false,
        'deleted_at' => null,
    ]);

    return redirect()->route('archive.trash')->with('success', 'Item berhasil dikembalikan.');
}

// Hapus permanen
public function deletePermanent(Request $request)
{
    $id = $request->input('id');
    $item = Archive::find($id);

    if ($item) {
        $storagePath = storage_path('app/public/uploads/' . $item->path);

        if (File::isFile($storagePath)) {
            File::delete($storagePath);
        } elseif (File::isDirectory($storagePath)) {
            File::deleteDirectory($storagePath);
        }

        $item->delete();
    }

    return redirect()->route('archive.trash')->with('success', 'Item dihapus permanen.');
}

}