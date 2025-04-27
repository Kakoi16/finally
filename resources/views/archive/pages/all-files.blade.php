<!-- resources/views/all-files.blade.php -->

@php
$files = $archives ?? [];
@endphp

@if(session('success'))
<div class="bg-green-100 text-green-800 p-4 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 text-red-800 p-4 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<div id="all-files-page" class="page-content p-6 space-y-6 hidden">
    <!-- Header with Breadcrumbs and Actions -->
    <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-700">File Archive</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('files.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Home
                        </a>
                    </li>

                    @if (!empty($currentFolder))
    @php
        $folders = explode('/', $currentFolder);
        $path = '';
    @endphp
    @foreach ($folders as $folder)
        @php
            $path .= $folder . '/';
        @endphp
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <a href="{{ route('folders.open', ['folder' => rtrim($path, '/')]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">{{ $folder }}</a>
            </div>
        </li>
    @endforeach
@else
    <li aria-current="page">
        <div class="flex items-center">
            <svg class="w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">All Files</span>
        </div>
    </li>
@endif

                </ol>
            </nav>

        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2">
            <!-- Upload File Button -->
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                @csrf
                <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()">
                <label for="file" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span>Upload</span>
                </label>
            </form>

            <!-- Create Folder Button -->
            <button onclick="toggleCreateFolderForm()" type="button" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <span>New Folder</span>
            </button>
        </div>
    </div>

    <!-- Create Folder Form (Hidden Initially) -->
    <div id="create-folder-form" class="bg-white p-6 rounded-lg shadow hidden">
        <h2 class="text-lg font-semibold mb-4">Create New Folder</h2>
        <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700">Folder Name</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none p-2">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleCreateFolderForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    Create
                </button>
            </div>
        </form>
    </div>

    <!-- File List Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">{{ !empty($currentFolder) ? $currentFolder : 'All Files' }}</h2>
            <div class="relative">
                <input type="text" placeholder="Search files..." class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        @if(!empty($files) && count($files) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Modified</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($files as $file)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if(isset($file['type']) && $file['type'] === 'folder')
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                @else
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @endif
                                <span class="ml-2 text-sm font-medium text-gray-900 truncate max-w-xs">{{ $file['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['type'] ?? 'file' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['created_at'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['size'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                @if(isset($file['type']) && $file['type'] === 'folder')
                                <a href="{{ route('folders.open', ['folder' => $file['name']]) }}" class="text-blue-600 hover:text-blue-900">Open</a>

                                @else
                                <a href="{{ $file['url'] ?? '#' }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                @endif
                                <a href="#" class="text-gray-600 hover:text-gray-900">Download</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
    {{ !empty($currentFolder) ? 'No files in this folder' : 'No files' }}
</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by uploading a new file or creating a folder.</p>
            <div class="mt-6">
                <button type="button" onclick="document.getElementById('file').click()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload File
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function toggleCreateFolderForm() {
        var form = document.getElementById('create-folder-form');
        form.classList.toggle('hidden');
    }
</script>