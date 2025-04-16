@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white px-4">
    <div class="glass-card w-full max-w-md p-8 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/20 shadow-xl">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Masuk ke Akun Anda</h1>
            <p class="text-gray-300 mt-2">Selamat datang kembali di Harmoni Event</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-white">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required value="{{ old('email') }}" 
                    placeholder="email@contoh.com"
                >
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-white">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full px-4 py-3 bg-gray-800 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required placeholder="••••••••"
                >
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot -->
            <div class="flex items-center justify-between mb-6 text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="form-checkbox text-teal-500 rounded-sm">
                    <span>Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-teal-400 hover:underline">Lupa Password?</a>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 rounded-lg font-semibold transition duration-300"
            >
                Masuk
            </button>
            <a href="{{ route('google.login') }}" class="btn btn-danger w-full">
    <i class="fab fa-google"></i> Login dengan Google
</a>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-300 mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-teal-400 hover:underline font-medium">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
