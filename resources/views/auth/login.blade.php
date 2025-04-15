@extends('layouts.app')

@section('content')
<div class="glass-card rounded-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Masuk ke Akun Anda</h1>
        <p class="opacity-80 mt-2">Selamat datang kembali di Harmoni Event</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Alamat Email</label>
            <input type="email" name="email" class="form-input w-full px-4 py-3 rounded-lg" 
                   required value="{{ old('email') }}" placeholder="email@contoh.com">
            @error('email')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Password</label>
            <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="••••••••">
            @error('password')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-sm hover:underline">Lupa Password?</a>
        </div>
        
        <button type="submit" class="w-full bg-white text-purple-700 py-3 rounded-lg font-medium hover:bg-opacity-90 transition duration-300 mb-4">
            Masuk
        </button>
        
        <div class="text-center text-sm">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-medium hover:underline">Daftar sekarang</a>
        </div>
    </form>
</div>
@endsection