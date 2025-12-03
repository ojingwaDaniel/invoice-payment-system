<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bizin') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @media (min-width: 992px) {
            .header {
                margin-left: 100px;
            }
        }

        .sidebar {
            z-index: 1001 !important;
        }

        .header {
            z-index: 1000 !important;
        }

        @media (max-width: 991.98px) {
            .header {
                margin-left: 0;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div x-data="sidebar()">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="sidebar-overlay position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none"
            style="z-index: 30;"
            x-cloak>
        </div>

        @include('layouts.sidebar')

        <div class="d-flex flex-column" style="min-height: 100vh;">
            @include('layouts.topnav')

            <main class="flex-grow-1 bg-light p-4" style="margin-top: 60px;">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebar', () => ({
                openSubmenu: '',
                sidebarOpen: window.innerWidth >= 1024,
                activeSection: 'dashboard',
                init() {
                    if (window.innerWidth < 1024) this.sidebarOpen = false;
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
                    if (window.innerWidth < 1024) this.sidebarOpen = false;
                }
            }));
        });
    </script>

    @stack('scripts')
</body>

</html>
