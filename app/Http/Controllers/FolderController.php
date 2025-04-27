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

 // Method untuk menampilkan halaman folder
 public function show($folderName)
 {
     // Ambil daftar file berdasarkan folderName dari Supabase (atau database)
     $response = Http::withHeaders([
         'apikey' => $this->supabaseKey,
         'Authorization' => 'Bearer ' . $this->supabaseKey,
         'Content-Type' => 'application/json',
     ])->get($this->supabaseUrl, [
         'folder' => $folderName, // Misalnya ada kolom 'folder' yang menyimpan nama folder
     ]);
 
     $files = $response->json();
 
     return view('archive.pages.folder-detail', compact('folderName', 'files'));
 }
 
    
}
