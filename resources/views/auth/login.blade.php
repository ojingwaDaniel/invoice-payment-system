<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Invoify Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-15px) scale(1.05);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        .slide-in {
            animation: slideIn 0.6s ease-out;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .gradient-border {
            background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #3b82f6, #60a5fa) border-box;
            border: 2px solid transparent;
        }
    </style>
</head>

<body class="min-h-screen bg-white">
    <div class="flex min-h-screen">
        <!-- Left Side - White with Blue Accents -->
        <div class="relative hidden flex-col justify-between overflow-hidden bg-white p-12 lg:flex lg:w-1/2">
            <!-- Decorative Blue Elements -->
            <div class="absolute right-0 top-0 h-96 w-96 -translate-y-1/2 translate-x-1/2 rounded-full bg-blue-50"></div>
            <div class="absolute bottom-0 left-0 h-72 w-72 -translate-x-1/2 translate-y-1/2 rounded-full bg-blue-100">
            </div>

            <!-- Floating Blue Circles -->
            <div class="float-animation absolute left-20 top-20 h-16 w-16 rounded-full bg-blue-500 opacity-10"></div>
            <div class="float-animation absolute right-32 top-40 h-24 w-24 rounded-full bg-blue-400 opacity-10"
                style="animation-delay: 1s;"></div>
            <div class="float-animation absolute bottom-40 left-1/3 h-20 w-20 rounded-full bg-blue-600 opacity-10"
                style="animation-delay: 2s;"></div>

            <div class="slide-in relative z-10">
                <!-- Logo -->
                <div class="mb-16 flex items-center space-x-3">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-400 shadow-lg shadow-blue-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">invoify</span>
                </div>

                <div class="max-w-lg">
                    <h1 class="mb-6 text-6xl font-bold leading-tight text-gray-900">
                        Welcome<br />
                        <span class="text-blue-600">Back</span>
                    </h1>
                    <p class="text-xl leading-relaxed text-gray-600">
                        Sign in to access your dashboard and manage everything in one place.
                    </p>
                </div>
            </div>

            <!-- Feature Cards -->
            <div class="fade-in relative z-10 space-y-4" style="animation-delay: 0.3s;">
                <div class="group flex cursor-pointer items-center space-x-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 shadow-lg shadow-blue-500/30 transition-transform duration-300 group-hover:scale-110">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Secure Authentication</h3>
                        <p class="text-gray-600">Protected with industry-leading security</p>
                    </div>
                </div>
                <div class="group flex cursor-pointer items-center space-x-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 shadow-lg shadow-blue-500/30 transition-transform duration-300 group-hover:scale-110">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Lightning Fast</h3>
                        <p class="text-gray-600">Optimized for speed and performance</p>
                    </div>
                </div>
                <div class="group flex cursor-pointer items-center space-x-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 shadow-lg shadow-blue-500/30 transition-transform duration-300 group-hover:scale-110">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Cloud Powered</h3>
                        <p class="text-gray-600">Access your data from anywhere</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial -->
            <div class="fade-in relative z-10 rounded-2xl bg-blue-50 p-6" style="animation-delay: 0.6s;">
                <div class="flex items-start space-x-4">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-400">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-3 leading-relaxed text-gray-700">
                            "This platform has transformed how we work. The interface is intuitive and the performance
                            is exceptional."
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
        <div
            class="relative flex flex-1 items-center justify-center overflow-hidden bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 p-6 md:p-12">
            <!-- Decorative White Elements -->
            <div class="absolute right-0 top-0 h-96 w-96 -translate-y-1/2 translate-x-1/2 rounded-full bg-white/5">
            </div>
            <div class="absolute bottom-0 left-0 h-72 w-72 -translate-x-1/2 translate-y-1/2 rounded-full bg-white/5">
            </div>

            <!-- Login Card -->
            <div class="relative z-10 w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="mb-8 text-center lg:hidden">
                    <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-xl">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="mb-2 text-3xl font-bold text-white">Welcome Back</h2>
                    <p class="text-blue-100">Sign in to continue</p>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-2xl md:p-10">
                    <div class="mb-8">
                        <h2 class="mb-2 text-3xl font-bold text-gray-900">Sign In</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <!-- Email -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-900">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="email" required
                                    class="@error('email') border-red-300 bg-red-50 @enderror block w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-12 pr-4 text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="you@example.com" name="email" id="email"
                                    value="{{ old('email') }}" autofocus autocomplete="username">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-900">
                                Password
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="password" required
                                    class="@error('password') border-red-300 bg-red-50 @enderror block w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-12 pr-4 text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="••••••••" name="password" id="password"
                                    autocomplete="current-password">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="group flex cursor-pointer items-center">
                                <input type="checkbox"
                                    class="h-4 w-4 cursor-pointer rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0"
                                    id="remember_me" name="remember">
                                <span
                                    class="ml-2 text-sm text-gray-700 transition-colors group-hover:text-gray-900">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-blue-600 transition-colors hover:text-blue-700">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('g-recaptcha-response') }}</p>
                        @endif

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full transform rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-4 font-semibold text-white shadow-lg shadow-blue-500/50 transition-all duration-200 hover:scale-[1.02] hover:from-blue-700 hover:to-blue-600 hover:shadow-xl hover:shadow-blue-500/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-[0.98]">
                            {{ __('Log in') }}
                        </button>

                        <!-- Sign Up Link -->
                        <div class="pt-4 text-center">
                            <p class="text-gray-600">
                                {{ __("Don't have an account?") }}
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-1 font-semibold text-blue-600 transition-colors hover:text-blue-700">
                                        {{ __('Create account') }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Trust Badges -->
                <div class="mt-8 flex items-center justify-center space-x-6 text-sm text-white/80">
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                        </svg>
                        <span>SSL Secure</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        <span>GDPR Compliant</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>
