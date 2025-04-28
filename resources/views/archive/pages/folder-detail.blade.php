@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Folder: {{ $folderName }}</h1>

    <div class="mb-3">
        <form action="{{ route('folders.createSubfolder', ['parentFolder' => $folderPath]) }}" method="POST">
            @csrf
            <input type="text" name="folder_name" placeholder="Nama subfolder" required>
            <button type="submit" class="btn btn-primary">Buat Subfolder</button>
        </form>
    </div>

    <div class="row">
        @forelse ($files as $file)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $file['name'] }}</h5>
                        @if($file['type'] === 'folder')
                            <a href="{{ url('folders/' . $folderPath . '/' . $file['name']) }}" class="btn btn-sm btn-secondary">Buka Folder</a>
                        @else
                            <a href="#" class="btn btn-sm btn-success">Lihat File</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada file atau folder.</p>
        @endforelse
    </div>
</div>
@endsection
