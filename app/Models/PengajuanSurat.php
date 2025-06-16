<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // Definisikan konstanta untuk status
    public const STATUS_PROSES = 'Proses';
    public const STATUS_DISETUJUI = 'Disetujui';
    public const STATUS_DITOLAK = 'Ditolak';

    protected $fillable = [
        'surat_number',
        'name',
        'email',
        'category',
        'status', // <-- TAMBAHKAN INI
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

    // Cast 'status' ke string jika perlu, meskipun biasanya tidak masalah
    // protected $casts = [
    //     'status' => 'string',
    // ];

    public function archive()
    {
        return $this->hasOne(Archive::class, 'pengajuan_surat_id', 'id');
    }
}