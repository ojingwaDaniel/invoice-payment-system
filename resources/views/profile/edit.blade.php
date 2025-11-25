@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8">

        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-2 text-gray-600">Manage your account settings and preferences</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 rounded-md border-l-4 border-green-500 bg-green-50 p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-md border-l-4 border-red-500 bg-red-50 p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <ul class="text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="mb-6 flex flex-col items-center">
                
                        <div class="mb-4">
                            <div
                                class="from-primary-500 to-primary-700 mx-auto flex h-24 w-24 items-center justify-center overflow-hidden rounded-full bg-gradient-to-r text-xl font-bold text-white">
                                @if (auth()->user()->logo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->logo_path) }}" alt="Logo"
                                        class="h-full w-full object-cover" id="currentLogo">
                                @else
                                    <span
                                        id="logoInitials">{{ substr(auth()->user()->company_name ?: auth()->user()->name, 0, 2) }}</span>
                                @endif
                            </div>

                            <form id="logoUploadForm" action="{{ route('profile.uploadLogo') }}" method="POST"
                                enctype="multipart/form-data" class="mt-4">
                                @csrf

                                <div class="flex flex-col items-center gap-3">
                                    <label for="logo"
                                        class="bg-primary-500 hover:bg-primary-600 cursor-pointer rounded-full p-3 text-white shadow-lg transition-colors">
                                        <i class="fas fa-camera"></i>
                                        <span class="ml-2 text-sm">Choose Logo</span>
                                    </label>

                                    <input type="file" id="logo" name="logo" accept="image/*" class="hidden"
                                        onchange="previewLogo(this)">

                                    <button type="submit" id="uploadBtn"
                                        class="bg-primary-500 hover:bg-primary-600 hidden rounded-lg px-4 py-2 text-sm text-white">
                                        Upload Logo
                                    </button>
                                </div>
                            </form>

                            <img id="logoPreview" class="mx-auto mt-3 hidden h-24 w-24 rounded-full object-cover shadow-md">
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ auth()->user()->company_name ?: 'No company name' }}</p>
                </div>

                <nav class="space-y-2">
                    <a href="#"
                        class="text-primary-600 bg-primary-50 flex items-center rounded-lg px-4 py-3 font-medium">
                        <i class="fas fa-user-circle mr-3"></i> Profile Information
                    </a>
                    <a href="#" class="flex items-center rounded-lg px-4 py-3 text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-lock mr-3"></i> Security
                    </a>
                    <a href="#" class="flex items-center rounded-lg px-4 py-3 text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-bell mr-3"></i> Notifications
                    </a>
                    <a href="#" class="flex items-center rounded-lg px-4 py-3 text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-credit-card mr-3"></i> Billing
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="space-y-8 lg:col-span-2">

            <!-- Profile Info Card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Profile Information</h2>
                    <p class="mt-1 text-sm text-gray-600">Update your account's profile information</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            <div>
                                <label class="mb-1 block text-sm font-medium">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="focus:ring-primary-500 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="focus:ring-primary-500 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium">Company Name</label>
                                <input type="text" name="company_name"
                                    value="{{ old('company_name', $user->company_name) }}"
                                    class="focus:ring-primary-500 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="focus:ring-primary-500 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium">Address</label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                    class="focus:ring-primary-500 w-full rounded-lg border px-4 py-3">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button class="bg-primary-500 hover:bg-primary-600 rounded-lg px-6 py-3 text-white">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Paystack Card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Paystack Integration</h2>
                    <p class="mt-1 text-sm text-gray-600">Manage your Paystack API keys</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('profile.updatePaystackKeys') }}" method="POST">
                        @csrf
                        <div class="space-y-6">

                            <div>
                                <label class="mb-1 block text-sm font-medium">Paystack Public Key</label>
                                <div class="relative">
                                    <input type="password" id="public_key" name="paystack_public_key"
                                        value="{{ old('paystack_public_key', auth()->user()->paystack_public_key) }}"
                                        class="w-full rounded-lg border px-4 py-3 pr-12" readonly>

                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                        onclick="toggleKey('public_key', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium">Paystack Secret Key</label>
                                <div class="relative">
                                    <input type="password" id="secret_key" name="paystack_secret_key"
                                        value="{{ old('paystack_secret_key', auth()->user()->paystack_secret_key) }}"
                                        class="w-full rounded-lg border px-4 py-3 pr-12" readonly>

                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                        onclick="toggleKey('secret_key', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end">
                            <button class="bg-primary-500 hover:bg-primary-600 rounded-lg px-6 py-3 text-white">
                                Update Keys
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script>
        function toggleKey(id, button) {
            const input = document.getElementById(id);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                input.removeAttribute('readonly');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                input.setAttribute('readonly', true);
            }
        }

        function previewLogo(input) {
            const file = input.files[0];
            const preview = document.getElementById('logoPreview');
            const uploadBtn = document.getElementById('uploadBtn');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                uploadBtn.classList.remove('hidden');
            }
        }
    </script>
@endsection
