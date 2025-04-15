@extends('layouts.app')

@section('content')
<div class="glass-card rounded-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Reset Password</h1>
        <p class="opacity-80 mt-2">Buat password baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Email</label>
            <input type="email" name="email" class="form-input w-full px-4 py-3 rounded-lg" 
                   value="{{ $email ?? old('email') }}" required readonly>
            @error('email')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Password Baru</label>
            <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="••••••••">
            @error('password')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="••••••••">
        </div>
        
        <button type="submit" class="w-full bg-white text-purple-700 py-3 rounded-lg font-medium hover:bg-opacity-90 transition duration-300">
            Reset Password
        </button>
    </form>
</div>
@endsection