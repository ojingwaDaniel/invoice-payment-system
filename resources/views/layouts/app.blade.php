<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bizin') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (dev CDN OK for Ngrok testing) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Theme Script -->
    <script src="{{ asset('js/theme-script.js') }}"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {50:'#f0f9ff',100:'#e0f2fe',500:'#0ea5e9',600:'#0284c7',700:'#0369a1'}
                    },
                    fontFamily: {sans: ['Inter', 'sans-serif']}
                }
            }
        }
    </script>

    <style>
        @media (min-width: 992px) { .header { margin-left: 100px; } }
        .sidebar { z-index: 1001 !important; }
        .header { z-index: 1000 !important; }
        @media (max-width: 991.98px) { .header { margin-left: 0; } }
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

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.topnav')

            <main class="flex-1 overflow-y-auto bg-gray-50 p-6 mt-10">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JS Assets -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebar', () => ({
                openSubmenu: '', sidebarOpen: window.innerWidth >= 1024, activeSection: 'dashboard',
                init() { if (window.innerWidth < 1024) this.sidebarOpen = false; },
                toggleSubmenu(menu) { this.openSubmenu = this.openSubmenu === menu ? '' : menu; },
                toggleSidebar() { this.sidebarOpen = !this.sidebarOpen; },
                setActiveSection(section) {
                    this.activeSection = section;
                    this.openSubmenu = '';
                    if (window.innerWidth < 1024) this.sidebarOpen = false;
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>
