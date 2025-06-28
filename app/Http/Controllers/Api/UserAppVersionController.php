<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserVersion;
use Illuminate\Support\Facades\DB;

class UserAppVersionController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'app_version' => 'required|string',
        ]);

        // Simpan atau perbarui versi user
        $userVersion = UserVersion::updateOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'app_version' => $request->app_version]
        );

        // Ambil versi terbaru dari database
        $latest = DB::table('app_updates')->orderBy('created_at', 'desc')->first();
        $latestVersion = $latest?->version ?? '1.0.0'; // fallback versi default

        $isLatest = version_compare($request->app_version, $latestVersion, '>=');

        return response()->json([
            'success' => true,
            'data' => [
                'user_version' => $userVersion,
                'latest_version' => $latestVersion,
                'is_latest' => $isLatest
            ],
            'message' => $isLatest ? 'Aplikasi sudah versi terbaru.' : 'Aplikasi perlu diperbarui.'
        ]);
    }
}
