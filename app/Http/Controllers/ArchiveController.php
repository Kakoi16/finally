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
    
        try {
            $response = Http::withHeaders($headers)
                ->get("$supabaseUrl/rest/v1/archives?select=*");
    
            if (!$response->successful()) {
                throw new \Exception('Supabase API error: ' . $response->body());
            }
    
            $archives = $response->json();
            return view('archive.archive', [
                'archives' => $archives,
                'files' => $archives, // tambahan ini untuk all-files
            ]);
            
    
        } catch (\Exception $e) {
            return response()->view('errors.custom', ['message' => $e->getMessage()], 500);
        }
    }
    
}
