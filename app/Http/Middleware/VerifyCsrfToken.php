<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
<<<<<<< HEAD
  // app/Http/Middleware/VerifyCsrfToken.php
protected $except = [
    '/zoho-callback',
     '/zoho-call-back',                 // Jika Anda menggunakan path literal
        '/zoho-call-back/*',               // Jika ada parameter setelahnya
        '/zoho/template/save-callback/*'
    
];



=======
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
   protected $except = [
    'template/zoho/save'
];


>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
}
