<!-- Mini Sidebar -->
<div class="w-20 bg-gradient-to-b from-gray-900 to-gray-800 flex flex-col items-center py-6 space-y-8 shadow-xl z-40 sidebar-container">
    <!-- Logo -->
    <div class="flex items-center justify-center w-12 h-12 bg-primary-500 rounded-xl shadow-glow">
        <span class="text-white font-bold text-lg">Bp</span>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-col items-center space-y-6 flex-1">
        <!-- Quick Add -->
        <div class="relative group">
            <button class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg hover:shadow-glow transition-all duration-300 hover:scale-105">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Icons -->
        <div class="flex flex-col items-center space-y-6">
            <a href="{{ route('dashboard') }}" class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-gray-700 transition-colors duration-200 group relative">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">Dashboard</span>
            </a>

            <a href="{{ route('product.index') }}" class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-gray-700 transition-colors duration-200 group relative">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">Products</span>
            </a>

            <a href="{{ route('invoice.index') }}" class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-gray-700 transition-colors duration-200 group relative">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">Invoices</span>
            </a>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="flex flex-col items-center space-y-4">
        <a href="#" class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-gray-700 transition-colors duration-200 group relative">
            <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">Settings</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-red-500/10 transition-colors duration-200 group relative">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Sidebar -->
<div class="flex flex-col w-80 bg-white border-r border-gray-200 shadow-sm sidebar-transition fixed lg:relative inset-y-0 left-0 transform h-full sidebar-container"
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
     x-cloak>

    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-100">
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ config('app.name', 'BusinessPro') }}</h1>
            <p class="text-sm text-gray-500">Admin Dashboard</p>
        </div>
        <button @click="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors duration-200 lg:hidden">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Search -->
    <div class="p-6 border-b border-gray-100">
        <div class="relative">
            <input type="text"
                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                   placeholder="Search...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto">
        <div class="p-6">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li class="mb-6">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Main</span>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                                @if(request()->routeIs('dashboard'))
                                    <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">Active</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory & Sales -->
                <li class="mb-6">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Inventory & Sales</span>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="{{ route('product.index') }}"
                               class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('product.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('product.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="font-medium">Products</span>
                            </a>
                        </li>

                        <!-- Invoices Dropdown -->
                        <li>
                            <a href="javascript:void(0);"
                               @click="toggleSubmenu('invoices')"
                               class="flex items-center justify-between px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('invoice.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('invoice.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium">Invoices</span>
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{ 'rotate-180': openSubmenu === 'invoices' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <ul x-show="openSubmenu === 'invoices'"
                                x-transition
                                class="ml-8 mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('invoice.index') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                        All Invoices
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('invoice.create') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                        Create Invoice
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Customers Dropdown -->
                        <li>
                            <a href="javascript:void(0);"
                               @click="toggleSubmenu('customers')"
                               class="flex items-center justify-between px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('customer.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('customer.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium">Customers</span>
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{ 'rotate-180': openSubmenu === 'customers' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <ul x-show="openSubmenu === 'customers'"
                                x-transition
                                class="ml-8 mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('customer.index') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                        All Customers
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.create') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                        Add Customer
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- User Profile -->
    <div class="p-6 border-t border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'user@example.com' }}</p>
            </div>
            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>