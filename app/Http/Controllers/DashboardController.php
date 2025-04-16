<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = session('user'); // Ambil data user dari session
        return view('dashboard.index', compact('user'));
    }
}

