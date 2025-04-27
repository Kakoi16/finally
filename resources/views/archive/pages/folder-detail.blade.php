@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Folder: {{ $folderName }}</h1>
        <p>Berikut adalah isi folder <strong>{{ $folderName }}</strong>.</p>

        <!-- Daftar file dalam folder bisa ditampilkan di sini -->
        <div class="mt-4">
            <!-- Misalnya, menampilkan file terkait folder ini -->
            @foreach($files as $file)
                <div>{{ $file->name }}</div>
            @endforeach
        </div>
    </div>
@endsection
