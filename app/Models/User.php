<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'departemen'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function verificationToken()
    {
        return $this->hasOne(VerificationToken::class);
    }

    public function sharedArchives()
    {
        return $this->belongsToMany(Archive::class, 'archive_user', 'user_id', 'archive_id')->withTimestamps();
    }

    public function isAdmin()
    {
        return strtolower($this->role) === 'admin';
    }

    public function isKaryawan()
    {
        return strtolower($this->role) === 'karyawan';
    }

    /**
     * ✅ Relasi ke profil pengguna
     */
    public function profile()
{
    return $this->hasOne(Profile::class, 'user_id', 'id');
}

public function pengajuanSurats()
{
    return $this->hasMany(PengajuanSurat::class, 'user_id', 'id');
}

}
