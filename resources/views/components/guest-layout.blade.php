<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Invoify') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Subtle background pattern animation */
        .pattern-bg {
            background: radial-gradient(circle at 25px 25px, rgba(255,255,255,0.05) 2%, transparent 0),
                        radial-gradient(circle at 75px 75px, rgba(255,255,255,0.05) 2%, transparent 0);
            background-size: 100px 100px;
            animation: movePattern 30s linear infinite;
        }

        @keyframes movePattern {
            from { background-position: 0 0, 0 0; }
            to { background-position: 100px 100px, 200px 200px; }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-100 bg-[#0A2342]">
    <div class="min-h-screen flex flex-col md:flex-row pattern-bg">
        <!-- Left Side: Branding -->
        <div class="md:w-1/2 flex flex-col justify-center items-center text-center px-8 py-10 md:py-0">
            <div class="space-y-4">
                <!-- Logo / Icon -->
                <div class="flex justify-center">
                    <div class="h-16 w-16 rounded-full bg-white/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-3-3v6m9-6v6a9 9 0 11-18 0v-6a9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- App Name -->
                <h1 class="text-4xl font-extrabold text-white tracking-wide">Invoify</h1>
                <p class="text-gray-300 text-sm max-w-sm mx-auto leading-relaxed">
                    Manage your invoices effortlessly. Send, track, and get paid faster — all in one place.
                </p>
            </div>
        </div>

        <!-- Right Side: Form / Slot Area -->
        <div class="md:w-1/2 flex justify-center items-center bg-white text-gray-800 p-8 md:rounded-l-3xl shadow-2xl relative">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>

            <!-- Decorative corner -->
            <div class="hidden md:block absolute top-0 right-0 translate-x-1/4 -translate-y-1/4 w-32 h-32 bg-[#0A2342]/10 rounded-full blur-2xl"></div>
        </div>
    </div>

    <footer class="text-center py-4 text-xs text-gray-400">
        &copy; {{ date('Y') }} <span class="font-semibold text-white">Invoify</span>. All rights reserved.
    </footer>
</body>
</html>
