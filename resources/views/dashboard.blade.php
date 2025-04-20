@extends('layouts.app')

@section('content')
    <div id="breadcrumb" class="flex items-center text-sm text-gray-600 mb-4">
        <a href="#" class="hover:text-blue-600">Archive</a>
        <span class="mx-1">/</span>
        <a href="#" class="hover:text-blue-600">Dashboard</a>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
        <i class="fas fa-home text-blue-500 text-4xl mb-3"></i>
        <h3 class="text-xl font-medium text-gray-800 mb-2">Selamat Datang di Sistem Archive</h3>
        <p class="text-gray-600">Pilih menu di sidebar untuk melihat konten</p>
    </div>
@endsection
@push('scripts')
<script>
           document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            
            // Toggle sidebar di mobile
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            });

            // Fungsi untuk menampilkan halaman berdasarkan menu yang dipilih
            function showPage(pageId) {
                // Sembunyikan semua halaman
                document.querySelectorAll('.page-content').forEach(page => {
                    page.classList.add('hidden');
                });
                
                // Tampilkan halaman yang dipilih
                document.getElementById(pageId).classList.remove('hidden');
                
                // Update breadcrumb
                updateBreadcrumb(pageId);
                
                // Tutup sidebar di mobile
                if (window.innerWidth < 768) {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('block');
                }
            }

            // Fungsi untuk update breadcrumb
            function updateBreadcrumb(pageId) {
                const breadcrumb = document.getElementById('breadcrumb');
                let html = '<a href="#" class="hover:text-blue-600">Archive</a>';
                
                switch(pageId) {
                    case 'dashboard-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Dashboard</a>';
                        break;
                    case 'all-files-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Semua File</a>';
                        break;
                    case 'shared-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Shared</a>';
                        break;
                    case 'recent-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Recent</a>';
                        break;
                    case 'favorites-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Favorites</a>';
                        break;
                    case 'trash-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Trash</a>';
                        break;
                    default:
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Dashboard</a>';
                }
                
                breadcrumb.innerHTML = html;
            }

            // Tambahkan event listener untuk setiap menu sidebar
            document.querySelectorAll('.sidebar-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageId = this.getAttribute('data-page');
                    showPage(pageId);
                    
                    // Update active menu
                    document.querySelectorAll('.sidebar-menu').forEach(m => {
                        m.classList.remove('bg-blue-100', 'text-blue-600');
                        m.classList.add('hover:bg-gray-100');
                    });
                    this.classList.add('bg-blue-100', 'text-blue-600');
                    this.classList.remove('hover:bg-gray-100');
                });
            });

            // Tampilkan halaman default (Dashboard)
            showPage('dashboard-page');
            document.querySelector('[data-page="dashboard-page"]').classList.add('bg-blue-100', 'text-blue-600');
            document.querySelector('[data-page="dashboard-page"]').classList.remove('hover:bg-gray-100');
        });
</script>
@endpush
