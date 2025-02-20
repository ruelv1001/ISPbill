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
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --header-height: 60px;
            --primary-bg: #ffffff;
            --secondary-bg: #d3d3d3;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        .container {
            min-height: 100vh;
            background-color: var(--primary-bg);
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .main-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            width: 100%;
            position: relative;
        }

        .sidebar {
            background-color: #f8f9fa;
            width: 100%;
            height: 100%;
            z-index: 10;
            transition: all 0.3s ease;
            overflow-y: auto;
            position: fixed;
            top: var(--header-height);
            left: -100%;
            bottom: 0;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            flex: 1;
            padding: 15px;
            background-color: var(--secondary-bg);
            transition: all 0.3s ease;
            margin-top: var(--header-height);
        }

        /* Navigation styles */
        .nav-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .nav-brand {
            font-weight: bold;
            font-size: 1.25rem;
            margin-left: 10px;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #333;
        }

        .nav-actions {
            display: flex;
            align-items: center;
        }

        .user-dropdown {
            position: relative;
            margin-left: 10px;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        .dropdown-toggle img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            min-width: 180px;
            z-index: 30;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 5px 0;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            color: #dc3545;
            transition: background-color 0.2s;
        }

        .logout-button:hover {
            background-color: #f8d7da;
        }

        /* Mobile menu styles */
        .mobile-menu-toggle {
            display: none;
        }

        @media (max-width: 767px) {
            .nav-brand {
                font-size: 1rem;
            }

            .user-name {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
                margin-left: auto;
                margin-right: 10px;
            }
        }

        /* Tablet and desktop styles */
        @media (min-width: 768px) {
            .main-wrapper {
                flex-direction: row;
            }

            .sidebar {
                position: relative;
                width: var(--sidebar-width);
                left: 0;
                top: 0;
                height: calc(100vh - var(--header-height));
                margin-top: var(--header-height);
            }

            .sidebar.collapsed {
                width: var(--sidebar-collapsed-width);
            }

            .main-content {
                margin-left: 0;
                width: calc(100% - var(--sidebar-width));
                overflow-x: auto;
            }

            .main-content.sidebar-collapsed {
                width: calc(100% - var(--sidebar-collapsed-width));
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        /* Large desktop styles */
        @media (min-width: 1200px) {
            .main-content {
                padding: 20px 30px;
            }
        }

        /* Print styles */
        @media print {
            .sidebar, .nav-container {
                display: none;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                margin-top: 0;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --primary-bg: #1a1a1a;
                --secondary-bg: #2c2c2c;
            }

            body {
                color: #e0e0e0;
            }

            .sidebar, .nav-container, .dropdown-menu {
                background-color: #262626;
                color: #e0e0e0;
            }

            .toggle-sidebar, .dropdown-toggle, .dropdown-item {
                color: #e0e0e0;
            }

            .dropdown-divider {
                background-color: #444;
            }

            .dropdown-item:hover {
                background-color: #333;
            }

            .logout-button {
                color: #ff6b6b;
            }

            .logout-button:hover {
                background-color: #442a2a;
            }
        }

        /* Notification styles */
        .notification-bell {
            position: relative;
            margin-right: 15px;
            cursor: pointer;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ff3b30;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="nav-container">
            <div class="nav-left">
                <button id="sidebarToggle" class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="nav-brand">{{ config('app.name', 'ISP Management') }}</div>
            </div>

            <div class="nav-actions">
                <!-- Notifications -->
                <!-- <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div> -->
                
                <!-- User dropdown -->
                <div class="user-dropdown">
                    <button id="userDropdownToggle" class="dropdown-toggle">
                        <!-- <img src="/api/placeholder/32/32" alt="User avatar"> -->
                        <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    <div id="userDropdownMenu" class="dropdown-menu">
                        <a href="{{ route('profile.edit') ?? '#' }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
               
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') ?? '#' }}" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-button">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main-wrapper">
            <aside id="sidebar" class="sidebar">
                @include('layouts.sidebar2')
            </aside>
            <main id="mainContent" class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            // Check screen size on load
            checkScreenSize();
            
            // Toggle sidebar visibility
            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.toggle('active');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                }
            });
            
            // User dropdown functionality
            const userDropdownToggle = document.getElementById('userDropdownToggle');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            
            userDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                userDropdownMenu.classList.remove('show');
            });
            
            // Handle resize events
            window.addEventListener('resize', checkScreenSize);
            
            function checkScreenSize() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('active');
                } else {
                    sidebar.classList.remove('active');
                    // Optional: reset to default expanded state on larger screens
                    // sidebar.classList.remove('collapsed');
                    // mainContent.classList.remove('sidebar-collapsed');
                }
            }
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>