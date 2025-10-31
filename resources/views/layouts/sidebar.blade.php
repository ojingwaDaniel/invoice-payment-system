<!-- Mini Sidebar -->
<div
    class="sidebar-container z-40 flex w-20 flex-col items-center space-y-8 bg-gradient-to-b from-gray-900 to-gray-800 py-6 shadow-xl">
    <!-- Logo -->
    <div class="bg-primary-500 shadow-glow flex h-12 w-12 items-center justify-center rounded-xl">
        <span class="text-lg font-bold text-white">Inv</span>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-1 flex-col items-center space-y-6">



        <!-- Navigation Icons -->
        <div class="flex flex-col items-center space-y-6">
            <a href="{{ route('dashboard') }}"
                class="group relative flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-200 hover:bg-gray-700">
                <svg class="h-6 w-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span
                    class="absolute left-full z-50 ml-3 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">Dashboard</span>
            </a>

            <a href="{{ route('product.index') }}"
                class="group relative flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-200 hover:bg-gray-700">
                <svg class="h-6 w-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span
                    class="absolute left-full z-50 ml-3 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">Products</span>
            </a>

            <a href="{{ route('invoice.index') }}"
                class="group relative flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-200 hover:bg-gray-700">
                <svg class="h-6 w-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span
                    class="absolute left-full z-50 ml-3 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">Invoices</span>
            </a>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="flex flex-col items-center space-y-4">
        <a href="{{ route('profile.edit') }}"
            class="group relative flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-200 hover:bg-gray-700">
            <svg class="h-6 w-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span
                class="absolute left-full z-50 ml-3 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">Settings</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group relative flex h-12 w-12 items-center justify-center rounded-xl transition-colors duration-200 hover:bg-red-500/10">
                <svg class="h-6 w-6 text-gray-400 group-hover:text-red-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span
                    class="absolute left-full z-50 ml-3 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Sidebar -->
<div class="sidebar-transition sidebar-container fixed inset-y-0 left-0 flex h-full w-80 transform flex-col border-r border-gray-200 bg-white shadow-sm lg:relative"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" x-cloak>

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-100 p-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-500">Admin Dashboard</p>
        </div>
        <button @click="toggleSidebar()"
            class="flex h-10 w-10 items-center justify-center rounded-lg transition-colors duration-200 hover:bg-gray-100 lg:hidden">
            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Search -->
    <div class="border-b border-gray-100 p-6">
        <div class="relative">
            <input type="text"
                class="focus:ring-primary-500 w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 transition-all duration-200 focus:border-transparent focus:ring-2"
                placeholder="Search...">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
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
                    <span class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Main</span>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="{{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }} group flex items-center rounded-xl px-3 py-3 transition-all duration-200">
                                <svg class="{{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }} mr-3 h-5 w-5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                                @if (request()->routeIs('dashboard'))
                                    <span
                                        class="bg-primary-100 text-primary-800 ml-auto rounded-full px-2 py-1 text-xs">Active</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory & Sales -->
                <li class="mb-6">
                    <span class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Inventory &
                        Sales</span>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <a href="javascript:void(0);" @click="toggleSubmenu('products')"
                                class="{{ request()->routeIs('product.*') || request()->routeIs('category.*') || request()->routeIs('unit.*')
                                    ? 'bg-primary-50 text-primary-600 shadow-sm'
                                    : 'text-gray-700 hover:bg-gray-50' }} group flex items-center justify-between rounded-xl px-3 py-3 transition-all duration-200">
                                <div class="flex items-center">
                                    <svg class="{{ request()->routeIs('product.*') || request()->routeIs('category.*') || request()->routeIs('unit.*')
                                        ? 'text-primary-600'
                                        : 'text-gray-400 group-hover:text-gray-600' }} mr-3 h-5 w-5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="font-medium">Products/Services</span>
                                </div>
                                <svg class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': openSubmenu === 'products' }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>

                            <!-- Dropdown Items -->
                            <ul x-show="openSubmenu === 'products'" x-transition class="ml-8 mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('product.index') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        Inventory
                                    </a>
                                </li>


                                <li>
                                    <a href="{{ route('category.index') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        Categories
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('unit.index') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        Units
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Invoices Dropdown -->
                        <li>
                            <a href="javascript:void(0);" @click="toggleSubmenu('invoices')"
                                class="{{ request()->routeIs('invoice.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }} group flex items-center justify-between rounded-xl px-3 py-3 transition-all duration-200">
                                <div class="flex items-center">
                                    <svg class="{{ request()->routeIs('invoice.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }} mr-3 h-5 w-5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Invoices</span>
                                </div>
                                <svg class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': openSubmenu === 'invoices' }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <ul x-show="openSubmenu === 'invoices'" x-transition class="ml-8 mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('invoice.index') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        All Invoices
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('invoice.create') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        Create Invoice
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Customers Dropdown -->
                        <li>
                            <a href="javascript:void(0);" @click="toggleSubmenu('customers')"
                                class="{{ request()->routeIs('customer.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-700 hover:bg-gray-50' }} group flex items-center justify-between rounded-xl px-3 py-3 transition-all duration-200">
                                <div class="flex items-center">
                                    <svg class="{{ request()->routeIs('customer.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' }} mr-3 h-5 w-5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Customers</span>
                                </div>
                                <svg class="h-4 w-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': openSubmenu === 'customers' }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <ul x-show="openSubmenu === 'customers'" x-transition class="ml-8 mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('customer.index') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
                                        All Customers
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.create') }}"
                                        class="block rounded-lg px-3 py-2 text-sm text-gray-600 transition-colors duration-200 hover:bg-gray-50 hover:text-gray-800">
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
    <div class="border-t border-gray-100 p-6">
        <div class="flex items-center space-x-3">
            <div
                class="from-primary-500 to-primary-600 flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r font-semibold text-white">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900">{{ Auth::user()->company_name ?? 'User' }}</p>
                <p class="truncate text-xs text-gray-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
            </div>
            <button
                class="flex h-8 w-8 items-center justify-center rounded-lg transition-colors duration-200 hover:bg-gray-100">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>
