<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Archive extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'pengajuan_surat_id', 'id', 'name', 'path', 'type', 'size', 'uploaded_by', 'created_at', 'is_deleted', 'deleted_at'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'deleted_at' => 'datetime',
        'is_deleted' => 'boolean', // agar is_deleted otomatis jadi boolean
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'archive_user', 'archive_id', 'user_id')->withTimestamps();
    }
    public function pengajuanSurat()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_surat_id');
    }
}
