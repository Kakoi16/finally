<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Harmoni Event')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,rgb(58, 59, 66) 0%,rgb(149, 140, 158) 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.3);
        }
        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .form-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
            outline: none;
        }
        .logout-link {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: background 0.3s;
        }
        .logout-link:hover {
            background: rgba(255, 255, 255, 0.25);
        }
    </style>
</head>
<body class="text-white relative">
    <!-- Logout Button (Optional Display) -->
    @auth
    <a href="{{ route('logout') }}"
       class="logout-link"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    @endauth

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4">
        @yield('content')
    </div>
</body>
</html>
