<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan untuk mengimpor DB Facade
use App\Models\PengajuanSurat; // Atau gunakan model jika Anda punya
use App\Models\InformasiAdmin; 

class DashboardController extends Controller
{
    /**
     * Mengambil statistik jumlah pengajuan surat.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuratStats()
    {
        try {
            // Menggunakan Query Builder untuk efisiensi
            $stats = DB::table('pengajuan_surats')
                ->select(
                    // Menghitung jumlah surat dengan status 'Proses'
                    DB::raw("COUNT(CASE WHEN status = 'Proses' THEN 1 END) as diajukan"),
                    // Menghitung jumlah surat dengan status 'Disetujui'
                    DB::raw("COUNT(CASE WHEN status = 'Disetujui' THEN 1 END) as disetujui"),
                    // Menghitung jumlah surat dengan status 'Ditolak'
                    DB::raw("COUNT(CASE WHEN status = 'Ditolak' THEN 1 END) as ditolak")
                )
                ->first(); // Mengambil satu baris hasil

            // Jika tidak ada data sama sekali, inisialisasi dengan 0
            if (!$stats) {
                $stats = [
                    'diajukan' => 0,
                    'disetujui' => 0,
                    'ditolak' => 0,
                ];
            }

            // Mengirim response dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Statistik surat berhasil diambil',
                'data' => $stats
            ], 200);

        } catch (\Exception $e) {
            // Menangani jika terjadi error
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
                'data'    => null
            ], 500);
        }
    }
   public function getAdminInfo()
    {
        try {
            // Mengambil semua data, diurutkan dari yang terbaru
            $informasi = InformasiAdmin::latest()->get(['id', 'judul', 'caption', 'created_at', 'updated_at']);

            return response()->json([
                'success' => true,
                'message' => 'Informasi admin berhasil diambil',
                'data' => $informasi
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil informasi admin: ' . $e->getMessage(),
            ], 500);
        }
    }
}
