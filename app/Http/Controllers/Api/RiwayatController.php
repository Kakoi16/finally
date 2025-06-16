<?php

namespace App\Http\Controllers; // Atau App\Http\Controllers\Api jika Anda menaruhnya di sana

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Http\Resources\PengajuanSuratResource;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar semua riwayat surat.
     * Ini adalah method 'index' yang dicari oleh router.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Ambil semua data, urutkan dari yang terbaru
        $pengajuanSurats = PengajuanSurat::latest()->get();

        // Kembalikan data menggunakan API Resource untuk memformat JSON
        return PengajuanSuratResource::collection($pengajuanSurats);
    }

    /**
     * Menghapus surat tertentu dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $surat = PengajuanSurat::find($id);

        if (!$surat) {
            return response()->json(['message' => 'Surat tidak ditemukan'], 404);
        }

        $surat->delete();

        return response()->json(['message' => 'Riwayat surat berhasil dihapus']);
    }

    /**
     * Menghapus semua riwayat surat.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAll()
    {
        // Hati-hati: Perintah ini akan menghapus semua data di tabel pengajuan_surats.
        // Jika Anda punya sistem multi-user, tambahkan filter user_id.
        PengajuanSurat::truncate();

        return response()->json(['message' => 'Semua riwayat berhasil dihapus']);
    }
}