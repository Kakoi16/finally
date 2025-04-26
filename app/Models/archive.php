<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'name', 'path', 'type', 'size', 'uploaded_by',
    ];
}
