<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\DashboardController;

class AuthController extends Controller
{
    private $supabase_url;
    private $supabase_key;
    private $table;

    public function __construct()
    {
        $this->supabase_url = env('SUPABASE_URL');
        $this->supabase_key = env('SUPABASE_API_KEY');
        $this->table = env('SUPABASE_TABLE', 'users');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Check if email exists
        $check = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?email=eq.{$request->email}");

        if (count($check->json()) > 0) {
            return back()->withErrors(['email' => 'Email already registered']);
        }

        $token = Str::random(64);

        Http::withHeaders([
            'apikey' => $this->supabase_key,
            'Authorization' => "Bearer {$this->supabase_key}",
            'Content-Type' => 'application/json',
            'Prefer' => 'return=minimal',
        ])->post("{$this->supabase_url}/rest/v1/{$this->table}", [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified' => false,
            'verify_token' => $token
        ]);

        // Kirim email verifikasi
        Mail::raw("Klik untuk verifikasi akun: " . route('verification.verify', ['id' => $token]), function($msg) use ($request) {
            $msg->to($request->email)->subject('Verifikasi Akun');
        });

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Cek email untuk verifikasi.');
    }

    public function verifyEmail($id) {
        $user = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?verify_token=eq.{$id}");
    
        $data = $user->json();
    
        if (empty($data) || !isset($data[0])) {
            abort(404);
        }
    
        $uid = $data[0]['id'];
    
        Http::withHeaders([
            'apikey' => $this->supabase_key,
            'Authorization' => "Bearer {$this->supabase_key}",
            'Content-Type' => 'application/json',
        ])->patch("{$this->supabase_url}/rest/v1/{$this->table}?id=eq.{$uid}", [
            'email_verified' => true,
            'verify_token' => null
        ]);
    
        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi.');
    }
    

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?email=eq.{$request->email}");

        if (count($user->json()) === 0) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $data = $user->json()[0];

        if (!Hash::check($request->password, $data['password'])) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        if (!$data['email_verified']) {
            return back()->withErrors(['email' => 'Email belum diverifikasi']);
        }

        session(['user' => $data]);

        return redirect('/dashboard')->with('success', 'Login berhasil');
    }

    public function logout() {
        session()->forget('user');
        return redirect()->route('login');
    }

    public function showForgot() {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $user = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?email=eq.{$request->email}");

        if (count($user->json()) === 0) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $token = Str::random(64);

        $uid = $user->json()[0]['id'];

        Http::withHeaders([
            'apikey' => $this->supabase_key,
            'Authorization' => "Bearer {$this->supabase_key}",
            'Content-Type' => 'application/json',
        ])->patch("{$this->supabase_url}/rest/v1/{$this->table}?id=eq.{$uid}", [
            'reset_token' => $token
        ]);

        Mail::raw("Klik untuk reset password: " . route('password.reset', ['token' => $token]), function($msg) use ($request) {
            $msg->to($request->email)->subject('Reset Password');
        });

        return back()->with('success', 'Link reset telah dikirim ke email.');
    }

    public function showResetForm($token) {
        return view('auth.reset', compact('token'));
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $user = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?reset_token=eq.{$request->token}");

        if (count($user->json()) === 0) {
            return back()->withErrors(['token' => 'Token tidak valid']);
        }

        $uid = $user->json()[0]['id'];

        Http::withHeaders([
            'apikey' => $this->supabase_key,
            'Authorization' => "Bearer {$this->supabase_key}",
            'Content-Type' => 'application/json',
        ])->patch("{$this->supabase_url}/rest/v1/{$this->table}?id=eq.{$uid}", [
            'password' => bcrypt($request->password),
            'reset_token' => null
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset');
    }
    public function testSupabaseConnection() {
        $response = Http::withHeaders([
            'apikey' => $this->supabase_key,
        ])->get("{$this->supabase_url}/rest/v1/{$this->table}?limit=1");
    
        if ($response->successful()) {
            dd("✅ Terhubung ke Supabase", $response->json());
        } else {
            dd("❌ Gagal terhubung ke Supabase", $response->status(), $response->body());
        }
    }
    
}
