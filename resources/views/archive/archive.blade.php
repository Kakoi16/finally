@extends('layouts.app')

@section('content')
    <!-- Page Title & Action -->
    <div class="flex justify-between items-center mb-6">
        <h2 id="page-title" class="text-lg font-semibold">Dashboard</h2>
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

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar di mobilee
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('block');
        });
    }

    function showPage(pageId) {
        const page = document.getElementById(pageId);
        if (!page) return;

        document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
        page.classList.remove('hidden');
        updateBreadcrumb(pageId);

        if (window.innerWidth < 768 && sidebar) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('block');
        }
    }

    function updateBreadcrumb(pageId) {
        const breadcrumb = document.getElementById('breadcrumb');
        if (!breadcrumb) return;
        let html = '<a href="#" class="hover:text-blue-600">Archive</a>';
        const names = {
            'dashboard-page': 'Dashboard',
            'all-files-page': 'Semua File',
            'shared-page': 'Shared',
            'recent-page': 'Recent',
            'favorites-page': 'Favorites',
            'trash-page': 'Trash',
            'register-page': 'Daftar Karyawan'


        };
        const name = names[pageId] || 'Dashboard';
        html += `<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">${name}</a>`;
        breadcrumb.innerHTML = html;
        const title = document.getElementById('page-title');
        if (title) title.innerText = name;
    }

    document.querySelectorAll('.sidebar-menu').forEach(menu => {
        menu.addEventListener('click', function (e) {
            e.preventDefault();
            const pageId = this.getAttribute('data-page');
            showPage(pageId);
            document.querySelectorAll('.sidebar-menu').forEach(m => {
                m.classList.remove('bg-blue-100', 'text-blue-600');
                m.classList.add('hover:bg-gray-100');
            });
            this.classList.add('bg-blue-100', 'text-blue-600');
            this.classList.remove('hover:bg-gray-100');
        });
    });

    // Show default
    showPage('dashboard-page');
    const defaultMenu = document.querySelector('[data-page="dashboard-page"]');
    if (defaultMenu) {
        defaultMenu.classList.add('bg-blue-100', 'text-blue-600');
        defaultMenu.classList.remove('hover:bg-gray-100');
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token untuk AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, isSuccess = true) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-md ${
            isSuccess ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Fungsi untuk menangani error AJAX
    function handleAjaxError(error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan. Silakan coba lagi.', false);
    }

    // Folder rename functionality
    const renameFolderBtn = document.getElementById('rename-folder-btn');
    const renameFolderModal = document.getElementById('rename-folder-modal');
    const closeRenameFolderModal = document.getElementById('close-rename-folder-modal');
    const cancelRenameFolder = document.getElementById('cancel-rename-folder');
    const confirmRenameFolder = document.getElementById('confirm-rename-folder');
    const newFolderNameInput = document.getElementById('new-folder-name');
    const folderNameDisplay = document.getElementById('folder-name-display');

    if (renameFolderBtn) {
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
                fetch(`/folders/${encodeURIComponent('{{ $folderPath }}')}/rename`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ new_name: newName })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal mengubah nama folder', false);
                    }
                })
                .catch(handleAjaxError);
            }
        });
    }

    // Folder delete functionality
    const deleteFolderBtn = document.getElementById('delete-folder-btn');
    const deleteFolderModal = document.getElementById('delete-folder-modal');
    const closeDeleteFolderModal = document.getElementById('close-delete-folder-modal');
    const cancelDeleteFolder = document.getElementById('cancel-delete-folder');
    const confirmDeleteFolder = document.getElementById('confirm-delete-folder');

    if (deleteFolderBtn) {
        deleteFolderBtn.addEventListener('click', () => {
            deleteFolderModal.classList.remove('hidden');
        });

        [closeDeleteFolderModal, cancelDeleteFolder].forEach(btn => {
            btn.addEventListener('click', () => {
                deleteFolderModal.classList.add('hidden');
            });
        });

        confirmDeleteFolder.addEventListener('click', () => {
            fetch(`/folders/${encodeURIComponent('{{ $folderPath }}')}/delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '/archive';
                } else {
                    showNotification(data.message || 'Gagal menghapus folder', false);
                }
            })
            .catch(handleAjaxError);
        });
    }

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

    if (confirmRenameItem) {
        confirmRenameItem.addEventListener('click', () => {
            const newName = newItemNameInput.value.trim();
            if (newName && currentItemToRename) {
                const itemPath = currentItemToRename.getAttribute('data-id');
                
                fetch(`/items/${encodeURIComponent(itemPath)}/rename`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ new_name: newName })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal mengubah nama item', false);
                    }
                })
                .catch(handleAjaxError);
            }
        });
    }

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

    if (confirmDeleteItem) {
        confirmDeleteItem.addEventListener('click', () => {
            if (currentItemToDelete) {
                const itemPath = currentItemToDelete.getAttribute('data-id');
                
                fetch(`/items/${encodeURIComponent(itemPath)}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal menghapus item', false);
                    deleteItemModal.classList.add('hidden');
                    currentItemToDelete = null;
                    }
                })
                .catch(handleAjaxError);
            }
        });
    }

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
    if (selectAllCheckbox) {
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
    }

    // Bulk rename
    if (bulkRenameBtn) {
        bulkRenameBtn.addEventListener('click', () => {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (selectedCount > 0) {
                bulkRenameModal.classList.remove('hidden');
            } else {
                showNotification('Pilih setidaknya satu item untuk diubah nama', false);
            }
        });

        [closeBulkRenameModal, cancelBulkRename].forEach(btn => {
            btn.addEventListener('click', () => {
                bulkRenameModal.classList.add('hidden');
            });
        });

        // Show different rename options based on selection
        if (bulkRenamePattern) {
            bulkRenamePattern.addEventListener('change', (e) => {
                renameOptions.forEach(option => {
                    option.classList.add('hidden');
                });
                document.getElementById(`${e.target.value}-options`).classList.remove('hidden');
            });
        }

        if (confirmBulkRename) {
            confirmBulkRename.addEventListener('click', () => {
                const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                    .map(checkbox => checkbox.value);
                const pattern = document.getElementById('bulk-rename-pattern').value;
                const value = document.getElementById(`${pattern}-text`)?.value || '';
                const replaceWith = document.getElementById('replace-with')?.value || '';
                
                if (selectedItems.length === 0) {
                    showNotification('Pilih setidaknya satu item untuk diubah nama', false);
                    return;
                }

                fetch('/items/bulk-rename', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        selected_items: selectedItems,
                        rename_pattern: pattern,
                        rename_value: value,
                        replace_with: replaceWith
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal mengubah nama item', false);
                    }
                })
                .catch(handleAjaxError);
            });
        }
    }

    // Bulk delete
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', () => {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (selectedCount > 0) {
                bulkDeleteModal.classList.remove('hidden');
            } else {
                showNotification('Pilih setidaknya satu item untuk dihapus', false);
            }
        });

        [closeBulkDeleteModal, cancelBulkDelete].forEach(btn => {
            btn.addEventListener('click', () => {
                bulkDeleteModal.classList.add('hidden');
            });
        });

        if (confirmBulkDelete) {
            confirmBulkDelete.addEventListener('click', () => {
                const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                    .map(checkbox => checkbox.value);
                
                if (selectedItems.length === 0) {
                    showNotification('Pilih setidaknya satu item untuk dihapus', false);
                    return;
                }

                fetch('/items/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ selected_items: selectedItems })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal menghapus item', false);
                    }
                })
                .catch(handleAjaxError);
            });
        }
    }
});
</script>
@endpush
