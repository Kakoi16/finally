@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800 text-white px-4">
    <div class="glass-card w-full max-w-md p-8 rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 shadow-2xl hover:shadow-teal-500/20 transition-shadow duration-300">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="p-3 bg-teal-500/20 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-teal-400 to-blue-500 bg-clip-text text-transparent">Buat Akun Baru</h1>
            <p class="text-gray-300 mt-2 text-sm">Mulai perjalanan event planning Anda bersama kami</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="name" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-800/50 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-transparent placeholder-gray-400 transition duration-200"
                        required
                        placeholder="Nama Anda"
                        value="{{ old('name') }}"
                    >
                </div>
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-800/50 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-transparent placeholder-gray-400 transition duration-200"
                        required
                        placeholder="email@contoh.com"
                        value="{{ old('email') }}"
                    >
                </div>
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-800/50 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-transparent placeholder-gray-400 transition duration-200"
                        required
                        placeholder="••••••••"
                    >
                </div>
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-800/50 text-white rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-transparent placeholder-gray-400 transition duration-200"
                        required
                        placeholder="••••••••"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-medium text-white bg-gradient-to-r from-teal-500 to-blue-500 hover:from-teal-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-300"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Daftar Sekarang
            </button>

            <!-- Login Link -->
            <div class="text-center text-sm text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-teal-400 hover:text-teal-300 transition duration-200 hover:underline">
                    Masuk di sini
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .glass-card {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    @media (max-width: 640px) {
        .glass-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection
