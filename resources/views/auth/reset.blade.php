
@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<h2>Reset Password</h2>
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button class="btn btn-primary">Reset</button>
</form>
@endsection
