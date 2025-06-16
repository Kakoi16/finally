<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
<<<<<<< HEAD

public function downloadFile($encodedPath)
=======
    public function downloadFile($encodedPath)
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
{
    $baseFolder = storage_path("app/public/uploads");
    $decodedParam = urldecode($encodedPath);
    $relativePath = base64_decode($decodedParam);
    $fullPath = realpath($baseFolder . DIRECTORY_SEPARATOR . $relativePath);

    if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
        abort(403, "Access denied.");
    }

<<<<<<< HEAD
    // Cek file dalam database
    $archive = Archive::where('path', $relativePath)->first();
if (!$archive || $archive->is_deleted) {
    abort(403, "This folder has been deleted.");
}


=======
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    if (!File::exists($fullPath) || !File::isFile($fullPath)) {
        abort(404, "File not found.");
    }

    return response()->download($fullPath);
}
<<<<<<< HEAD
=======

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    public function downloadFolder($encodedPath)
    {
        $baseFolder = storage_path("app/public/uploads");
        $decodedParam = urldecode($encodedPath);
        $relativePath = base64_decode($decodedParam);
        $fullPath = realpath($baseFolder . DIRECTORY_SEPARATOR . $relativePath);

        if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
            abort(403, "Access denied.");
        }

        if (!File::exists($fullPath) || !File::isDirectory($fullPath)) {
            abort(404, "Folder not found.");
        }

        $zipFileName = Str::slug(basename($fullPath)) . '.zip';
        $zipFilePath = storage_path("app/temp_zips/{$zipFileName}");

        // Pastikan direktori penyimpanan zip ada
        if (!File::exists(storage_path('app/temp_zips'))) {
            File::makeDirectory(storage_path('app/temp_zips'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }

        // Tambahkan folder ke dalam ZIP
        $this->addFolderToZip($fullPath, $zip, strlen($fullPath) + 1);

        // Jika kosong total, pastikan folder induknya tetap dimasukkan
        if ($zip->numFiles === 0) {
            $zip->addEmptyDir(basename($fullPath));
        }

        $zip->close();

        if (!File::exists($zipFilePath)) {
            return response()->json(['error' => 'ZIP file was not created.'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    private function addFolderToZip($folder, ZipArchive $zip, $stripLength)
    {
        $dirIterator = new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            $realPath = $file->getRealPath();
            $localPath = substr($realPath, $stripLength);

            if ($file->isDir()) {
                $zip->addEmptyDir($localPath);
            } else {
                $zip->addFile($realPath, $localPath);
            }
        }
    }
}
