
@extends('layouts.app')
@section('title', 'Login')

@section('content')
<h2>Login</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-success">Login</button>
    <a href="{{ route('register') }}" class="btn btn-link">Belum punya akun?</a>
    <a href="{{ route('password.request') }}" class="btn btn-link">Lupa Password?</a>
</form>
@endsection
