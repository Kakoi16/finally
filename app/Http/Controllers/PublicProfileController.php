<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    public function show($nip)
    {
        // Ambil user berdasarkan nip
        $user = User::whereHas('profile', function ($query) use ($nip) {
            $query->where('nip', $nip);
        })->with('profile')->first();

        if (!$user) {
            abort(404, 'Profil tidak ditemukan.');
        }

        return view('profile.public', [
            'user' => $user
        ]);
    }
}
