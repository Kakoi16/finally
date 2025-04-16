<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Panggil Supabase untuk cek user berdasarkan email
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
        ])->get(env('SUPABASE_URL') . "/rest/v1/users?email=eq.{$googleUser->email}");

        $data = $response->json();

        // Jika user belum ada, insert ke Supabase
        if (count($data) === 0) {
            $response = Http::withHeaders([
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => "Bearer " . env('SUPABASE_API_KEY'),
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->post(env('SUPABASE_URL') . "/rest/v1/users", [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)), // buat password random
                'email_verified' => true
            ]);

            $data = $response->json();
        }

        // Simpan session
        session(['user' => $data[0]]);

        return redirect('/dashboard')->with('success', 'Login dengan Google berhasil');
    }
}
