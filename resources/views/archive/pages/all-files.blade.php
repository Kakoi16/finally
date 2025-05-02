<!-- resources/views/all-files.blade.php -->

@php
$files = $archives ?? [];

$filteredFiles = [];

foreach ($files as $file) {
    if (!isset($file['path'])) {
        continue;
    }

    $relativePath = str_replace('uploads/', '', $file['path']);

    if (strpos($relativePath, '/') === false) {
        $filteredFiles[] = $file;
    }
}
@endphp

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>{{ session('error') }}</p>
    </div>
</div>
@endif

<div id="all-files-page" class="page-content p-6 space-y-6">
    <!-- Header with Breadcrumbs and Actions -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold text-gray-800">File Archive</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            @if(isset($currentFolder))
                            <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">{{ $currentFolder }}</span>
                            @else
                            <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">All Files</span>
                            @endif
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Upload File Button -->
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                @csrf
                <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()">
                <label for="file" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="text-sm font-medium">Upload</span>
                </label>
            </form>

            <!-- Create Folder Button -->
            <button onclick="toggleCreateFolderForm()" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <span class="text-sm font-medium">New Folder</span>
            </button>
        </div>
    </div>

    <!-- Create Folder Form (Hidden Initially) -->
    <div id="create-folder-form" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden animate-fade-in">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Create New Folder</h2>
        <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700 mb-1">Folder Name</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5 border" placeholder="Enter folder name">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="toggleCreateFolderForm()" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm">
                    Create Folder
                </button>
            </div>
        </form>
    </div>

    <!-- File List Table -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <h2 class="text-lg font-bold text-gray-800">All Files</h2>
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Search files..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        @if(!empty($files) && count($files) > 0)
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">
                            <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Modified</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($filteredFiles as $file)
                    <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $file['path'] }}" data-type="{{ $file['type'] }}" data-name="{{ $file['name'] }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected_items[]" value="{{ $file['path'] }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if(isset($file['type']) && $file['type'] === 'folder')
                                <svg class="flex-shrink-0 h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                @else
                                <svg class="flex-shrink-0 h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @endif
                                <span class="ml-3 text-sm font-medium text-gray-900 truncate max-w-xs">{{ $file['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 capitalize">
                                {{ $file['type'] ?? 'file' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['created_at'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file['size'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                @if(isset($file['type']) && $file['type'] === 'folder')
                                <a href="{{ route('folders.open', ['folderName' => basename($file['path'])]) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Open">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-8-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                @else
                                <a href="{{ $file['url'] ?? '#' }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @endif
                                <a href="#" class="text-gray-600 hover:text-gray-800 transition-colors" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
        <!-- Fallback UI when no files are found -->
        <div class="text-center py-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No files found</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by uploading a new file or creating a folder.</p>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" onclick="document.getElementById('file').click()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload File
                </button>
                <button onclick="toggleCreateFolderForm()" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    New Folder
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>

<script>
    function toggleCreateFolderForm() {
        const form = document.getElementById('create-folder-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            document.getElementById('folder_name').focus();
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const textarea = document.getElementById('bulk-renames');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateRenameTextarea);
        });

        function updateRenameTextarea() {
    let lines = [];

    checkboxes.forEach(cb => {
        if (cb.checked) {
            const row = cb.closest('tr');
            const oldPath = cb.value;
            const currentName = row?.dataset.name;

            if (oldPath && currentName) {
                lines.push(`${oldPath}➡️${currentName}`);
            }
        }
    });

    textarea.value = lines.join('\n');
}


        // opsional pada cekbox
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateRenameTextarea();
            });
        }
    });
</script>