@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-50 to-indigo-50">
    <div class="w-full max-w-md mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-lg">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Lupa Password?</h2>
            <p class="text-sm text-gray-600 mb-6">Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda.</p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <div class="mt-1">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                           class="focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kirim Link Reset Password
                </button>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-sm text-blue-600 hover:text-blue-500">
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
