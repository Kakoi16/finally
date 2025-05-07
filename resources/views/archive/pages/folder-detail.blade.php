@extends('layouts.subfolder')

@section('custom-sidebar')
    @include('components.action-cards', ['currentFolder' => $folderPath])
@endsection

@section('styles')
<link href="{{ asset('css/archive.css') }}" rel="stylesheet">
<style>
    .breadcrumb {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        list-style: none;
        background-color: transparent;
        border-radius: 0.375rem;
    }

    .breadcrumb a {
        color: #4b5563;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: #1f2937;
    }

    .breadcrumb li:not(:first-child)::before {
        content: "/";
        padding: 0 0.5rem;
        color: #9ca3af;
    }

    .hidden {
        display: none;
    }

    /* Modal animations */
    [class*="-modal"] {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
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
<script src="{{ asset('js/archive.js') }}"></script>
@endsection