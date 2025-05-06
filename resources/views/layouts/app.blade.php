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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const actionCards = document.getElementById('action-cards');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            if (sidebar) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            } else if (actionCards) {
                actionCards.classList.toggle('hidden');
                actionCards.classList.toggle('block');
            }
        });
    }

    function showPage(pageId) {
        const page = document.getElementById(pageId);
        if (!page) return;

        document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
        page.classList.remove('hidden');
        updateBreadcrumb(pageId);

        if (window.innerWidth < 768) {
            if (sidebar) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('block');
            }
            if (actionCards) {
                actionCards.classList.add('hidden');
                actionCards.classList.remove('block');
            }
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

    @stack('scripts')
    
</body>
</html>
