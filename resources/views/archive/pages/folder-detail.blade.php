@extends('layouts.app')

@section('custom-sidebar')
<!-- Enhanced Sidebar -->
<aside class="w-72 bg-white p-6 rounded-xl shadow-sm border border-gray-100 mr-6">
    <div class="flex items-center mb-8">
        <a href="/archive" class="flex items-center group">
            <div class="bg-yellow-50 p-2 rounded-lg group-hover:bg-yellow-100 transition-colors border border-yellow-100">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <span class="ml-3 font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Folder Actions</span>
        </a>
    </div>

    <div class="space-y-5">
        <!-- Create Subfolder Card -->
        <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Subfolder
            </h3>
            <form method="POST" action="{{ route('folders.subfolder.create', ['path' => $folderPath]) }}" class="space-y-3">
                @csrf
                <div>
                    <input type="text" name="folder_name" placeholder="Enter subfolder name"
                        class="text-sm border border-blue-200 bg-white p-2.5 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-300 transition">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Create Subfolder
                </button>
            </form>
        </div>

        <!-- Upload File Card -->
        <div class="bg-emerald-50/50 p-4 rounded-lg border border-emerald-100">
            <h3 class="text-sm font-semibold text-emerald-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload File
            </h3>
            <form method="POST" action="{{ route('files.uploadToFolder', $folderName) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="relative">
                    <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="flex items-center justify-between p-2.5 border border-emerald-200 bg-white rounded-lg text-sm text-gray-500">
                        <span class="truncate">Choose file</span>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 bg-blue-600 text-white rounded px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Bulk Actions Card -->
        <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-sm font-semibold text-purple-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                Bulk Actions
            </h3>
            <div class="space-y-3">
                <button id="bulk-rename-btn" class="w-full bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Rename Selected
                </button>
                <button id="bulk-delete-btn" class="w-full bg-red-100 hover:bg-red-200 text-red-800 px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Delete Selected
                </button>
            </div>
        </div>
    </div>
</aside>
@endsection

@section('content')
<div class="p-8 bg-white rounded-xl shadow-sm border border-gray-100">
    <!-- Folder Header -->
    <div class="flex items-start mb-6">
        <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100 mr-4">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        </div>
        <div class="flex-1">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-800" id="folder-name-display">{{ $folderName }}</h1>
                <button id="rename-folder-btn" class="ml-2 text-gray-400 hover:text-gray-600 transition-colors" title="Rename folder">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-500 text-sm mt-1">
                @if(count($files) > 0)
                {{ count($files) }} {{ count($files) === 1 ? 'item' : 'items' }}
                @else
                Empty folder
                @endif
            </p>
        </div>
        <div>
            <button id="delete-folder-btn" class="flex items-center text-sm text-red-600 hover:text-red-800 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors border border-red-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Folder
            </button>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <nav>
        <ol class="breadcrumb">
            <a href="{{ route('archive') }}">Home</a>

            @foreach ($breadcrumbs as $crumb)
            <li>
                <a href="{{ route('folders.open', ['folderName' => $crumb['path']]) }}"> {{ $crumb['name'] }}
                </a>
            </li>
            @endforeach
        </ol>
    </nav>

    <!-- Files Table -->
    <div class="mt-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Contents</h2>
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Search files..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-white transition">
            </div>
        </div>

        @if(count($files) > 0)
        <div class="overflow-hidden rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modified</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($files as $file)
                    <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $file['path'] }}" data-type="{{ $file['type'] }}" data-name="{{ $file['name'] }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected_items[]" value="{{ $file['path'] }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($file['type'] === 'folder')
                                <!-- Folder Icon -->
                                <div class="bg-yellow-50 p-1.5 rounded-md mr-3 border border-yellow-100">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                @else
                                <!-- File Icon with different types -->
                                @php
                                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                                $iconColor = 'text-gray-400';
                                $iconPath = '';

                                switch(strtolower($fileExtension)) {
                                case 'pdf':
                                $iconColor = 'text-red-500';
                                $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                break;
                                case 'doc':
                                case 'docx':
                                $iconColor = 'text-blue-500';
                                $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                break;
                                case 'xls':
                                case 'xlsx':
                                $iconColor = 'text-green-500';
                                $iconPath = 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                $iconColor = 'text-purple-500';
                                $iconPath = 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
                                break;
                                default:
                                $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                }
                                @endphp
                                <div class="bg-gray-50 p-1.5 rounded-md mr-3 border border-gray-100">
                                    <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $iconPath }}" />
                                    </svg>
                                </div>
                                @endif
                                <span class="text-sm font-medium text-gray-900">{{ $file['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['size'] ?? '--' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['modified'] ?? '--' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                @if($file['type'] === 'folder')
                                <a href="{{ route('folders.showAny', ['any' => $file['path']]) }}"
                                    class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors"
                                    title="Open">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <button class="rename-item-btn text-gray-500 hover:text-gray-700 p-1 rounded hover:bg-gray-50 transition-colors" title="Rename">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                @else
                                <a href="#" class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @endif
                                <a href="#" class="text-gray-500 hover:text-gray-700 p-1 rounded hover:bg-gray-50 transition-colors" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                <button class="delete-item-btn text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-700">No files found</h3>
            <p class="mt-1 text-gray-500 max-w-md mx-auto">This folder is empty. Upload files or create subfolders to get started.</p>
            <div class="mt-6 flex justify-center space-x-3">
                <button class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload Files
                </button>
                <button class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Subfolder
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Rename Folder Modal -->
<div id="rename-folder-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rename Folder</h3>
            <button id="close-rename-folder-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <label for="new-folder-name" class="block text-sm font-medium text-gray-700 mb-1">New Folder Name</label>
            <input type="text" id="new-folder-name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-rename-folder" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-rename-folder" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Rename</button>
        </div>
    </div>
</div>

<!-- Delete Folder Modal -->
<div id="delete-folder-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Delete Folder</h3>
            <button id="close-delete-folder-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <p class="text-gray-600">Are you sure you want to delete this folder and all its contents? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-delete-folder" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-delete-folder" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>

<!-- Rename Item Modal -->
<div id="rename-item-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rename Item</h3>
            <button id="close-rename-item-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <label for="new-item-name" class="block text-sm font-medium text-gray-700 mb-1">New Name</label>
            <input type="text" id="new-item-name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-rename-item" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-rename-item" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Rename</button>
        </div>
    </div>
</div>

<!-- Delete Item Modal -->
<div id="delete-item-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Delete Item</h3>
            <button id="close-delete-item-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <p class="text-gray-600">Are you sure you want to delete this item? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-delete-item" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-delete-item" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulk-delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Delete Selected Items</h3>
            <button id="close-bulk-delete-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <p class="text-gray-600">Are you sure you want to delete the selected items? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-bulk-delete" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-bulk-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>

<!-- Bulk Rename Modal -->
<div id="bulk-rename-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rename Selected Items</h3>
            <button id="close-bulk-rename-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <label for="bulk-rename-pattern" class="block text-sm font-medium text-gray-700 mb-1">Naming Pattern</label>
            <select id="bulk-rename-pattern" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                <option value="prefix">Add Prefix</option>
                <option value="suffix">Add Suffix</option>
                <option value="replace">Find and Replace</option>
                <option value="custom">Custom Pattern</option>
            </select>
            <div id="prefix-options" class="rename-option">
                <input type="text" id="prefix-text" placeholder="Enter prefix" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="suffix-options" class="rename-option hidden">
                <input type="text" id="suffix-text" placeholder="Enter suffix" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="replace-options" class="rename-option hidden">
                <input type="text" id="find-text" placeholder="Find text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
                <input type="text" id="replace-with" placeholder="Replace with" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="custom-options" class="rename-option hidden">
                <input type="text" id="custom-pattern" placeholder="Custom pattern (use {n} for number)" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-bulk-rename" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-bulk-rename" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Rename</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Folder rename functionality
    const renameFolderBtn = document.getElementById('rename-folder-btn');
    const renameFolderModal = document.getElementById('rename-folder-modal');
    const closeRenameFolderModal = document.getElementById('close-rename-folder-modal');
    const cancelRenameFolder = document.getElementById('cancel-rename-folder');
    const confirmRenameFolder = document.getElementById('confirm-rename-folder');
    const newFolderNameInput = document.getElementById('new-folder-name');
    const folderNameDisplay = document.getElementById('folder-name-display');
    
    renameFolderBtn.addEventListener('click', () => {
        newFolderNameInput.value = folderNameDisplay.textContent;
        renameFolderModal.classList.remove('hidden');
    });
    
    [closeRenameFolderModal, cancelRenameFolder].forEach(btn => {
        btn.addEventListener('click', () => {
            renameFolderModal.classList.add('hidden');
        });
    });
    
    confirmRenameFolder.addEventListener('click', () => {
        const newName = newFolderNameInput.value.trim();
        if (newName) {
            folderNameDisplay.textContent = newName;
            renameFolderModal.classList.add('hidden');
            // Here you would typically make an AJAX call to update the folder name on the server
            alert(`Folder renamed to: ${newName}`);
        }
    });
    
    // Folder delete functionality
    const deleteFolderBtn = document.getElementById('delete-folder-btn');
    const deleteFolderModal = document.getElementById('delete-folder-modal');
    const closeDeleteFolderModal = document.getElementById('close-delete-folder-modal');
    const cancelDeleteFolder = document.getElementById('cancel-delete-folder');
    const confirmDeleteFolder = document.getElementById('confirm-delete-folder');
    
    deleteFolderBtn.addEventListener('click', () => {
        deleteFolderModal.classList.remove('hidden');
    });
    
    [closeDeleteFolderModal, cancelDeleteFolder].forEach(btn => {
        btn.addEventListener('click', () => {
            deleteFolderModal.classList.add('hidden');
        });
    });
    
    confirmDeleteFolder.addEventListener('click', () => {
        deleteFolderModal.classList.add('hidden');
        // Here you would typically make an AJAX call to delete the folder on the server
        alert('Folder deleted!');
        // In a real app, you would redirect or refresh the page
    });
    
    // Item rename functionality
    const renameItemModal = document.getElementById('rename-item-modal');
    const closeRenameItemModal = document.getElementById('close-rename-item-modal');
    const cancelRenameItem = document.getElementById('cancel-rename-item');
    const confirmRenameItem = document.getElementById('confirm-rename-item');
    const newItemNameInput = document.getElementById('new-item-name');
    let currentItemToRename = null;
    
    document.querySelectorAll('.rename-item-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = e.closest('tr');
            currentItemToRename = row;
            const currentName = row.getAttribute('data-name');
            newItemNameInput.value = currentName;
            renameItemModal.classList.remove('hidden');
        });
    });
    
    [closeRenameItemModal, cancelRenameItem].forEach(btn => {
        btn.addEventListener('click', () => {
            renameItemModal.classList.add('hidden');
        });
    });
    
    confirmRenameItem.addEventListener('click', () => {
        const newName = newItemNameInput.value.trim();
        if (newName && currentItemToRename) {
            // Update the displayed name
            const nameCell = currentItemToRename.querySelector('td:nth-child(2) span');
            if (nameCell) {
                nameCell.textContent = newName;
            }
            renameItemModal.classList.add('hidden');
            // Here you would typically make an AJAX call to update the item name on the server
            alert(`Item renamed to: ${newName}`);
        }
    });
    
    // Item delete functionality
    const deleteItemModal = document.getElementById('delete-item-modal');
    const closeDeleteItemModal = document.getElementById('close-delete-item-modal');
    const cancelDeleteItem = document.getElementById('cancel-delete-item');
    const confirmDeleteItem = document.getElementById('confirm-delete-item');
    let currentItemToDelete = null;
    
    document.querySelectorAll('.delete-item-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentItemToDelete = e.closest('tr');
            deleteItemModal.classList.remove('hidden');
        });
    });
    
    [closeDeleteItemModal, cancelDeleteItem].forEach(btn => {
        btn.addEventListener('click', () => {
            deleteItemModal.classList.add('hidden');
        });
    });
    
    confirmDeleteItem.addEventListener('click', () => {
        if (currentItemToDelete) {
            // Remove the row from the table
            currentItemToDelete.remove();
            deleteItemModal.classList.add('hidden');
            // Here you would typically make an AJAX call to delete the item on the server
            alert('Item deleted!');
        }
    });
    
    // Bulk actions functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkRenameBtn = document.getElementById('bulk-rename-btn');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkRenameModal = document.getElementById('bulk-rename-modal');
    const bulkDeleteModal = document.getElementById('bulk-delete-modal');
    const closeBulkRenameModal = document.getElementById('close-bulk-rename-modal');
    const closeBulkDeleteModal = document.getElementById('close-bulk-delete-modal');
    const cancelBulkRename = document.getElementById('cancel-bulk-rename');
    const cancelBulkDelete = document.getElementById('cancel-bulk-delete');
    const confirmBulkRename = document.getElementById('confirm-bulk-rename');
    const confirmBulkDelete = document.getElementById('confirm-bulk-delete');
    const bulkRenamePattern = document.getElementById('bulk-rename-pattern');
    const renameOptions = document.querySelectorAll('.rename-option');
    
    // Select all checkbox functionality
    selectAllCheckbox.addEventListener('change', (e) => {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
    
    // Update select all checkbox when individual checkboxes change
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
        });
    });
    
    // Bulk rename
    bulkRenameBtn.addEventListener('click', () => {
        const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (selectedCount > 0) {
            bulkRenameModal.classList.remove('hidden');
        } else {
            alert('Please select at least one item to rename');
        }
    });
    
    [closeBulkRenameModal, cancelBulkRename].forEach(btn => {
        btn.addEventListener('click', () => {
            bulkRenameModal.classList.add('hidden');
        });
    });
    
    // Show different rename options based on selection
    bulkRenamePattern.addEventListener('change', (e) => {
        renameOptions.forEach(option => {
            option.classList.add('hidden');
        });
        document.getElementById(`${e.target.value}-options`).classList.remove('hidden');
    });
    
    confirmBulkRename.addEventListener('click', () => {
        const selectedPattern = bulkRenamePattern.value;
        const selectedItems = document.querySelectorAll('.item-checkbox:checked');
        
        selectedItems.forEach((checkbox, index) => {
            const row = checkbox.closest('tr');
            const currentName = row.getAttribute('data-name');
            let newName = currentName;
            
            switch(selectedPattern) {
                case 'prefix':
                    const prefix = document.getElementById('prefix-text').value;
                    newName = prefix + currentName;
                    break;
                case 'suffix':
                    const suffix = document.getElementById('suffix-text').value;
                    const ext = currentName.includes('.') ? currentName.split('.').pop() : '';
                    if (ext) {
                        const baseName = currentName.substring(0, currentName.lastIndexOf('.'));
                        newName = baseName + suffix + '.' + ext;
                    } else {
                        newName = currentName + suffix;
                    }
                    break;
                case 'replace':
                    const findText = document.getElementById('find-text').value;
                    const replaceWith = document.getElementById('replace-with').value;
                    newName = currentName.replace(new RegExp(findText, 'g'), replaceWith);
                    break;
                case 'custom':
                    const customPattern = document.getElementById('custom-pattern').value;
                    newName = customPattern.replace('{n}', index + 1);
                    break;
            }
            
            // Update the displayed name
            const nameCell = row.querySelector('td:nth-child(2) span');
            if (nameCell) {
                nameCell.textContent = newName;
            }
        });
        
        bulkRenameModal.classList.add('hidden');
        // Here you would typically make an AJAX call to update the items on the server
        alert(`${selectedItems.length} items renamed!`);
    });
    
    // Bulk delete
    bulkDeleteBtn.addEventListener('click', () => {
        const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (selectedCount > 0) {
            bulkDeleteModal.classList.remove('hidden');
        } else {
            alert('Please select at least one item to delete');
        }
    });
    
    [closeBulkDeleteModal, cancelBulkDelete].forEach(btn => {
        btn.addEventListener('click', () => {
            bulkDeleteModal.classList.add('hidden');
        });
    });
    
    confirmBulkDelete.addEventListener('click', () => {
        const selectedItems = document.querySelectorAll('.item-checkbox:checked');
        selectedItems.forEach(checkbox => {
            const row = checkbox.closest('tr');
            row.remove();
        });
        
        bulkDeleteModal.classList.add('hidden');
        // Here you would typically make an AJAX call to delete the items on the server
        alert(`${selectedItems.length} items deleted!`);
    });
});
</script>

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
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection