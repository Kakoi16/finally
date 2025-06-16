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
        </div>
        <p class="text-gray-500 text-sm mt-1">
            @if(count($files) > 0)
            {{ count($files) }} {{ count($files) === 1 ? 'item' : 'items' }}
            @else
            Empty folder
            @endif
        </p>
    </div>
</div>