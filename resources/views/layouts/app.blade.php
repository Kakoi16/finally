<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    
    @if (!Request::is('login'))
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .header-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .footer-gradient {
            background: linear-gradient(to right, #2c3e50, #4a6572);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    
   <div class="min-h-screen flex flex-col">
        
        {{-- Header --}}
         @if (!Request::is('login'))
        <header class="bg-white header-shadow sticky top-0 z-50 transition-all duration-300">
            @include('partials.header')
        </header>
        @endif

        {{-- Main --}}
        <main class="flex-grow container mx-auto px-4 py-6 flex flex-col md:flex-row">
            
            {{-- Sidebar --}}
            @if (!Request::is([
    'login',
    'profile',
    'profile/edit',
]))

                @if(View::hasSection('custom-sidebar'))
                    @yield('custom-sidebar')
                @else
                    @include('partials.sidebar')
                @endif
            @endif

            {{-- Content --}}
            <section class="w-full flex-grow bg-white rounded-lg shadow-md p-4">
                @yield('content')
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Script Log Activity hanya aktif di luar halaman login --}}
    @if (!Request::is('login'))
    <script>
        const activity = "Membuka halaman Arsip"; // Bisa disesuaikan/dibuat dinamis
        fetch("/public/log-activity", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                activity: activity,
                url: window.location.href
            })
        });

        // Script untuk header sticky yang berubah saat scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 10) {
                header.classList.add('bg-white/95', 'backdrop-blur-sm');
                header.classList.remove('bg-white');
            } else {
                header.classList.add('bg-white');
                header.classList.remove('bg-white/95', 'backdrop-blur-sm');
            }
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
