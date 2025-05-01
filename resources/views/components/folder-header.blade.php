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