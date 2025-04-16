<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projek Kita</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
      html {
    scroll-behavior: smooth;
  }
  </style>
</head>
<body class="text-white bg-gray-900">

  <!-- Navbar -->
<!-- Navbar -->
<header class="fixed w-full top-0 z-50 bg-gray-900/80 backdrop-blur-md shadow-md">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-white">Modern Ui lek</h1>

    <!-- Hamburger -->
    <button id="menu-toggle" class="text-white md:hidden focus:outline-none transition-all duration-300">
      <svg id="hamburger" class="w-6 h-6 transition duration-300 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
      <svg id="close" class="w-6 h-6 hidden transition duration-300 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    <!-- Desktop -->
    <nav class="hidden md:flex space-x-4">
      <a href="#" class="hover:text-teal-300 transition">Home</a>
      <a href="#" class="hover:text-teal-300 transition">About</a>
      <a href="#" class="hover:text-teal-300 transition">Contact</a>
      <a href="/login" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-all duration-300">Login</a>
      <a href="/register" class="bg-white text-gray-900 hover:bg-gray-200 px-4 py-2 rounded-lg transition-all duration-300">Register</a>
    </nav>
  </div>

  <!-- Mobile -->
  <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 transition-all duration-500 ease-in-out px-4 pb-0 space-y-2 bg-gray-900">
    <a href="#" class="block hover:text-teal-300 transition">Home</a>
    <a href="#" class="block hover:text-teal-300 transition">About</a>
    <a href="#" class="block hover:text-teal-300 transition">Contact</a>
    <a href="/login" class="block bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg transition-all">Login</a>
    <a href="/register" class="block bg-white text-gray-900 hover:bg-gray-200 px-4 py-2 rounded-lg transition-all">Register</a>
  </div>
</header>


  <!-- Hero Section -->
  <section class="h-screen bg-[url('https://images.unsplash.com/photo-1506744038136-46273834b3fb')] bg-cover bg-center bg-fixed flex items-center justify-center">
    <div class="text-center">
      <h2 class="text-5xl font-bold mb-4 drop-shadow-lg">Selamat Datang</h2>
      <p class="text-xl drop-shadow-md">Website Parallax Modern dengan TailwindCSS</p>
    </div>
  </section>

  <!-- About Section -->
  <section class="h-screen bg-gray-900 flex items-center justify-center">
    <div class="max-w-3xl text-center">
      <h3 class="text-4xl font-semibold mb-6">Tentang Kami</h3>
      <p class="text-lg text-gray-300">Kami membangun web modern yang interaktif dan cepat menggunakan TailwindCSS dan efek parallax yang elegan.</p>
    </div>
  </section>

  <!-- Parallax Section -->
  <section class="h-screen bg-[url('https://images.unsplash.com/photo-1503264116251-35a269479413')] bg-cover bg-fixed bg-center flex items-center justify-center">
    <h3 class="text-4xl font-bold drop-shadow-lg">Desain Modern & Responsif</h3>
  </section>

  <!-- Contact Section -->
  <section class="h-screen bg-gray-800 flex items-center justify-center">
    <div class="text-center">
      <h3 class="text-4xl font-semibold mb-6">Hubungi Kami</h3>
      <p class="text-gray-300">Email: info@parallaxweb.com | Telp: 0812-3456-7890</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 py-6 text-center text-gray-400">
    © 2025 ParallaxWeb. All rights reserved.
  </footer>

  <!-- Script -->
  <script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const hamburgerIcon = document.getElementById('hamburger');
  const closeIcon = document.getElementById('close');

  let isOpen = false;

  menuToggle.addEventListener('click', () => {
    isOpen = !isOpen;

    if (isOpen) {
      mobileMenu.classList.remove('max-h-0', 'pb-0');
      mobileMenu.classList.add('max-h-96', 'pb-4');
    } else {
      mobileMenu.classList.remove('max-h-96', 'pb-4');
      mobileMenu.classList.add('max-h-0', 'pb-0');
    }

    hamburgerIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
  });
</script>


</body>
</html>
