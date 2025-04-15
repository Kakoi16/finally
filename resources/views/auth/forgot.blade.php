@extends('layouts.app')

@section('content')
<div class="glass-card rounded-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">Lupa Password</h1>
        <p class="opacity-80 mt-2">Masukkan email Anda untuk menerima link reset password</p>
    </div>

    @if (session('status'))
        <div class="bg-green-500 bg-opacity-20 text-green-200 p-3 rounded-lg mb-6 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="mb-6">
            <label class="block mb-2 font-medium">Alamat Email</label>
            <input type="email" name="email" class="form-input w-full px-4 py-3 rounded-lg" 
                   required placeholder="email@contoh.com">
            @error('email')
                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-medium hover:bg-opacity-90 transition duration-300 mb-4">
            Kirim Link Reset
        </button>
        
        <div class="text-center text-sm">
            <a href="{{ route('login') }}" class="font-medium hover:underline">Kembali ke halaman login</a>
        </div>
    </form>
</div>
@endsection