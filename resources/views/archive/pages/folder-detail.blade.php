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

                switch (selectedPattern) {
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

