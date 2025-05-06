@extends('layouts.app')

@section('content')
@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-transition 
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 max-w-lg mx-auto shadow"
        role="alert"
    >
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span 
            class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
            @click="show = false"
        >
            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 7.066 5.652a1 1 0 1 0-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 1 0 1.414 1.414L10 11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z"/>
            </svg>
        </span>
    </div>
@endif

    <!-- Page Title & Action -->
    <div class="flex justify-between items-center mb-6">
        <h2 id="page-title" class="text-lg font-semibold">Dashboard</h2>
        <div class="flex space-x-2">
            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-1"></i> Upload
            </button>
            <button class="border border-gray-300 px-3 py-1 rounded-md text-sm hover:bg-gray-100 flex items-center">
                <i class="fas fa-folder mr-1"></i> Folder Baru
            </button>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div id="breadcrumb" class="flex items-center text-sm text-gray-600 mb-4">
        <a href="#" class="hover:text-blue-600">Archive</a>
        <span class="mx-1">/</span>
        <a href="#" class="hover:text-blue-600">Dashboard</a>
    </div>

    <!-- Halaman Dashboard -->
    <div id="dashboard-page" class="page-content">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <i class="fas fa-home text-blue-500 text-4xl mb-3"></i>
            <h3 class="text-xl font-medium text-gray-800 mb-2">Selamat Datang di Sistem Archive</h3>
            <p class="text-gray-600">Pilih menu di sidebar untuk melihat konten</p>
        </div>
    </div>

    <!-- Halaman lainnya -->
    @include('archive.pages.all-files')
    @include('archive.pages.shared')
    @include('archive.pages.recent')
    @include('archive.pages.favorites')
    @include('archive.pages.trash')
    @include('archive.pages.register')

@endsection
