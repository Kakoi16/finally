<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        @include('partials.header')

        <main class="flex-grow container mx-auto px-4 py-6 flex flex-col md:flex-row">
            @include('partials.sidebar')
            <section class="flex-grow bg-white rounded-lg shadow-md p-4">
                @yield('content')
            </section>
        </main>

        @include('partials.footer')
    </div>
    
    @stack('scripts')
    
</body>
</html>
