<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat; // Pastikan model ini ada
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Mengambil notifikasi berdasarkan pengajuan surat yang belum diproses.
     */
    public function index(Request $request)
    {
        // Untuk admin, tampilkan semua surat yang perlu diproses.
        // Untuk pengguna biasa, Anda bisa memfilter berdasarkan 'user_id' jika ada.
        $user = $request->user();

        // Asumsi 'admin' bisa melihat semua pengajuan baru.
        // Jika bukan admin, mungkin tampilkan status surat miliknya?
        // Untuk saat ini, kita fokus pada notifikasi untuk Admin.
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => true,
                'data' => [],
                'unread_count' => 0,
            ]);
        }
        
        // Ambil semua pengajuan surat dengan status 'Proses'
        $pengajuanBaru = PengajuanSurat::where('status', 'Proses')
            ->latest()
            ->get();

        // Ubah data pengajuan menjadi format notifikasi
        $notifications = $pengajuanBaru->map(function ($pengajuan) {
            return [
                'id' => $pengajuan->id,
                'title' => 'Pengajuan Surat Baru',
                'message' => "Surat '{$pengajuan->category}' dari {$pengajuan->name} perlu diproses.",
                'read' => false, // Anggap semua notifikasi ini 'belum dibaca'
                'time' => Carbon::parse($pengajuan->created_at)->diffForHumans(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $notifications->count(), // Jumlah notifikasi adalah jumlah pengajuan baru
        ]);
    }

    /**
     * Fungsi ini tidak lagi relevan karena notifikasi bersifat dinamis.
     * Kita bisa mengosongkannya atau mengembalikan respons sukses.
     */
    public function markAllAsRead(Request $request)
    {
        // Dalam konteks ini, "menandai sudah dibaca" berarti admin sudah melihatnya.
        // Tidak ada aksi database yang diperlukan di sini.
        // Kita hanya perlu memberitahu frontend bahwa jumlah notifikasi baru adalah 0.
        return response()->json(['success' => true, 'message' => 'Notifications acknowledged.']);
    }
}
