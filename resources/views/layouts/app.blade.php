<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bizin') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/simplebar/simplebar.min.css') }}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{ asset('css/iconsax.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Theme Script js (loaded in head for theme functionality) -->
    <script src="{{ asset('js/theme-script.js') }}"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .shadow-glow {
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.15);
        }
        .sidebar-container {
            z-index: 40;
        }
        .sidebar-overlay {
            z-index: 30;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans">
    <div class="flex h-screen bg-gray-50" x-data="sidebar()">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 lg:hidden sidebar-overlay"
             x-cloak>
        </div>

        <!-- Sidebar (Mini + Main) -->
        @include('layouts.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('layouts.topnav')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6 mt-10">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('plugins/simplebar/simplebar.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebar', () => ({
                openSubmenu: '',
                sidebarOpen: window.innerWidth >= 1024,
                activeSection: 'dashboard',

                init() {
                    if (window.innerWidth < 1024) {
                        this.sidebarOpen = false;
                    }
                },

                toggleSubmenu(menu) {
                    this.openSubmenu = this.openSubmenu === menu ? '' : menu;
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },

                setActiveSection(section) {
                    this.activeSection = section;
                    this.openSubmenu = '';
                    if (window.innerWidth < 1024) {
                        this.sidebarOpen = false;
                    }
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>