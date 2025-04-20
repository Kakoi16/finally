@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800 text-white px-4">
    <div class="glass-card w-full max-w-md p-8 rounded-2xl bg-white/5 backdrop-blur-lg border border-white/10 shadow-2xl">
        <h1 class="text-3xl font-bold text-teal-400">Verifikasi OTP</h1>
        <form method="POST" action="{{ route('verify.otp.submit') }}" class="space-y-6">
            @csrf
            <div>
                <label for="otp" class="block mb-2 text-sm font-medium text-gray-300">Masukkan Kode OTP</label>
                <input type="text" name="otp" id="otp" class="w-full py-3 px-4 bg-gray-800 text-white rounded-lg border border-gray-700" required>
                @error('otp')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full py-3 px-4 bg-teal-500 text-white rounded-lg">Verifikasi OTP</button>
        </form>
    </div>
</div>
@endsection
