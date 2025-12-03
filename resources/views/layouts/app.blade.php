<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bizin') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (dev CDN OK for Ngrok testing) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                            700: '#0369a1'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
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
    </style>

    @stack('styles')
</head>

<body class="font-sans">
    <div class="flex h-screen bg-gray-50" x-data="sidebar()">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="sidebar-overlay fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden" x-cloak>
        </div>

        @include('layouts.sidebar')

        <div class="flex flex-1 flex-col overflow-hidden">
            @include('layouts.topnav')

            <main class="mt-10 flex-1 overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

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
