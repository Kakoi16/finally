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
        ])->get($this->supabaseUrl, [
            'filter' => 'folder.eq.' . $folderName,  // Sesuaikan dengan query Supabase yang benar
        ]);
        
    
        // Cek apakah respons berhasil dan formatnya sesuai dengan yang diharapkan
        if ($response->successful()) {
            $files = $response->json();  // Pastikan respons sudah berupa array atau objek yang sesuai
        } else {
            // Jika gagal, kembalikan error atau data kosong
            $files = [];
        }
    
        // Kirim data ke view
        return view('archive.pages.folder-detail', compact('folderName', 'files'));
    }
    
    
}
