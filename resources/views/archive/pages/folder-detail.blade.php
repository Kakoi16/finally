@extends('layouts.app')

@section('custom-sidebar')
@include('components.action-cards')

@endsection

@section('content')
<div class="p-8 bg-white rounded-xl shadow-sm border border-gray-100">
    @include('components.folder-header')
    @include('components.breadcrumbs')

    @if(count($files) > 0)
        @include('components.files-table')
    @else
        @include('components.empty-state')
    @endif
</div>

@include('archive.modals.rename-folder')
@include('archive.modals.delete-folder')
@include('archive.modals.rename-item')
@include('archive.modals.delete-item')
@include('archive.modals.bulk-delete')
@include('archive.modals.bulk-rename')

@endsection

@section('scripts')
    <script src="{{ asset('asset/js/archive.js') }}"></script>
@endsection

@section('styles')
    <link href="{{ asset('asset/css/archive.css') }}" rel="stylesheet">
@endsection
