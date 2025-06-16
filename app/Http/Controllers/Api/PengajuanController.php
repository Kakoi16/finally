<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat; // Pastikan model di-import dengan benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PengajuanSuratResource;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    public function riwayatSuratt()
    {
        try {
            $pengajuanSurats = PengajuanSurat::latest()->get();
            // Menggunakan API Resource untuk memformat output JSON
            return PengajuanSuratResource::collection($pengajuanSurats);

        } catch (\Exception $e) {
            // Jika terjadi error tak terduga, catat di log dan beri tahu pengguna.
            Log::error('Gagal mengambil riwayat surat: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }


    /**
     * Mengambil beberapa aktivitas surat terbaru.
     * Endpoint ini akan digunakan oleh halaman Aktivitas di Ionic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentActivities()
    {
        $latestSurat = PengajuanSurat::latest('updated_at')
    ->limit(5)
    ->get()
    ->map(function ($item) {
       $item->file_url = $item->status === 'Disetujui' && $item->attachment_path
    ? 'https://simpap.my.id/storage/app/public/uploads/' . $item->attachment_path
    : null;

$item->download_name = $item->status === 'Disetujui'
    ? str_replace(['/', ' '], '', $item->surat_number) . '.pdf'
    : null;

        return $item;
    });

return response()->json($latestSurat);

    }

    public function riwayatsurat()
    {
        // Mengambil semua data dari tabel pengajuan_surats
        // Anda bisa menambahkan filter berdasarkan user yang login jika perlu
        // contoh: PengajuanSurat::where('user_id', auth()->id())->latest()->get();
        $pengajuanSurats = PengajuanSurat::latest()->get();

        // Mengembalikan data sebagai koleksi resource
        // Ini akan otomatis memformat data sesuai PengajuanSuratResource
        // dan mengemasnya dalam properti 'data'
        return PengajuanSuratResource::collection($pengajuanSurats);
    }   

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
            // Ganti 'Surat' menjadi 'PengajuanSurat'
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
            return response()->json(['message' => 'Gagal menghapus surat. Silakan coba lagi nanti.', 'error' => $e->getMessage()], 500); // Sertakan pesan error
        }
    }
    
  
    // atau untuk menyimpan pengajuan baru dari Ionic.
}