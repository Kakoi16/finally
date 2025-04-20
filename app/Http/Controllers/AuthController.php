<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function registerKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $otp = rand(100000, 999999);

        session([
            'otp_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'otp' => $otp,
            ]
        ]);

        // Kirim OTP via email
        Mail::raw("Kode OTP kamu adalah: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Kode OTP Pendaftaran Karyawan');
        });

        return redirect()->route('verify.otp.form')->with('success', 'OTP dikirim ke email.');
    }
}
