@extends('layouts.subfolder')

@section('content')
    <div class="container">
        <h2 class="text-xl font-semibold mb-4">Edit Template: {{ $fileName }}</h2>

        <!-- Form atau viewer untuk edit file Word/Excel (next step) -->
        <p>Integrasi editor Word/Excel bisa ditambahkan di sini, atau diarahkan ke layanan seperti OnlyOffice, Office365, atau LibreOffice Online.</p>
    </div>
@endsection
