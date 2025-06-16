<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Password; // <-- TAMBAHKAN INI
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,karyawan',
        ]);

        $uuid = Str::uuid()->toString();

        $user = User::create([
            'id' => $uuid,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $token = Str::random(64);

        VerificationToken::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $uuid,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $verifyUrl = url("/verify-email/{$token}");

        // Kirim email HTML pakai Blade view
        Mail::send('emails.verify', [
            'user' => $user,
            'verifyUrl' => $verifyUrl
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verifikasi Email Anda');
        });

<<<<<<< HEAD
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Silakan cek email untuk verifikasi.'
        ]);
=======
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
            ->withHeaders(['Prefer' => 'return=representation'])
            ->post("$supabaseUrl/rest/v1/verification_tokens", $tokenData);


        if (!$saveToken->successful()) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan token verifikasi.'], 500);
        }

        // Kirim email verifikasi
        $verificationUrl = route('verification.verify', ['token' => $token]);

        try {
            Mail::send('emails.verification', ['url' => $verificationUrl, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email)->subject('Verifikasi Email');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => 'Link verifikasi telah dikirim ke email Anda.']);
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    }

    public function verifyEmail($token)
    {
        \Log::info('Menerima token verifikasi:', ['token' => $token]);

<<<<<<< HEAD
        $verify = VerificationToken::where('token', $token)->first();

        if (!$verify) {
            \Log::warning('Token tidak ditemukan:', ['token' => $token]);
            return response()->json(['success' => false, 'message' => 'Token tidak valid atau telah digunakan.']);
=======
        // Ambil token detail
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            'apikey'        => env('SUPABASE_API_KEY'),
        ])->get("$supabaseUrl/rest/v1/verification_tokens?token=eq.$token");

        if ($response->successful() && $response->json()) {
            $verificationData = $response->json()[0];

            // Update user email_verified_at
            $update = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                'apikey'        => env('SUPABASE_API_KEY'),
            ])->patch("$supabaseUrl/rest/v1/" . env('SUPABASE_TABLE') . "?id=eq." . $verificationData['user_id'], [
                'email_verified_at' => now()->toISOString(),
            ]);

            if ($update->successful()) {
                // Ambil detail user untuk cek rolenya
                $userResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                    'apikey'        => env('SUPABASE_API_KEY'),
                ])->get("$supabaseUrl/rest/v1/" . env('SUPABASE_TABLE') . "?id=eq." . $verificationData['user_id']);

                if ($userResponse->successful() && $userResponse->json()) {
                    $user = $userResponse->json()[0];

                    // Hapus token verifikasi
                    Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                        'apikey'        => env('SUPABASE_API_KEY'),
                    ])->delete("$supabaseUrl/rest/v1/verification_tokens?id=eq." . $verificationData['id']);

                    if ($user['role'] === 'karyawan') {
                        // Kirim email ucapan terima kasih
                        try {
                            Mail::raw("Halo {$user['name']}, terima kasih telah memverifikasi email Anda!", function ($message) use ($user) {
                                $message->to($user['email'])->subject('Verifikasi Berhasil');
                            });
                        } catch (\Exception $e) {
                            return back()->withErrors(['error' => 'Email ucapan gagal dikirim: ' . $e->getMessage()]);
                        }

                        return response()->view('auth.thankyou', ['name' => $user['name']]); // Tampilkan halaman khusus ucapan
                    }

                    // Jika admin, redirect ke login
                    return redirect()->route('login')->with('success', 'Email berhasil diverifikasi.');
                }
            }
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
        }

        $user = $verify->user;

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();

            \Log::info('Email berhasil diverifikasi untuk user:', ['email' => $user->email]);
        }

        $verify->delete();

        Auth::login($user);

        return redirect('/')->with('success', 'Email berhasil diverifikasi!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

<<<<<<< HEAD
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah.'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat login.'], 403);
        }

        // Simpan ke session
        Auth::login($user);
=======
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

        // Cek password
        if (!Hash::check($request->password, $user['password'])) {
            return response()->json(['success' => false, 'message' => 'Password salah.'], 401);
        }

        // Cek role admin
        if ($user['role'] !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat login.'], 403);
        }

        // Simpan user ke session
        session([
            'user' => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'], // 'admin'
            ],
        ]);
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'redirect' => route('archive')
        ]);
    }

<<<<<<< HEAD
=======
    public function showLogin()
    {
        return view('auth.login'); // Pastikan file resources/views/auth/login.blade.php ada
    }
    
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    public function loginKaryawan(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
<<<<<<< HEAD
            'device_name' => 'sometimes|string|max:255' // Opsional
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        if (strtolower($user->role) !== 'karyawan') {
            \Log::warning('Upaya login /loginKaryawan oleh non-karyawan: ' . $request->email);
            return response()->json(['message' => 'Akses ditolak. Hanya karyawan yang dapat login.'], 403);
        }

        $deviceName = $request->input('device_name', $request->header('User-Agent', 'KaryawanIonicApp'));
        $token = $user->createToken($deviceName, ['role:karyawan'])->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified_at' => $user->email_verified_at,
            ]
        ], 200);
    }

    public function logoutApi(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout API berhasil.']);
        }
        return response()->json(['message' => 'Tidak ada user terotentikasi.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
    
    
    
     /**
     * Menampilkan form untuk meminta link reset password.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Mengirim link reset password ke email pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
        }

        // Membuat token reset password
        $token = Str::random(60);

        // Menyimpan token ke database (tabel password_reset_tokens)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // URL untuk reset password
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $request->email], false));

        // Kirim email
        Mail::send('emails.password-reset', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Notifikasi Reset Password Anda');
        });

        return redirect()->route('password.request')->with('status', 'Link reset password telah dikirim ke email Anda!');
    }


    /**
     * Menampilkan form untuk mereset password.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    /**
     * Mereset password pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)->first();

        // Cek jika token ada dan valid
        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Token reset password tidak valid atau telah kedaluwarsa.']);
        }
        
        // Cek jika token sudah lebih dari 60 menit
        if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Token reset password telah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        
        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token dari database
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password Anda berhasil direset! Silakan login kembali.');
    }
    
    
    
=======
        ]);
    
        // Ambil user dari Supabase berdasarkan email
        $response = Http::withToken(env('SUPABASE_SERVICE_ROLE_KEY'))
        ->withHeaders([
            'apikey' => env('SUPABASE_SERVICE_ROLE_KEY'),
        ])
        ->get(env('SUPABASE_URL') . '/rest/v1/users', [
            'select' => '*',
            'email' => 'eq.' . $request->email,
        ]);
        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal koneksi ke Supabase.',
                'error' => $response->body(),
            ], 500);
        }
            
    
        $user = $response->json()[0] ?? null;
    
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 401);
        }
    
        // Cek password dan role
        if (!Hash::check($request->password, $user['password'])) {
            return response()->json(['message' => 'Password salah.'], 401);
        }
    
        $role = strtolower(trim($user['role'] ?? ''));

        if ($role !== 'karyawan') {
            return response()->json(['message' => 'Hanya karyawan yang diperbolehkan login.'], 401);
        }
        
    
        // Login berhasil
        return response()->json([
            'message' => 'Login berhasil.',
            'access_token' => base64_encode(Str::random(40)), // Token dummy
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);
        
    }
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
}
