<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  // app/Http/Middleware/VerifyCsrfToken.php
protected $except = [
    '/zoho-callback',
     '/zoho-call-back',                 // Jika Anda menggunakan path literal
        '/zoho-call-back/*',               // Jika ada parameter setelahnya
        '/zoho/template/save-callback/*'
    
];



}
