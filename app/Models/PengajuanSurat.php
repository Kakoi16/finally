<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public const STATUS_PROSES = 'Proses';
    public const STATUS_DISETUJUI = 'Disetujui';
    public const STATUS_DITOLAK = 'Ditolak';

    protected $fillable = [
        'surat_number',
        'name',
        'email',
        'category',
        'status',
        'start_date',
        'remarks',
        'end_date',
        'reason',
        'position',
        'join_date',
        'purpose',
        'department',
        'complaint_category',
        'complaint_description',
        'recommended_name',
        'recommender_name',
        'recommender_position',
        'recommendation_reason',
        'attachment_path',
    ];

    // --- TAMBAHKAN INI jika Anda ingin memastikan created_at dan updated_at di-cast ke Carbon ---
    // (Biasanya sudah otomatis jika menggunakan default timestamps)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'start_date' => 'date', // Mungkin juga relevan untuk tanggal lain
        // 'end_date' => 'date',
        // 'join_date' => 'date',
    ];
    // --- END TAMBAHAN ---

    public function archive()
    {
        return $this->hasOne(Archive::class, 'pengajuan_surat_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}