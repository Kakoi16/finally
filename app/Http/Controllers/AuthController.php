<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan data sementara dalam session
        session([
            'otp_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'otp' => $otp,
            ]
        ]);

        // Kirim OTP melalui email
        Mail::raw("Kode OTP kamu adalah: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Kode OTP Pendaftaran Karyawan');
        });

        // Redirect ke halaman OTP
        return redirect()->route('verify.otp.form')->with('success', 'OTP dikirim ke email.');
    }

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        // Validasi OTP
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Ambil data OTP dari session
        $otpData = session('otp_data');

        // Verifikasi OTP
        if ($otpData && $otpData['otp'] == $request->otp) {
            // Simpan pengguna ke database
            $user = \App\Models\User::create([
                'name' => $otpData['name'],
                'email' => $otpData['email'],
                'password' => $otpData['password'],
            ]);

            // Hapus data OTP dari session
            session()->forget('otp_data');

            // Redirect ke dashboard
            return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
        }

        return back()->withErrors(['otp' => 'OTP yang Anda masukkan tidak valid.']);
    }

    // Metode untuk verifikasi email jika diperlukan
    public function verifyEmail($id)
    {
        // Verifikasi email di sini
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
