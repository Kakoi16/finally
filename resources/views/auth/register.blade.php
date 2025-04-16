@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="glass-card rounded-2xl p-8 w-full max-w-md text-white">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Buat Akun Baru</h1>
        <p class="opacity-80 mt-2 text-sm">Mulai perjalanan event planning Anda bersama kami</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" class="form-input w-full px-4 py-3 rounded-lg" 
                   required value="{{ old('name') }}" placeholder="Nama Anda">
            @error('name')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium">Alamat Email</label>
            <input type="email" name="email" class="form-input w-full px-4 py-3 rounded-lg" 
                   required value="{{ old('email') }}" placeholder="email@contoh.com">
            @error('email')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium">Password</label>
            <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="••••••••">
            @error('password')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="••••••••">
        </div>
        
        <button type="submit" class="w-full bg-white text-purple-700 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300 mb-4">
            Daftar
        </button>
        
        <div class="text-center text-sm">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-medium hover:underline text-white">Masuk di sini</a>
        </div>
    </form>
</div>
@endsection
