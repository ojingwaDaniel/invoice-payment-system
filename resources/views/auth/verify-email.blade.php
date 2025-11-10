<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification — Invoify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-5deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8), 0 0 60px rgba(59, 130, 246, 0.4); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 15s ease infinite;
        }
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
        .animate-float-slow {
            animation: float 12s ease-in-out infinite;
        }
        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="antialiased text-gray-100 bg-[#0A2342] font-sans">

    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden px-4">

        <!-- Animated Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0A2342] via-[#102F5E] to-[#1B4EB2] animate-gradient opacity-95"></div>

        <!-- Floating Glows -->
        <div class="absolute w-96 h-96 bg-blue-500/20 rounded-full blur-3xl top-20 left-10 animate-float"></div>
        <div class="absolute w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl bottom-20 right-10 animate-float-slow"></div>
        <div class="absolute w-72 h-72 bg-cyan-400/15 rounded-full blur-3xl top-1/2 left-1/3 animate-float"></div>

        <!-- Main Card -->
        <div class="relative z-10 w-full max-w-md glass-effect rounded-2xl shadow-2xl p-8 md:p-10 text-center overflow-hidden">
            <!-- Shimmer Effect -->
            <div class="absolute inset-0 shimmer opacity-30 pointer-events-none"></div>

            <!-- Brand -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 mb-4 animate-pulse-glow">
                    <i class="fas fa-receipt text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-wide mb-1 text-shadow">Invoify</h1>
                <p class="text-gray-300 text-sm">Smart Invoicing. Simplified.</p>
            </div>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="p-5 bg-gradient-to-br from-blue-400/30 to-indigo-500/30 rounded-full shadow-lg border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>
            </div>

            <!-- Headings -->
            <h2 class="text-2xl font-semibold text-white mb-3 text-shadow">Verify Your Email</h2>
            <p class="text-gray-200 text-sm leading-relaxed mb-6">
                Thanks for signing up! We've sent a verification link to your email address.
                Please check your inbox to confirm your account.
                Didn't get it? You can resend below.
            </p>

            <!-- Session Alert -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 text-sm font-medium text-green-200 bg-green-600/20 border border-green-400/40 rounded-lg flex items-center justify-center space-x-2 animate-pulse">
                    <i class="fas fa-check-circle"></i>
                    <span>A new verification link has been sent to your email.</span>
                </div>
            @endif

            <!-- Buttons -->
            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-3.5 rounded-xl font-semibold shadow-lg transition-all duration-300 flex items-center justify-center space-x-2 group">
                        <i class="fas fa-paper-plane group-hover:animate-ping"></i>
                        <span>Resend Verification Email</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full border border-white/30 text-white py-3.5 rounded-xl font-medium hover:bg-white/10 transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>

            <!-- Help Text -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <p class="text-xs text-gray-400">
                    Need help? <a href="#" class="text-blue-300 hover:text-blue-200 underline transition-colors">Contact our support team</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="relative z-10 mt-8 text-xs text-gray-400 text-center">
            &copy; {{ date('Y') }} <span class="font-semibold text-white">Invoify</span>. All rights reserved.
        </p>
    </div>

    <script>
        // Add interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        button {
            position: relative;
            overflow: hidden;
        }
    </style>
</body>
</html>
