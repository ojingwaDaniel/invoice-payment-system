@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Animated Header -->
        <div class="mb-12 animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-4xl font-bold text-transparent">
                        Account Settings
                    </h1>
                    <p class="mt-2 text-lg text-slate-600">Manage your profile and preferences with ease</p>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Toast -->
        @if (session('success'))
        <div class="mb-8 animate-slide-down">
            <div class="relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-teal-50 p-5 shadow-lg backdrop-blur-sm">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/10 to-teal-400/10"></div>
                <div class="relative flex items-center">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500 shadow-lg">
                        <i class="fas fa-check text-xl text-white"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="font-semibold text-emerald-900">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="ml-4 text-emerald-600 hover:text-emerald-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

            <!-- Enhanced Sidebar -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="sticky top-8 space-y-6">
                    
                    <!-- Profile Card -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl transition-all duration-300 hover:shadow-2xl">
                        <!-- Gradient Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-indigo-500/5 to-purple-500/5"></div>
                        
                        <div class="relative">
                            <!-- Avatar Section -->
                            <div class="mb-6 flex justify-center">
                                <div class="relative">
                                    <!-- Main Avatar -->
                                    <div class="relative h-32 w-32 overflow-hidden rounded-3xl bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 p-1 shadow-2xl transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                                        <div class="flex h-full w-full items-center justify-center overflow-hidden rounded-3xl bg-white">
                                            @if (auth()->user()->logo_path)
                                                <img src="{{ asset('storage/' . auth()->user()->logo_path) }}" 
                                                     alt="Logo"
                                                     class="h-full w-full object-cover" 
                                                     id="currentLogo">
                                            @else
                                                <span class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 bg-clip-text text-4xl font-bold text-transparent" id="logoInitials">
                                                    {{ substr(auth()->user()->company_name ?: auth()->user()->name, 0, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Upload Button -->
                                    <form id="logoUploadForm" action="{{ route('profile.uploadLogo') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <label for="logo" class="absolute -bottom-2 -right-2 flex h-12 w-12 cursor-pointer items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-xl transition-all duration-300 hover:scale-110 hover:shadow-2xl">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                        <input type="file" id="logo" name="logo" accept="image/*" class="hidden" onchange="document.getElementById('logoUploadForm').submit();">
                                    </form>

                                    <!-- Status Indicator -->
                                    <div class="absolute -top-1 -right-1 h-5 w-5 rounded-full border-4 border-white bg-emerald-500 shadow-lg"></div>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-slate-900">{{ auth()->user()->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ auth()->user()->company_name ?: 'No company set' }}</p>
                                <p class="mt-2 text-xs font-medium text-blue-600">{{ auth()->user()->email }}</p>
                            </div>

                            <!-- Stats -->
                            <div class="mt-6 grid grid-cols-3 gap-4 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50 p-4">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-slate-900">98%</p>
                                    <p class="text-xs text-slate-600">Complete</p>
                                </div>
                                <div class="border-x border-slate-200 text-center">
                                    <p class="text-2xl font-bold text-slate-900">24</p>
                                    <p class="text-xs text-slate-600">Projects</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-slate-900">5.0</p>
                                    <p class="text-xs text-slate-600">Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-2 rounded-3xl bg-white p-4 shadow-xl">
                        <a href="#profile" onclick="showSection('profile')" class="nav-link active group flex items-center rounded-2xl px-4 py-3.5 font-medium text-slate-700 transition-all duration-300">
                            <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Profile Info</span>
                            <i class="fas fa-chevron-right ml-auto opacity-0 transition-opacity duration-300 group-hover:opacity-100"></i>
                        </a>
                        
                        <a href="#paystack" onclick="showSection('paystack')" class="nav-link group flex items-center rounded-2xl px-4 py-3.5 font-medium text-slate-700 transition-all duration-300 hover:bg-slate-50">
                            <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-blue-500 group-hover:to-indigo-600 group-hover:text-white group-hover:shadow-lg">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span>Payment Keys</span>
                            <i class="fas fa-chevron-right ml-auto opacity-0 transition-opacity duration-300 group-hover:opacity-100"></i>
                        </a>
                        
                        
                        
                    </nav>

                    <!-- Quick Actions -->
                    <div class="rounded-3xl bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white shadow-xl">
                        <h4 class="mb-4 font-semibold">Need Help?</h4>
                        <p class="mb-4 text-sm text-blue-100">Contact our support team for assistance</p>
                        <button class="w-full rounded-xl bg-white py-2.5 font-medium text-blue-600 transition-all hover:shadow-lg">
                            <i class="fas fa-headset mr-2"></i>Contact Support
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-8 xl:col-span-9">
                <div class="space-y-6">

                    <!-- Profile Information Section -->
                    <div id="profile-section" class="section-content overflow-hidden rounded-3xl bg-white shadow-xl transition-all duration-300">
                        <!-- Header -->
                        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Profile Information</h2>
                                    <p class="mt-1 text-sm text-slate-600">Update your personal details and information</p>
                                </div>
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg">
                                    <i class="fas fa-user-edit text-xl text-white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="p-8">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-user mr-2 text-blue-500"></i>Full Name
                                        </label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 transition-all duration-300 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    </div>

                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                                        </label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 transition-all duration-300 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    </div>

                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-building mr-2 text-blue-500"></i>Company Name
                                        </label>
                                        <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                                            class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 transition-all duration-300 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    </div>

                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-phone mr-2 text-blue-500"></i>Phone Number
                                        </label>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                            class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 transition-all duration-300 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    </div>

                                    <div class="group md:col-span-2">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>Address
                                        </label>
                                        <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                            class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 transition-all duration-300 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    </div>
                                </div>

                                <div class="mt-8 flex items-center justify-between rounded-2xl bg-gradient-to-r from-slate-50 to-blue-50 p-6">
                                    <div class="flex items-center text-sm text-slate-600">
                                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                        <span>All changes are saved securely</span>
                                    </div>
                                    <button type="submit" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                        <span class="relative z-10 flex items-center">
                                            <i class="fas fa-save mr-2"></i>Save Changes
                                        </span>
                                        <div class="absolute inset-0 -z-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Paystack Integration Section -->
                    <div id="paystack-section" class="section-content hidden overflow-hidden rounded-3xl bg-white shadow-xl transition-all duration-300">
                        <!-- Header -->
                        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Paystack Integration</h2>
                                    <p class="mt-1 text-sm text-slate-600">Securely manage your payment gateway credentials</p>
                                </div>
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg">
                                    <i class="fas fa-lock text-xl text-white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="p-8">
                            <form action="{{ route('profile.updatePaystackKeys') }}" method="POST">
                                @csrf
                                <div class="space-y-6">

                                    <!-- Public Key -->
                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-key mr-2 text-green-500"></i>Paystack Public Key
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="public_key" name="paystack_public_key"
                                                value="{{ old('paystack_public_key', auth()->user()->paystack_public_key) }}"
                                                class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 pr-12 font-mono text-sm transition-all duration-300 focus:border-green-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-green-500/10" readonly>
                                            <button type="button" onclick="toggleKey('public_key', this)"
                                                class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-lg text-slate-400 transition-all hover:bg-slate-100 hover:text-slate-600">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Secret Key -->
                                    <div class="group">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            <i class="fas fa-shield-alt mr-2 text-green-500"></i>Paystack Secret Key
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="secret_key" name="paystack_secret_key"
                                                value="{{ old('paystack_secret_key', auth()->user()->paystack_secret_key) }}"
                                                class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3.5 pr-12 font-mono text-sm transition-all duration-300 focus:border-green-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-green-500/10" readonly>
                                            <button type="button" onclick="toggleKey('secret_key', this)"
                                                class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-lg text-slate-400 transition-all hover:bg-slate-100 hover:text-slate-600">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Security Notice -->
                                    <div class="rounded-2xl border-2 border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 p-6">
                                        <div class="flex items-start">
                                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="font-semibold text-amber-900">Security Notice</h4>
                                                <p class="mt-1 text-sm text-amber-700">Keep your API keys confidential. Never share them publicly or commit them to version control.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-center justify-between rounded-2xl bg-gradient-to-r from-slate-50 to-green-50 p-6">
                                    <div class="flex items-center text-sm text-slate-600">
                                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                        <span>Keys are encrypted and stored securely</span>
                                    </div>
                                    <button type="submit" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                        <span class="relative z-10 flex items-center">
                                            <i class="fas fa-check mr-2"></i>Update Keys
                                        </span>
                                        <div class="absolute inset-0 -z-0 bg-gradient-to-r from-emerald-600 to-teal-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.4s ease-out;
}

.nav-link.active {
    background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
    color: white;
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
}

.nav-link.active .bg-slate-100 {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
}

.nav-link.active i.fa-chevron-right {
    opacity: 1;
}
</style>

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

function showSection(section) {
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(el => {
        el.classList.add('hidden');
    });

    // Remove active state from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        const icon = link.querySelector('.rounded-xl');
        if (icon) {
            icon.classList.remove('bg-gradient-to-br', 'from-blue-500', 'to-indigo-600', 'text-white', 'shadow-lg');
            icon.classList.add('bg-slate-100', 'text-slate-600');
        }
    });

    // Show selected section
    const sectionEl = document.getElementById(section + '-section');
    if (sectionEl) {
        sectionEl.classList.remove('hidden');
    }

    // Add active state to clicked nav link
    event.currentTarget.classList.add('active');
    const activeIcon = event.currentTarget.querySelector('.rounded-xl');
    if (activeIcon) {
        activeIcon.classList.remove('bg-slate-100', 'text-slate-600');
        activeIcon.classList.add('bg-gradient-to-br', 'from-blue-500', 'to-indigo-600', 'text-white', 'shadow-lg');
    }
}
</script>
@endsection