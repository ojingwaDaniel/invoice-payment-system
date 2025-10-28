<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blue & White Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.05); }
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .float-animation { animation: float 4s ease-in-out infinite; }
        .slide-in { animation: slideIn 0.6s ease-out; }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        .gradient-border {
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #3b82f6, #60a5fa) border-box;
            border: 2px solid transparent;
        }
    </style>
</head>
<body class="min-h-screen bg-white">
    <div class="min-h-screen flex">
        <!-- Left Side - White with Blue Accents -->
        <div class="hidden lg:flex lg:w-1/2 bg-white p-12 flex-col justify-between relative overflow-hidden">
            <!-- Decorative Blue Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-50 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-100 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            
            <!-- Floating Blue Circles -->
            <div class="absolute top-20 left-20 w-16 h-16 bg-blue-500 rounded-full opacity-10 float-animation"></div>
            <div class="absolute top-40 right-32 w-24 h-24 bg-blue-400 rounded-full opacity-10 float-animation" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-40 left-1/3 w-20 h-20 bg-blue-600 rounded-full opacity-10 float-animation" style="animation-delay: 2s;"></div>

            <div class="relative z-10 slide-in">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-16">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">invoify</span>
                </div>

                <div class="max-w-lg">
                    <h1 class="text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Welcome<br/>
                        <span class="text-blue-600">Back</span>
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Sign in to access your dashboard and manage everything in one place.
                    </p>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="relative z-10 space-y-4 fade-in" style="animation-delay: 0.3s;">
                <div class="flex items-center space-x-4 group cursor-pointer">
                    <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Secure Authentication</h3>
                        <p class="text-gray-600">Protected with industry-leading security</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 group cursor-pointer">
                    <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Lightning Fast</h3>
                        <p class="text-gray-600">Optimized for speed and performance</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 group cursor-pointer">
                    <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Cloud Powered</h3>
                        <p class="text-gray-600">Access your data from anywhere</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial -->
            <div class="relative z-10 bg-blue-50 rounded-2xl p-6 fade-in" style="animation-delay: 0.6s;">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-400 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-700 mb-3 leading-relaxed">
                            "This platform has transformed how we work. The interface is intuitive and the performance is exceptional."
                        </p>
                        <div>
                            <p class="font-semibold text-gray-900">Sarah Johnson</p>
                            <p class="text-sm text-gray-600">Product Manager at TechCorp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Blue with White Form -->
        <div class="flex-1 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 p-6 md:p-12 flex items-center justify-center relative overflow-hidden">
            <!-- Decorative White Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            
            <!-- Login Card -->
            <div class="w-full max-w-md relative z-10">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl mb-4 shadow-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                    <p class="text-blue-100">Sign in to continue</p>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" required
                                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('email') border-red-300 bg-red-50 @enderror"
                                    placeholder="you@example.com"
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email') }}" 
                                    autofocus 
                                    autocomplete="username">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password" required
                                    class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 @error('password') border-red-300 bg-red-50 @enderror"
                                    placeholder="••••••••"
                                    name="password" 
                                    id="password" 
                                    autocomplete="current-password">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer"
                                    id="remember_me" 
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-4 px-4 rounded-xl shadow-lg shadow-blue-500/50 hover:shadow-xl hover:shadow-blue-500/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                            {{ __('Log in') }}
                        </button>

                    
                        <!-- Sign Up Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">
                                {{ __("Don't have an account?") }}
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors ml-1">
                                        {{ __('Create account') }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Trust Badges -->
                <div class="mt-8 flex items-center justify-center space-x-6 text-white/80 text-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                        </svg>
                        <span>SSL Secure</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>GDPR Compliant</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>