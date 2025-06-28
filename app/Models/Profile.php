<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage; // <-- PASTIKAN INI ADA

class Profile extends Model
{
    use HasFactory;
    
    
protected $fillable = [
    'user_id',
    'phone_number',
    'departemen',
    'address',
    'tanggal_lahir',
    'bio',
    'profile_picture_path', 
];


    /**
     * Menambahkan accessor ke dalam representasi JSON/array model.
     * Ini PENTING agar 'profile_picture_url' selalu ada di response API.
     */
    protected $appends = ['profile_picture_url'];

    // ... (relasi dan $casts Anda biarkan seperti semula)

    /**
     * Accessor untuk mendapatkan URL lengkap foto profil.
     * Inilah yang akan memperbaiki masalah Anda.
     *
     * @return string|null
     */
    public function getProfilePictureUrlAttribute(): ?string
    {
        // Periksa apakah ada path gambar yang tersimpan di database
        if ($this->profile_picture_path) {
            // Jika ada, buat URL publik yang bisa diakses
            return Storage::url($this->profile_picture_path);
        }

        // Jika tidak ada gambar, kembalikan null
        return null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}