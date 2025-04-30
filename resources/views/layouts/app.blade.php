<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        
        {{-- Header --}}
        @include('partials.header')

        {{-- Main --}}
        <main class="flex-grow container mx-auto px-4 py-6 flex flex-col md:flex-row">
            
            {{-- Sidebar --}}
@if(View::hasSection('custom-sidebar'))
    @yield('custom-sidebar')
@else
    @include('partials.sidebar')
@endif


            {{-- Content --}}
            <section class="flex-grow bg-white rounded-lg shadow-md p-4">
                @yield('content')
            </section>
        </main>

        {{-- Footer --}}
        @include('partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        

window.toggleRenameMode = function () {
    const checkboxes = document.querySelectorAll('.folder-checkbox');
    checkboxes.forEach(cb => cb.classList.toggle('hidden'));

    const visibleCheckboxes = [...checkboxes].filter(cb => !cb.classList.contains('hidden'));

    if (visibleCheckboxes.length === 0) {
        const selected = [...checkboxes].filter(cb => cb.checked);
        if (selected.length === 0) {
            alert('Pilih folder yang ingin di-rename.');
            return;
        }

        selected.forEach(cb => {
            const currentName = cb.dataset.name;
            const newName = prompt(`Rename folder "${currentName}" ke:`);
            if (newName && newName !== currentName) {
                renameFolder(cb.value, newName);
            }
        });
    }
}

window.renameFolder = function (folderId, newName) {
    fetch(`/rename-folder/${folderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name: newName })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal rename folder.');
        }
    });
}

window.deleteSelectedFolders = function () {
    const selected = [...document.querySelectorAll('.folder-checkbox:checked')];
    if (selected.length === 0) {
        alert('Pilih folder yang ingin dihapus.');
        return;
    }

    if (!confirm('Yakin ingin menghapus folder terpilih?')) return;

    const ids = selected.map(cb => cb.value);

    fetch('/delete-folders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal menghapus folder.');
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar di mobile
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
    </script>
</body>
</html>
