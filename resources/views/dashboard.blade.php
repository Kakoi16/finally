@extends('layouts.app')

@section('content')
    <div id="breadcrumb" class="flex items-center text-sm text-gray-600 mb-4">
        <a href="#" class="hover:text-blue-600">Archive</a>
        <span class="mx-1">/</span>
        <a href="#" class="hover:text-blue-600">Dashboard</a>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
        <i class="fas fa-home text-blue-500 text-4xl mb-3"></i>
        <h3 class="text-xl font-medium text-gray-800 mb-2">Selamat Datang di Sistem Archive</h3>
        <p class="text-gray-600">Pilih menu di sidebar untuk melihat konten</p>
    </div>
@endsection
