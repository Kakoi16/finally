<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->storeAs('uploads', $filename, 'public');

            return back()->with('success', 'File berhasil diupload!');
        }

        return back()->with('error', 'Tidak ada file yang diupload.');
    }
}
