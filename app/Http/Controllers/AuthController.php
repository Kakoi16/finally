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
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new user (no email_verified_at yet)
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => null, // Email is unverified initially
        ];

        // Insert user into Supabase
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->post(env('SUPABASE_URL') . '/rest/v1/' . env('SUPABASE_TABLE'), $userData);

        if ($response->successful()) {
            // Generate verification token
            $token = Str::random(60);

            // Store token in Supabase (or in a separate table, if needed)
            $verificationData = [
                'user_id' => $response->json()['id'], // Assuming the Supabase API returns the user's ID
                'token' => $token,
                'created_at' => now(),
            ];

            // Store verification data in Supabase
            $verificationResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            ])->post(env('SUPABASE_URL') . '/rest/v1/verification_tokens', $verificationData);

            if ($verificationResponse->successful()) {
                // Send email verification link
                $verificationUrl = route('verification.verify', ['token' => $token]);
                Mail::raw("Click this link to verify your email: $verificationUrl", function ($message) use ($request) {
                    $message->to($request->email)->subject('Email Verification');
                });

                return redirect()->route('login')->with('success', 'A verification link has been sent to your email.');
            } else {
                return back()->withErrors(['error' => 'Unable to generate verification token.']);
            }
        }

        return back()->withErrors(['error' => 'User registration failed.']);
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
