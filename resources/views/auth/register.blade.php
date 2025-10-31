<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div
        class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 via-white to-cyan-50 px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="mb-8 text-center">
                <div
                    class="mb-4 inline-flex h-20 w-20 transform items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 shadow-xl transition-transform duration-300 hover:scale-105">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2
                    class="mb-2 bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-3xl font-bold text-transparent">
                    Welcome to Invoify
                </h2>
                <p class="text-2xl text-gray-600">Create A Business Account</p>
                <p class="text-gray-600">Join us today and get started</p>
            </div>

            <!-- Form Card -->
            <div class="rounded-3xl border border-gray-100 bg-white p-8 shadow-xl backdrop-blur-sm">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div class="relative">
                        <x-input-label for="name" :value="__('Full Name')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-text-input id="name"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                placeholder="John Doe" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Company Name -->
                    <div class="relative">
                        <x-input-label for="company_name" :value="__('Company Name')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                            </div>
                            <x-text-input id="company_name"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="text" name="company_name" :value="old('company_name')" autocomplete="organization"
                                placeholder="Your Company Ltd" />
                        </div>
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <!-- ✅ Phone Number -->
                    <div class="relative">
                        <x-input-label for="phone" :value="__('Phone Number')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h2l3.6 7.59a1 1 0 00.9.41h7.45a1 1 0 00.9-.55l3.4-6.45A1 1 0 0021 5H3z" />
                                </svg>
                            </div>
                            <x-text-input id="phone"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="tel" name="phone" :value="old('phone')" required autocomplete="tel"
                                placeholder="+234 812 345 6789" />
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- ✅ Address -->
                    <div class="relative">
                        <x-input-label for="address" :value="__('Address')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-start pl-4 pt-3">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 12.414A4 4 0 1116.657 9l4.243 4.243a8 8 0 01-3.243 3.414z" />
                                </svg>
                            </div>
                            <x-text-input id="address"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="text" name="address" :value="old('address')" required autocomplete="street-address"
                                placeholder="12 Adeola Odeku St, Victoria Island, Lagos" />
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="relative">
                        <x-input-label for="email" :value="__('Email Address')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="email" name="email" :value="old('email')" required autocomplete="username"
                                placeholder="you@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <x-input-label for="password" :value="__('Password')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                            class="mb-2 text-sm font-semibold text-gray-700" />
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400 transition-colors group-focus-within:text-blue-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-12 pr-4 transition-all duration-200 focus:border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="g-recaptcha mt-4" data-sitekey="{{ config('services.recaptcha.site') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('g-recaptcha-response') }}</p>
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button
                            class="w-full transform justify-center rounded-xl bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-3 font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-blue-900 hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                {{ __('Create Account') }}
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </x-primary-button>
                    </div>

                    <!-- Already Registered -->
                    <div class="border-t border-gray-100 pt-4 text-center">
                        <a class="group inline-flex items-center text-sm font-medium text-gray-600 transition-colors hover:text-blue-600"
                            href="{{ route('login') }}">
                            <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('Already have an account? Sign in') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    By signing up, you agree to our
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-700">Terms of Service</a>
                    and
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-700">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script
</body>

</html>
