<?php

// app/Models/AppUpdate.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUpdate extends Model
{
    protected $table = 'app_updates';

    protected $fillable = [
        'version',
        'file_path',
    ];

    public $timestamps = true;
}
