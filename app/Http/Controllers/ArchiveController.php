<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArchiveController extends Controller
{
    public function index()
    {
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $headers = [
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'apikey'        => env('SUPABASE_API_KEY'),
        ];

        // Ambil semua data file dari tabel archives
        $response = Http::withHeaders($headers)
            ->get("$supabaseUrl/rest/v1/archives?select=*");

        if (!$response->successful()) {
            abort(500, 'Gagal mengambil data file.');
        }

        $archives = $response->json();

        return view('archive.archive', compact('archives'));
    }
}
