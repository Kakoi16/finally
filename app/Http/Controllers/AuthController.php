<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,karyawan'
        ]);

        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $table       = env('SUPABASE_TABLE');
        $headers     = [
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'apikey'        => env('SUPABASE_API_KEY'),
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=representation',
        ];

        // Cek apakah email sudah digunakan
        $checkEmail = Http::withHeaders($headers)
            ->get("$supabaseUrl/rest/v1/$table?email=eq." . $request->email);

        if (!$checkEmail->successful()) {
            return response()->json(['success' => false, 'message' => 'Gagal memeriksa email.'], 500);
        }

        if (count($checkEmail->json()) > 0) {
            return response()->json(['success' => false, 'message' => 'Email sudah digunakan.'], 409);
        }

        // Buat user baru
        $userData = [
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'role'              => $request->role,
            'email_verified_at' => null,
        ];

        $createUser = Http::withHeaders($headers)
            ->post("$supabaseUrl/rest/v1/$table", $userData);

        if (!$createUser->successful()) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat user.'], 500);
        }

        $user   = $createUser->json()[0] ?? null;
        $userId = $user['id'] ?? null;

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User berhasil dibuat tapi ID tidak ditemukan.'], 500);
        }

        // Buat token verifikasi
        $token     = Str::random(60);
        $tokenData = [
            'user_id'    => $userId,
            'token'      => $token,
            'created_at' => now()->toISOString(),
        ];

        $saveToken = Http::withHeaders($headers)
            ->post("$supabaseUrl/rest/v1/verification_tokens", $tokenData);

        if (!$saveToken->successful()) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan token verifikasi.'], 500);
        }

        // Kirim email verifikasi
        $verificationUrl = route('verification.verify', ['token' => $token]);

        try {
            Mail::raw("Klik link berikut untuk verifikasi email Anda: $verificationUrl", function ($message) use ($request) {
                $message->to($request->email)->subject('Verifikasi Email');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => 'Link verifikasi telah dikirim ke email Anda.']);
    }

    public function verifyEmail($token)
    {
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->get("$supabaseUrl/rest/v1/verification_tokens", [
            'token' => $token,
        ]);

        if ($response->successful() && $response->json()) {
            $verificationData = $response->json()[0];

            // Update user: email_verified_at
            $update = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            ])->patch("$supabaseUrl/rest/v1/" . env('SUPABASE_TABLE') . "?id=eq." . $verificationData['user_id'], [
                'email_verified_at' => now()->toISOString(),
            ]);

            if ($update->successful()) {
                // Hapus token
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                ])->delete("$supabaseUrl/rest/v1/verification_tokens?id=eq." . $verificationData['id']);

                return redirect()->route('login')->with('success', 'Email berhasil diverifikasi.');
            }
        }

        return back()->withErrors(['error' => 'Link verifikasi tidak valid atau sudah digunakan.']);
    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
    $table       = env('SUPABASE_TABLE');

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'apikey'        => env('SUPABASE_API_KEY'),
        ])->get("$supabaseUrl/rest/v1/$table?email=eq." . $request->email . "&select=*");
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal menghubungi server.'], 500);
    }

    if (!$response->successful() || empty($response->json())) {
        return response()->json(['success' => false, 'message' => 'Email tidak ditemukan.'], 404);
    }

    $user = $response->json()[0];

    // Validasi password
    if (!Hash::check($request->password, $user['password'])) {
        return response()->json(['success' => false, 'message' => 'Password salah.'], 401);
    }

    // Simpan session
    session([
        'user'     => $user,
        'is_admin' => $user['role'] === 'admin',
    ]);

    // Redirect berdasarkan role
    $redirectRoute = $user['role'] === 'admin' ? route('archive') : route('dashboard');

    return response()->json([
        'success'  => true,
        'message'  => 'Login berhasil.',
        'redirect' => $redirectRoute
    ]);
}

    public function showLogin()
{
    return view('auth.login'); // Pastikan file resources/views/auth/login.blade.php ada
}

}
