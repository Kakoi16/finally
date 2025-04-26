<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function create(Request $request)
    {
        $folderName = $request->input('folder_name');

        if ($folderName) {
            Storage::disk('public')->makeDirectory('uploads/' . $folderName);
            return back()->with('success', 'Folder berhasil dibuat!');
        }

        return back()->with('error', 'Nama folder tidak boleh kosong.');
    }
}
