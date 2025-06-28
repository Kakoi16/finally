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
   public function getSuratStats(Request $request)
{
    try {
        $email = $request->query('email');
        $name = $request->query('name');

        if (!$email || !$name) {
            return response()->json([
                'success' => false,
                'message' => 'Email dan nama harus disediakan.',
                'data' => null
            ], 400);
        }

        $stats = DB::table('pengajuan_surats')
            ->select(
                DB::raw("COUNT(CASE WHEN status = 'Proses' THEN 1 END) as diajukan"),
                DB::raw("COUNT(CASE WHEN status = 'Disetujui' THEN 1 END) as disetujui"),
                DB::raw("COUNT(CASE WHEN status = 'Ditolak' THEN 1 END) as ditolak")
            )
            ->where('email', $email)
            ->where('name', $name)
            ->first();

        if (!$stats) {
            $stats = [
                'diajukan' => 0,
                'disetujui' => 0,
                'ditolak' => 0,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Statistik surat berhasil diambil',
            'data' => $stats
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            'data' => null
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
