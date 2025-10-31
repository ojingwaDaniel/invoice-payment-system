<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification — Invoify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-100 bg-[#0A2342]">

    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">

        <!-- Animated Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0A2342] via-[#102F5E] to-[#1B4EB2] animate-gradient opacity-95"></div>

        <!-- Floating Glows -->
        <div class="absolute w-96 h-96 bg-blue-500/20 rounded-full blur-3xl top-20 left-10 animate-float"></div>
        <div class="absolute w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl bottom-20 right-10 animate-float-slow"></div>

        <!-- Main Card -->
        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-10 text-center">
            
            <!-- Brand -->
            <h1 class="text-4xl font-bold text-white tracking-wide mb-1">Invoify</h1>
            <p class="text-gray-300 text-sm mb-8">Smart Invoicing. Simplified.</p>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-white/20 rounded-full shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M21 8V6a2 2 0 00-2-2H5a2 2 0 00-2 2v2m18 0l-9 6-9-6m18 0v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8" />
                    </svg>
                </div>
            </div>

            <!-- Headings -->
            <h2 class="text-2xl font-semibold text-white mb-3">Verify Your Email</h2>
            <p class="text-gray-200 text-sm leading-relaxed mb-6">
                Thanks for signing up! We’ve sent a verification link to your email address.  
                Please check your inbox to confirm your account.  
                Didn’t get it? You can resend below.
            </p>

            <!-- Session Alert -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-200 bg-green-600/20 border border-green-400/40 rounded-lg py-2 px-3">
                    A new verification link has been sent to your email.
                </div>
            @endif

            <!-- Buttons -->
            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#1B4EB2] to-[#0A2342] text-white py-2.5 rounded-lg font-semibold shadow-md hover:opacity-90 transition-all">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full border border-white/30 text-white py-2.5 rounded-lg font-medium hover:bg-white/10 transition-all">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <p class="relative z-10 mt-8 text-xs text-gray-400">
            &copy; {{ date('Y') }} <span class="font-semibold text-white">Invoify</span>. All rights reserved.
        </p>
    </div>

    <!-- Animations -->
    <style>
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 15s ease infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        .animate-float-slow {
            animation: float 12s ease-in-out infinite;
        }
    </style>
</body>
</html>
