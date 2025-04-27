<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FolderController extends Controller
{
    // Method untuk create folder
    public function create(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $folderName = trim($request->input('folder_name'));
        $path = 'uploads/' . $folderName . '/placeholder.txt'; // Supabase butuh file agar folder eksis

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/octet-stream',
        ])->put(env('SUPABASE_URL') . '/storage/v1/object/storage/' . $path, '');

        if ($response->successful()) {
            return back()->with('success', 'Folder berhasil dibuat!');
        }

        return back()->with('error', 'Gagal membuat folder: ' . $response->body());
    }

    // Method untuk menampilkan halaman folder
    public function show($folderName)
    {
        return view('archive.pages.folder-detail', compact('folderName'));
    }
    
}
