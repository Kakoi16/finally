<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerKaryawan(Request $request)
    {
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new user and generate a verification token
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => null, // Set email as unverified initially
        ]);

        // Generate a unique token for verification
        $token = Str::random(60);

        // Store the token in the database (or temporarily in session if you prefer)
        $user->verification_token = $token;
        $user->save();

        // Send the verification link to the user's email
        $verificationUrl = route('verification.verify', ['token' => $token]);
        Mail::raw("Click this link to verify your email: $verificationUrl", function ($message) use ($request) {
            $message->to($request->email)->subject('Email Verification');
        });

        // Redirect to a page telling the user to check their email
        return redirect()->route('register.karyawan')->with('success', 'Pendaftaran berhasil! Cek email untuk verifikasi.');
    }

    // Method to handle email verification
    public function verifyEmail($token)
    {
        // Find the user by the verification token
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect('/')->with('error', 'Token verifikasi tidak valid.');
        }

        // Mark the user's email as verified
        $user->email_verified_at = now();
        $user->verification_token = null; // Remove the token
        $user->save();

        // Redirect to login or dashboard
        return redirect('/login')->with('success', 'Email berhasil diverifikasi!');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
