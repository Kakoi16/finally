
@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<h2>Lupa Password</h2>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button class="btn btn-warning">Kirim Link Reset</button>
</form>
@endsection
