<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Pastikan ini di-import

class PengajuanSuratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'title'             => $this->category, // Menggunakan kategori sebagai judul
            'suratNumber'       => $this->surat_number,
            'status'            => $this->status ?? 'Proses', // Pastikan status selalu ada
            'category'          => $this->category,
            'remarks'           => $this->remarks,
            'attachment_path'   => $this->attachment_path,
            
            // --- URL FILE UNTUK DIUNDUH ---
            // Menggunakan asset() untuk URL lengkap file yang di-upload
            'file_url'          => $this->attachment_path ? asset('storage/uploads/' . $this->attachment_path) : null,
            
            // --- PROPERTI WAKTU UNTUK SORTING DAN TAMPILAN AKURAT ---
            // `created_at` dan `updated_at` dalam format ISO 8601 adalah kunci untuk sorting di frontend
            'created_at'        => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at'        => $this->updated_at ? $this->updated_at->toIso8601String() : null,

            // Properti waktu yang sudah diformat untuk KEMUDAHAN TAMPILAN di frontend
            // Ini bisa langsung digunakan di HTML tanpa perlu pemrosesan Date di Ionic
            'formatted_date'    => $this->created_at ? $this->created_at->translatedFormat('d F Y') : null, // Contoh: "21 Juni 2025"
            'formatted_time'    => $this->created_at ? $this->created_at->format('H:i') : null, // Contoh: "03:39"
            
            // Opsional: Jika Anda ingin tampilan "X menit yang lalu" untuk updated_at
            'relative_updated_at' => $this->updated_at ? $this->updated_at->diffForHumans() : null,

            // --- KOLOM LAIN YANG MUNGKIN RELEVAN DARI MODEL PengajuanSurat ---
            // Jika ada kolom lain yang Anda butuhkan di frontend, tambahkan di sini
            // 'name'              => $this->name, // Jika nama dibutuhkan secara terpisah dari user terautentikasi
            // 'email'             => $this->email,
            // 'start_date'        => $this->start_date,
            // 'end_date'          => $this->end_date,
            // 'reason'            => $this->reason,
            // 'position'          => $this->position,
            // 'join_date'         => $this->join_date,
            // 'purpose'           => $this->purpose,
            // 'department'        => $this->department,
            // 'complaint_category' => $this->complaint_category,
            // 'complaint_description' => $this->complaint_description,
            // 'recommended_name'  => $this->recommended_name,
            // 'recommender_name'  => $this->recommender_name,
            // 'recommender_position' => $this->recommender_position,
            // 'recommendation_reason' => $this->recommendation_reason,
        ];
    }
}