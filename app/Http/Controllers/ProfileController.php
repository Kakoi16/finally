<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        // Pastikan view 'profile.show' ada atau sesuaikan dengan nama view Anda
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],
    ];

    // Validasi password hanya jika diisi
    if ($request->filled('password')) {
        $rules['password'] = 'string|min:6|confirmed'; // Tidak pakai 'required'
    }

    $request->validate($rules);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
}

 public function getProfileUrl(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['error' => 'Profil tidak ditemukan'], 404);
        }

        // Misalnya URL publik berbasis user_id
        $url = url("/profile/{$user->id}");

        // Jika kamu ingin pakai NIP:
        // $url = url("/profile/{$profile->nip}");

        return response()->json([
            'url' => $url,
        ]);
    }
}