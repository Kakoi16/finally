<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity; // Pastikan model ini ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmployeeActivityController extends Controller
{
    /**
     * Menyimpan data aktivitas baru dari karyawan.
     * Aktivitas baru akan memiliki status default 'pending'.
     */
 
    /**
     * Mengambil 10 log aktivitas terakhir milik karyawan yang terotentikasi.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Mengambil aktivitas dan mengurutkannya dari yang terbaru
            $activities = $user->activities()
                               ->latest() // Sama dengan orderBy('created_at', 'desc')
                               ->paginate(10); // Menggunakan paginasi lebih baik daripada take()

            return response()->json($activities);

        } catch (\Exception $e) {
            Log::error('Fetch Employee Activities Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Gagal memuat aktivitas.'], 500);
        }
    }
}