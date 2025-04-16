@extends('layouts.app') {{-- Pastikan layout ada. Ganti sesuai struktur project kamu --}}

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Selamat datang, {{ $user['name'] }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Email:</strong> {{ $user['email'] }}</p>
        <p><strong>Verifikasi:</strong> {{ $user['email_verified'] ? 'Sudah' : 'Belum' }}</p>
    </div>
</div>
@endsection
