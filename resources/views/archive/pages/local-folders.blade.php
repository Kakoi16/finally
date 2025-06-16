@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Folder Lokal</h2>

    @if(count($folders))
        <ul>
            @foreach ($folders as $folder)
                <li>{{ $folder }}</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada folder lokal ditemukan.</p>
    @endif
</div>
@endsection
