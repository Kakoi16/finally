
@extends('layouts.app')
@section('title', 'Register')

@section('content')
<h2>Register</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button class="btn btn-primary">Register</button>
    <a href="{{ route('login') }}" class="btn btn-link">Sudah punya akun?</a>
</form>
@endsection
