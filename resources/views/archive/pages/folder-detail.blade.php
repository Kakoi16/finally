@extends('layouts.app') {{-- pastikan kamu punya layouts.app, atau sesuaikan --}}

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold">Folder: {{ $folderName }}</h1>
        <p>Ini adalah halaman untuk folder <strong>{{ $folderName }}</strong>.</p>
    </div>
@endsection
