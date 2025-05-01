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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rename Folder
    document.getElementById('confirm-rename-folder')?.addEventListener('click', function() {
        const newName = document.getElementById('new-folder-name').value;
        const folderPath = '{{ $folderPath }}';
        
        fetch(`/folders/${encodeURIComponent(folderPath)}/rename`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ new_name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error renaming folder');
            }
        });
    });

    // Delete Folder
    document.getElementById('confirm-delete-folder')?.addEventListener('click', function() {
        const folderPath = '{{ $folderPath }}';
        
        fetch(`/folders/${encodeURIComponent(folderPath)}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/archive';
            } else {
                alert(data.message || 'Error deleting folder');
            }
        });
    });

    // Rename Item
    document.getElementById('confirm-rename-item')?.addEventListener('click', function() {
        const newName = document.getElementById('new-item-name').value;
        const itemPath = currentItemToRename?.getAttribute('data-id');
        
        fetch(`/items/${encodeURIComponent(itemPath)}/rename`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ new_name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error renaming item');
            }
        });
    });

    // Delete Item
    document.getElementById('confirm-delete-item')?.addEventListener('click', function() {
        const itemPath = currentItemToDelete?.getAttribute('data-id');
        
        fetch(`/items/${encodeURIComponent(itemPath)}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error deleting item');
            }
        });
    });

    // Bulk Delete
    document.getElementById('confirm-bulk-delete')?.addEventListener('click', function() {
        const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
            .map(checkbox => checkbox.value);
            
        fetch('/items/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ selected_items: selectedItems })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error deleting items');
            }
        });
    });

    // Bulk Rename
    document.getElementById('confirm-bulk-rename')?.addEventListener('click', function() {
        const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
            .map(checkbox => checkbox.value);
        const pattern = document.getElementById('bulk-rename-pattern').value;
        const value = document.getElementById(`${pattern}-text`)?.value || '';
        const replaceWith = document.getElementById('replace-with')?.value || '';
        
        fetch('/items/bulk-rename', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                selected_items: selectedItems,
                rename_pattern: pattern,
                rename_value: value,
                replace_with: replaceWith
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error renaming items');
            }
        });
    });
});
</script>
@endsection
@section('styles')
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

