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

@include('modals.rename-folder')
@include('modals.delete-folder')
@include('modals.rename-item')
@include('modals.delete-item')
@include('modals.bulk-delete')
@include('modals.bulk-rename')

@endsection

@section('scripts')
<script src="{{ asset('js/js') }}"></script>
@endsection

@section('styles')
<link href="{{ asset('css/css') }}" rel="stylesheet">
@endsection