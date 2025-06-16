<?php

// app/Models/VerificationToken.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model {
    public $timestamps = false;

    protected $fillable = ['id', 'user_id', 'token', 'created_at']; 

    public function user() {
    return $this->belongsTo(User::class, 'user_id', 'id');
}
}
