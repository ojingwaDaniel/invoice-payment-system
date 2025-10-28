<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl">
            <div class="bg-slate-900/50 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-blue-900/20">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Left Side - Branding with Dark Blue Gradient -->
                    <div class="hidden md:flex bg-gradient-to-br from-blue-900 via-blue-950 to-slate-950 p-12 flex-col justify-between relative overflow-hidden">
                        <!-- Animated background circles -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full opacity-10 blur-3xl animate-pulse"></div>
                        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-700 rounded-full opacity-10 blur-3xl"></div>
                        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-blue-500 rounded-full opacity-5 blur-3xl"></div>

                        <div class="relative z-10">
                            <!-- Custom Logo -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/20 backdrop-blur-sm rounded-2xl mb-8 shadow-lg border border-blue-400/20">
                                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h1 class="text-4xl font-bold text-white mb-4">Welcome Back</h1>
                            <p class="text-blue-200 text-lg leading-relaxed">Sign in to access your dashboard and manage your account with ease.</p>
                        </div>

                        <div class="relative z-10 space-y-6">
                            <div class="flex items-start space-x-4 bg-blue-500/10 backdrop-blur-sm rounded-xl p-4 border border-blue-400/20">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-500/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-blue-100 font-semibold mb-1">Secure Access</h3>
                                    <p class="text-blue-300 text-sm">Your data is protected with enterprise-grade security.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 bg-blue-500/10 backdrop-blur-sm rounded-xl p-4 border border-blue-400/20">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-500/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-blue-100 font-semibold mb-1">Lightning Fast</h3>
                                    <p class="text-blue-300 text-sm">Experience blazing fast performance and reliability.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="p-8 md:p-12 flex flex-col justify-center bg-slate-900/80 backdrop-blur-sm">
                        <!-- Mobile Logo -->
                        <div class="md:hidden mb-8 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl mb-4 shadow-lg shadow-blue-900/50">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-white">Sign In</h2>
                        </div>

                        <div class="hidden md:block mb-8">
                            <h2 class="text-3xl font-bold text-white mb-2">Sign In</h2>
                            <p class="text-blue-200">Enter your credentials to access your account</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-300 text-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-blue-100 mb-2">
                                    {{ __('Email Address') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                        class="block w-full pl-12 pr-4 py-3.5 bg-slate-800/50 border border-blue-900/50 rounded-xl text-white placeholder-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                                        placeholder="you@example.com">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-blue-100 mb-2">
                                    {{ __('Password') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input id="password" type="password" name="password" required autocomplete="current-password"
                                        class="block w-full pl-12 pr-4 py-3.5 bg-slate-800/50 border border-blue-900/50 rounded-xl text-white placeholder-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('password') border-red-500 @enderror"
                                        placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="flex items-center cursor-pointer group">
                                    <input id="remember_me" type="checkbox" name="remember"
                                        class="w-4 h-4 rounded border-blue-800 bg-slate-800 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition duration-200 cursor-pointer">
                                    <span class="ml-2 text-sm text-blue-200 group-hover:text-white transition duration-200">{{ __('Remember me') }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-200">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-900/50 hover:shadow-xl hover:shadow-blue-800/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                                {{ __('Log in') }}
                            </button>

                            <!-- Divider -->
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-blue-900/30"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-slate-900 text-blue-300">{{ __("Don't have an account?") }}</span>
                                </div>
                            </div>

                            <!-- Sign Up Link -->
                            @if (Route::has('register'))
                                <div class="text-center">
                                    <a href="{{ route('register') }}" class="inline-flex items-center text-sm font-semibold text-blue-400 hover:text-blue-300 transition duration-200 group">
                                        {{ __('Create a new account') }}
                                        <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-sm text-blue-300/50">
                <p>© 2024 {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
