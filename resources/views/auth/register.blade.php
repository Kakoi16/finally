@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white px-4">
    <div class="w-full max-w-sm p-6 rounded-xl bg-gray-800 border border-gray-700 shadow-md">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold text-teal-400">Buat Akun Baru</h1>
            <p class="text-gray-400 text-sm">Gabung untuk mulai merencanakan event Anda</p>
        </div>

        <form method="POST" action="{{ route('register.karyawan') }}" class="space-y-4">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block mb-1 text-sm text-gray-300">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="name" 
                    class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required
                    placeholder="Nama Anda"
                    value="{{ old('name') }}"
                >
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 text-sm text-gray-300">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required
                    placeholder="email@contoh.com"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-1 text-sm text-gray-300">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block mb-1 text-sm text-gray-300">Konfirmasi Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-teal-500 placeholder-gray-400"
                    required
                    placeholder="••••••••"
                >
            </div>

            <!-- Tombol Daftar -->
            <button 
                type="submit" 
                class="w-full py-2 rounded-md bg-teal-500 hover:bg-teal-600 text-white font-medium transition duration-200"
            >
                Daftar
            </button>

            <!-- Link Login -->
            <p class="text-center text-sm text-gray-400 mt-4">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-teal-400 hover:underline">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection
