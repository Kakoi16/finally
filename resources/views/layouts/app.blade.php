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
    @include('components.action-cards')
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

    @stack('scripts')
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
    @include('components.action-cards')
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
    @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const actionCards = document.getElementById("action-cards");
        const hamburger = document.getElementById("hamburger-button");

        hamburger?.addEventListener("click", () => {
            sidebar?.classList.toggle("hidden");
            sidebar?.classList.toggle("flex");

            actionCards?.classList.toggle("hidden");
            actionCards?.classList.toggle("block");
        });
    });
</script>
@endpush

    @stack('scripts')
</body>
</html>

</body>
</html>
