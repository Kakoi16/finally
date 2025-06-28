<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat; // Pastikan model di-import dengan benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PengajuanSuratResource; // Mungkin tidak digunakan secara langsung di sini, tapi bagus kalau ada
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    /**
     * Mengambil riwayat surat berdasarkan email dan nama pengguna.
     * Digunakan oleh halaman Riwayat Surat di Ionic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function riwayatSuratt(Request $request)
    {
        try {
            // Menggunakan token dari autentikasi API jika Anda sudah mengimplementasikannya
            // Jika belum, lanjutkan menggunakan email dan nama dari query
            // $user = $request->user(); // Jika menggunakan Sanctum/Passport
            // $email = $user->email;
            // $name = $user->name;

            $email = $request->query('email');
            $name = $request->query('name');

            if (!$email || !$name) {
                return response()->json(['message' => 'Email dan nama harus disediakan.'], 400);
            }

            // Ambil riwayat surat berdasarkan email dan nama, urutkan berdasarkan created_at terbaru
            $pengajuanSurats = PengajuanSurat::where('email', $email)
                ->where('name', $name)
                ->orderByDesc('created_at')
                ->get();

            // Tambahkan file_url dan format waktu
            $formattedSurats = $pengajuanSurats->map(function ($item) {
                $item->file_url = $item->status === 'Disetujui' && $item->attachment_path
                    ? asset('storage/app/public/uploads/' . $item->attachment_path) // Pastikan path storage benar
                    : null;
                
                // --- FOKUS PERBAIKAN WAKTU UNTUK riwayatSuratt ---
                // Mengambil waktu dari created_at
                $item->formatted_time = $item->created_at ? $item->created_at->format('H:i') : null; // Format Jam:Menit (misal 14:30)
                $item->formatted_date = $item->created_at ? $item->created_at->format('Y-m-d') : null; // Format Tahun-Bulan-Tanggal (misal 2024-06-21)
                // --- END FOKUS ---

                return $item;
            });

            return response()->json(['data' => $formattedSurats]);

        } catch (\Exception $e) {
            Log::error('Gagal mengambil riwayat surat: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    /**
     * Mengambil beberapa aktivitas surat terbaru.
     * Endpoint ini akan digunakan oleh halaman Aktivitas di Ionic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentActivities(Request $request)
    {
        // $user = $request->user(); // Jika menggunakan Sanctum/Passport
        // $email = $user->email;
        // $name = $user->name;

        $email = $request->query('email');
        $name = $request->query('name');

        if (!$email || !$name) {
            return response()->json(['message' => 'Email dan nama harus disediakan.'], 400);
        }

        $latestSurat = PengajuanSurat::where('email', $email)
            ->where('name', $name)
            ->latest('updated_at') // Urutkan berdasarkan updated_at terbaru
            ->limit(5) // Ambil 5 data terbaru
            ->get()
            ->map(function ($item) {
                $item->file_url = $item->status === 'Disetujui' && $item->attachment_path
                    ? asset('storage/app/public/uploads/' . $item->attachment_path) // Pastikan path storage benar
                    : null;

                $item->download_name = $item->status === 'Disetujui'
                    ? str_replace(['/', ' '], '', $item->surat_number) . '.pdf'
                    : null;

                // --- FOKUS PERBAIKAN WAKTU UNTUK getRecentActivities ---
                // Mengambil waktu dari updated_at (karena ini aktivitas terbaru)
                $item->formatted_updated_at_time = $item->updated_at ? $item->updated_at->format('H:i') : null; // Format Jam:Menit
                $item->formatted_updated_at_date = $item->updated_at ? $item->updated_at->format('Y-m-d') : null; // Format Tahun-Bulan-Tanggal
                // Anda juga bisa menambahkan `diffForHumans()` untuk tampilan "X minutes ago"
                $item->relative_updated_at = $item->updated_at ? $item->updated_at->diffForHumans() : null;
                // --- END FOKUS ---

                return $item;
            });

        return response()->json($latestSurat);
    }

    /**
     * Menghapus surat berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Validasi ID
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'ID surat tidak valid.', 'errors' => $validator->errors()], 400);
        }

        try {
            $surat = PengajuanSurat::find($id);

            if (!$surat) {
                return response()->json(['message' => 'Surat tidak ditemukan.'], 404);
            }

            $surat->delete();

            return response()->json(['message' => 'Surat berhasil dihapus.']);

        } catch (\Exception $e) {
            Log::error('Gagal menghapus surat: ' . $e->getMessage(), [
                'surat_id' => $id,
                'exception' => $e, // Tambahkan detail exception
            ]);
            return response()->json(['message' => 'Gagal menghapus surat. Silakan coba lagi nanti.', 'error' => $e->getMessage()], 500);
        }
    }
}