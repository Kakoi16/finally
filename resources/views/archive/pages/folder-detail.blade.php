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
                <form method="POST" action="{{ route('folders.createSubfolder', $folderName) }}" class="space-y-3">
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
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                        Upload File
                    </button>
                </form>
            </div>
            
            <!-- Folder Actions -->
            <div class="space-y-1.5">
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-50 text-gray-600 hover:text-gray-900 transition-colors text-sm font-medium border border-gray-100">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Rename Folder
                </a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-red-50 text-red-600 hover:text-red-700 transition-colors text-sm font-medium border border-gray-100">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Folder
                </a>
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
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $folderName }}</h1>
                <p class="text-gray-500 text-sm mt-1">
                    @if(count($files) > 0)
                        {{ count($files) }} {{ count($files) === 1 ? 'item' : 'items' }}
                    @else
                        Empty folder
                    @endif
                </p>
            </div>
        </div>

        <!-- Breadcrumbs -->
        <nav>
    <ol class="breadcrumb">
    <a href="{{ route('archive') }}">Home</a>

        @foreach ($breadcrumbs as $crumb)
            <li>
                <a href="{{ route('folders.open', ['folderName' => $crumb['path']]) }}">                    {{ $crumb['name'] }}
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modified</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($files as $file)
                                <tr class="hover:bg-gray-50 transition-colors">
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
                                                <a href="#" class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors" title="Open">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
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
                                            <a href="#" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
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
@endsection