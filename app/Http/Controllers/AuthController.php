<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request)
{
    // Step 1: Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Step 2: Cek apakah email sudah ada di Supabase
    $checkEmail = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
    ])->get(env('SUPABASE_URL') . '/rest/v1/' . env('SUPABASE_TABLE') . '?email=eq.' . $request->email);

    if ($checkEmail->successful() && count($checkEmail->json()) > 0) {
        return back()->withErrors(['email' => 'Email sudah digunakan.']);
    }

    // Step 3: Buat user baru
    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'email_verified_at' => null,
    ];

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        'Content-Type'  => 'application/json',
        'Prefer'        => 'return=representation',
    ])->post(env('SUPABASE_URL') . '/rest/v1/' . env('SUPABASE_TABLE'), $userData);

    if (!$response->successful()) {
        return back()->withErrors(['error' => 'User registration failed.']);
    }

    $userId = $response->json()['id'] ?? null;

    if (!$userId) {
        return back()->withErrors(['error' => 'User created but ID not returned.']);
    }

    // Step 4: Generate token untuk verifikasi email
    $token = Str::random(60);

    $verificationData = [
        'user_id' => $userId,
        'token' => $token,
        'created_at' => now()->toISOString(),
    ];

    $verificationResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        'Content-Type'  => 'application/json',
    ])->post(env('SUPABASE_URL') . '/rest/v1/verification_tokens', $verificationData);

    if (!$verificationResponse->successful()) {
        return back()->withErrors(['error' => 'Gagal menyimpan token verifikasi.']);
    }

    // Step 5: Kirim email verifikasi
    $verificationUrl = route('verification.verify', ['token' => $token]);
    Mail::raw("Klik link berikut untuk verifikasi email Anda: $verificationUrl", function ($message) use ($request) {
        $message->to($request->email)->subject('Verifikasi Email');
    });

    return redirect()->route('login')->with('success', 'Link verifikasi telah dikirim ke email Anda.');
}

    // Email verification route handler
    public function verifyEmail($token)
    {
        // Verify the token in Supabase and activate the user
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get(env('SUPABASE_URL') . '/rest/v1/verification_tokens', [
            'token' => $token,
        ]);

        if ($response->successful() && $response->json()) {
            $verificationData = $response->json()[0];

            // Activate the user by updating their email_verified_at field
            $updateResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            ])->patch(env('SUPABASE_URL') . '/rest/v1/' . env('SUPABASE_TABLE') . '/' . $verificationData['user_id'], [
                'email_verified_at' => now(),
            ]);

            if ($updateResponse->successful()) {
                // Remove verification token (optional)
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                ])->delete(env('SUPABASE_URL') . '/rest/v1/verification_tokens/' . $verificationData['id']);

                return redirect()->route('login')->with('success', 'Your email has been verified.');
            }
        }

        return back()->withErrors(['error' => 'Invalid verification link.']);
    }
}
