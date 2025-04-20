<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Archive</title>
    @vite('resources/css/app.css') <!-- Jika menggunakan Vite -->
</head>
<body class="bg-gray-100 text-gray-900">
    @include('components.navbar') <!-- Optional: Navbar -->

    <main>
        @yield('content')
    </main>
</body>
</html>
