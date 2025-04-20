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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $table = env('SUPABASE_TABLE');
        $headers = [
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ];
    
        // Cek email
        $checkEmail = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get("$supabaseUrl/rest/v1/$table?email=eq." . $request->email);
    
        if (!$checkEmail->successful()) {
            return back()->withErrors(['email' => 'Gagal memeriksa email: ' . $checkEmail->body()]);
        }
    
        if (count($checkEmail->json()) > 0) {
            return back()->withErrors(['email' => 'Email sudah digunakan.']);
        }
    
        // Buat user baru
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => null,
        ];
    
        $createUser = Http::withHeaders($headers)->post("$supabaseUrl/rest/v1/$table", $userData);
    
        if (!$createUser->successful()) {
            return back()->withErrors(['error' => 'Gagal membuat user: ' . $createUser->body()]);
        }
    
        $user = $createUser->json()[0] ?? null;
        $userId = $user['id'] ?? null;
    
        if (!$userId) {
            return back()->withErrors(['error' => 'User berhasil dibuat tapi ID tidak ditemukan.']);
        }
    
        // Simpan token
        $token = Str::random(60);
        $tokenData = [
            'user_id' => $userId,
            'token' => $token,
            'created_at' => now()->toISOString(),
        ];
    
        $saveToken = Http::withHeaders($headers)->post("$supabaseUrl/rest/v1/verification_tokens", $tokenData);
    
        if (!$saveToken->successful()) {
            return back()->withErrors(['error' => 'Gagal menyimpan token verifikasi: ' . $saveToken->body()]);
        }
    
        // Kirim email verifikasi
        $verificationUrl = route('verification.verify', ['token' => $token]);
    
        try {
            Mail::raw("Klik link berikut untuk verifikasi email Anda: $verificationUrl", function ($message) use ($request) {
                $message->to($request->email)->subject('Verifikasi Email');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }
    
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
