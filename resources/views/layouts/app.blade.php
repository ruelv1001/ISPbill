<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ISP Management By Medz') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
            padding: 0;
        }

        .container {
            min-height: 100vh;
            background-color: #fff;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        @media (min-width: 640px) {
            .main-wrapper {
                flex-direction: row;
            }
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background-color: #d3d3d3;
            padding: 5px;
        }

        /* Responsive Sidebar */
        .sidebar {
            width: 100%;
            background-color: #333;
            color: white;
            padding: 10px;
            display: none; /* Initially hidden on mobile */
        }

        .sidebar.active {
            display: block; /* Show when toggled */
        }

        @media (min-width: 768px) {
            .sidebar {
                width: 250px;
                display: block;
            }
        }

        /* Toggle Button */
        .sidebar-toggle {
            display: block;
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .sidebar-toggle {
                display: none; /* Hide toggle button on larger screens */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @include('layouts.navigation')

        <div class="sidebar-toggle" onclick="toggleSidebar()">☰ Menu</div>
        <div class="sidebar">
            @include('layouts.sidebar2')
        </div>

        <div class="main-wrapper">
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>

</html>
