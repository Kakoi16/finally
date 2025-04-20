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

        sidebarToggle?.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('block');
        });

        function showPage(pageId) {
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.add('hidden');
            });
            document.getElementById(pageId)?.classList.remove('hidden');
        }

        function updateBreadcrumb(pageId) {
            const breadcrumb = document.getElementById('breadcrumb');
            let html = '<a href="#">Archive</a>';
            // Tambah isi sesuai kebutuhan...
            breadcrumb.innerHTML = html;
        }

        document.querySelectorAll('.sidebar-menu').forEach(menu => {
            menu.addEventListener('click', function (e) {
                e.preventDefault();
                const pageId = this.getAttribute('data-page');
                showPage(pageId);
                updateBreadcrumb(pageId);
            });
        });

        showPage('dashboard-page');
    });
</script>
@endpush
