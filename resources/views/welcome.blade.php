<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harmoni Event - Penyelenggara Acara Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .mobile-menu {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold">Harmoni Event</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium bg-white bg-opacity-10">Beranda</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Acara</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Layanan</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Galeri</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Kontak</a>
                        <a href="/login" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Masuk</a>
                        <a href="/register" class="px-3 py-2 rounded-md text-sm font-medium bg-purple-600 hover:bg-purple-700">Daftar</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-white hover:bg-opacity-10 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden glass-nav">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium bg-white bg-opacity-10">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Acara</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Layanan</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Galeri</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Kontak</a>
                <a href="/login" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Masuk</a>
                <a href="/register" class="block px-3 py-2 rounded-md text-base font-medium bg-purple-600 hover:bg-purple-700">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <!-- ... (konten hero section tetap sama) ... -->
    </section>

    <!-- ... (bagian lainnya tetap sama) ... -->

    <script>
        // Mobile menu toggle functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
            } else {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenu.contains(event.target) || mobileMenuButton.contains(event.target);
            
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });

        // Handle login/register navigation
        document.querySelectorAll('a[href="/login"], a[href="/register"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.getAttribute('href');
            });
        });
    </script>
</body>
</html>