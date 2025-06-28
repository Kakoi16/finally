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

 
    public function registerKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,karyawan',
            'departemen' => 'required|string|max:255', // Tambahkan validasi untuk departemen
        ]);

        $uuid = Str::uuid()->toString();

        $user = User::create([
            'id' => $uuid,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'departemen' => $request->departemen, // Simpan data departemen
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

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Silakan cek email untuk verifikasi.'
        ]);
    }
    public function verifyEmail($token)
    {
        \Log::info('Menerima token verifikasi:', ['token' => $token]);

        $verify = VerificationToken::where('token', $token)->first();

        if (!$verify) {
            \Log::warning('Token tidak ditemukan:', ['token' => $token]);
            return response()->json(['success' => false, 'message' => 'Token tidak valid atau telah digunakan.']);
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

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah.'], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat login.'], 403);
        }

        // Simpan ke session
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'redirect' => route('archive')
        ]);
    }

    public function loginKaryawan(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
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
    
    
    
}
