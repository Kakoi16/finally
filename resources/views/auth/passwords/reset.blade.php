@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-50 to-indigo-50">
    <div class="w-full max-w-md mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-lg">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Reset Password Anda</h2>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <!-- Token Reset Password (Hidden) -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <div class="mt-1">
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" 
                           class="focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm bg-gray-100" readonly>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="mt-1">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <div class="mt-1">
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
