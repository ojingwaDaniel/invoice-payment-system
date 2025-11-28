@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <!-- Page Header -->
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-600">Welcome back! Here's your business overview</p>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Create New Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 font-medium text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md"
                            type="button">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Create New</span>
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-72 rounded-lg border border-gray-200 bg-white shadow-lg">
                            <div class="py-2">
                                <a href="{{ route('invoice.create') }}"
                                    class="flex items-start px-4 py-3 transition-colors duration-150 hover:bg-gray-50">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-100">
                                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Invoice</p>
                                        <p class="text-sm text-gray-500">Create new invoice</p>
                                    </div>
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('customer.create') }}"
                                    class="flex items-start px-4 py-3 transition-colors duration-150 hover:bg-gray-50">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-red-100">
                                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Customer</p>
                                        <p class="text-sm text-gray-500">Add Customer</p>
                                    </div>
                                </a>
                                <a href="{{ route('category.create') }}"
                                    class="flex items-start px-4 py-3 transition-colors duration-150 hover:bg-gray-50">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-green-100">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Category</p>
                                        <p class="text-sm text-gray-500">Add Category</p>
                                    </div>
                                </a>
                                <a href="{{ route('unit.create') }}"
                                    class="flex items-start px-4 py-3 transition-colors duration-150 hover:bg-gray-50">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-yellow-100">
                                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">Unit</p>
                                        <p class="text-sm text-gray-500">Add Unit</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 shadow-xl">
                <div class="px-6 py-8 sm:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <h2 class="mb-2 text-2xl font-bold text-white">Good Morning, {{ Auth::user()->name }}! 👋</h2>
                            <p class="mb-4 text-indigo-100">
                                You have <span class="font-semibold text-white">{{ $pendingInvoices }}</span> pending
                                invoices saved to
                                draft that need to be sent to customers
                            </p>
                            <div class="flex flex-wrap items-center gap-4 text-white">
                                <div class="flex items-center">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm">{{ \Carbon\Carbon::now()->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row - Extra Wide Cards for Large Numbers -->
            <div class="mb-8 grid grid-cols-1 gap-8 xl:grid-cols-3">
                <!-- Overview Card - Wider with more spacing -->
                <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-lg xl:col-span-1">
                    <div class="mb-8 flex items-center">
                        <div class="mr-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="text-lg font-bold text-gray-900">Business Overview</h6>
                            <p class="mt-1 text-sm text-gray-500">Key metrics at a glance</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-blue-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                                    <h5 class="text-xl font-bold text-gray-900">{{ number_format($totalInvoices) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-green-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-green-100">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Customers</p>
                                    <h5 class="text-xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-yellow-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-100">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Amount Due</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($totalAmountDue, 2) }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sales Analytics Card - Wider with more spacing -->
                <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-lg xl:col-span-1">
                    <div class="mb-8 flex items-center">
                        <div class="mr-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="text-lg font-bold text-gray-900">Sales Analytics</h6>
                            <p class="mt-1 text-sm text-gray-500">Revenue performance metrics</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-blue-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Sales</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($totalSales, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-green-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-green-100">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Amount Received</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($received, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-yellow-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-100">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Outstanding</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($outstanding, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-red-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-red-100">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Overdue Amount</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($overdue, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Statistics Card - Wider with more spacing -->
                <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-lg xl:col-span-1">
                    <div class="mb-8 flex items-center">
                        <div class="mr-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="text-lg font-bold text-gray-900">Invoice Statistics</h6>
                            <p class="mt-1 text-sm text-gray-500">Payment performance insights</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-blue-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Invoiced</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($invoiced, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-green-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-green-100">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Amount Received</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($received, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-yellow-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-100">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Outstanding</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($outstanding, 2) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-colors hover:bg-red-50">
                            <div class="flex items-center">
                                <div class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl bg-red-100">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Overdue</p>
                                    <h5 class="text-xl font-bold text-gray-900">₦{{ number_format($overdue, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Highlighted Cards Row -->
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    class="overflow-hidden rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 shadow-sm transition-all duration-300 hover:shadow-md">
                    <div class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-2 text-sm text-gray-600">Total Products</p>
                                <h3 class="mb-2 text-3xl font-bold text-gray-900">{{ $totalProducts }}</h3>
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800">
                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    +45
                                </span>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-indigo-600 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('product.index') }}"
                            class="block w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors duration-200 hover:bg-indigo-700">
                            View Inventory
                        </a>
                    </div>
                </div>

                <div
                    class="overflow-hidden rounded-xl bg-gradient-to-br from-pink-50 to-red-50 shadow-sm transition-all duration-300 hover:shadow-md">
                    <div class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-2 text-sm text-gray-600">Total Sales</p>
                                <h3 class="mb-2 text-3xl font-bold text-gray-900">{{ $totalSalesCount }}</h3>
                                <span
                                    class="{{ $salesGrowthCount >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold">
                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($salesGrowthCount >= 0)
                                            <path fill-rule="evenodd"
                                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                    {{ $salesGrowthCount >= 0 ? '+' : '' }}{{ $salesGrowthCount }}%
                                </span>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-600 shadow-lg">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('invoice.index') }}"
                            class="block w-full rounded-lg bg-red-600 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors duration-200 hover:bg-red-700">
                            View Invoices
                        </a>
                    </div>
                </div>

            </div>

            <!-- Top Customers -->
            <div class="mb-6 rounded-xl bg-white shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="px-6 py-6">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Top Customers</h3>
                        <a href="{{ route('customer.index') }}"
                            class="text-sm font-medium text-indigo-600 transition-colors duration-200 hover:text-indigo-700">
                            View All →
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="divide-y divide-gray-100">
                                @forelse($topCustomers as $customer)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50">
                                        <td class="py-4 pr-4">
                                            <div class="flex items-center">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">{{ $customer->invoices_count }}
                                                        Invoices</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <p class="mb-1 text-xs text-gray-500">Total Paid</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                ₦{{ number_format($customer->invoices_sum_paid, 2) }}</p>
                                        </td>
                                        <td class="py-4 pl-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                                                    class="rounded-lg bg-gray-100 p-2 transition-colors duration-200 hover:bg-gray-200"
                                                    title="New Invoice">
                                                    <svg class="h-4 w-4 text-gray-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('customer.show', $customer->id) }}"
                                                    class="rounded-lg bg-gray-100 p-2 transition-colors duration-200 hover:bg-gray-200"
                                                    title="View Customer Details">
                                                    <svg class="h-4 w-4 text-gray-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-gray-500">
                                            No customers found yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('customer.index') }}"
                        class="mt-4 block w-full rounded-lg bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-200">
                        View All Customers
                    </a>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="mb-6 rounded-xl bg-white shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="px-6 py-6">
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Recent Invoices</h3>
                            <p class="mt-1 text-sm text-gray-500">Latest invoice transactions</p>
                        </div>
                        <a href="{{ route('invoice.index') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-indigo-700">
                            View All Invoices
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        ID</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Customer</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Created On</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Amount</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Paid</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Payment Mode</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Due Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($recentInvoices as $invoice)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                class="inline-flex items-center rounded-md bg-indigo-100 px-2.5 py-1 text-xs font-semibold text-indigo-700 transition-colors duration-200 hover:bg-indigo-200">
                                                {{ $invoice->invoice_number ?? 'INV' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <div class="flex items-center">
                                                <div class="mr-3 h-8 w-8 flex-shrink-0 overflow-hidden rounded-full">
                                                    <img src="{{ $invoice->customer->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($invoice->customer->name ?? 'N/A') }}"
                                                        alt="{{ $invoice->customer->name ?? 'N/A' }}"
                                                        class="h-full w-full object-cover">
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $invoice->customer->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                            {{ $invoice->created_at->format('d M Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-900">
                                            ₦{{ number_format($invoice->total_amount, 2) }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-green-600">
                                            ₦{{ number_format($invoice->amount_paid ?? 0, 2) }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span
                                                class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                {{ ucfirst($invoice->payment_mode ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500">
                                            {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            @if ($invoice->status === 'paid')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Paid</span>
                                            @elseif ($invoice->status === 'pending')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-700">Pending</span>
                                            @elseif ($invoice->status === 'overdue')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Overdue</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ ucfirst($invoice->status ?? 'Unknown') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                            No recent invoices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Transactions & Sales Stats -->
            <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent Transactions -->
                <!-- Recent Transactions -->
                <div class="lg:col-span-2">
                    <div class="h-full rounded-xl bg-white shadow-sm transition-shadow duration-300 hover:shadow-md">
                        <div class="px-6 py-6">
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                                <a href="{{ route('invoice.index') }}"
                                    class="text-sm font-medium text-indigo-600 transition-colors duration-200 hover:text-indigo-700">
                                    View All →
                                </a>
                            </div>

                            @if ($recentTransactions->isEmpty())
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg class="mb-4 h-16 w-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-center text-gray-500">No transactions yet</p>
                                    <a href="{{ route('invoice.create') }}"
                                        class="mt-4 inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition-colors hover:bg-indigo-700">
                                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create First Invoice
                                    </a>
                                </div>
                            @else
                                <div class="space-y-6">
                                    @foreach ($recentTransactions as $period => $transactions)
                                        <div>
                                            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                {{ $period }}
                                            </p>
                                            <div class="space-y-3">
                                                @foreach ($transactions as $transaction)
                                                    <div
                                                        class="flex items-center justify-between rounded-xl bg-gray-50 p-4 transition-all duration-200 hover:bg-gray-100 hover:shadow-sm">
                                                        <div class="flex min-w-0 flex-1 items-center">
                                                            <div
                                                                class="{{ $transaction->status === 'paid' ? 'bg-green-100' : 'bg-indigo-100' }} mr-4 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg">
                                                                <svg class="{{ $transaction->status === 'paid' ? 'text-green-600' : 'text-indigo-600' }} h-5 w-5"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    @if ($transaction->status === 'paid')
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 13l4 4L19 7" />
                                                                    @else
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                                    @endif
                                                                </svg>
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <p class="truncate text-sm font-semibold text-gray-900">
                                                                    {{ $transaction->customer->name ?? 'N/A' }}
                                                                </p>
                                                                <div class="mt-1 flex items-center gap-2">
                                                                    <a href="{{ route('invoice.show', $transaction->id) }}"
                                                                        class="text-xs text-indigo-600 hover:text-indigo-800 hover:underline">
                                                                        #{{ $transaction->invoice_number }}
                                                                    </a>
                                                                    @if ($transaction->payment_method)
                                                                        <span
                                                                            class="inline-flex items-center rounded bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-700">
                                                                            {{ ucfirst($transaction->payment_method) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4 flex flex-col items-end">
                                                            <span
                                                                class="{{ $transaction->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} whitespace-nowrap rounded-lg px-3 py-1 text-sm font-bold">
                                                                {{ $transaction->status === 'paid' ? '+' : '' }}₦{{ number_format($transaction->paid, 2) }}
                                                            </span>
                                                            <span class="mt-1 text-xs text-gray-500">
                                                                {{ $transaction->updated_at->format('h:i A') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sales Statistics -->
                <div class="lg:col-span-1">
                    <div class="rounded-xl bg-white shadow-sm transition-shadow duration-300 hover:shadow-md">
                        <div class="px-6 py-6">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <p class="mb-1 text-sm text-gray-600">Total Invoice Income</p>
                                    <h3 class="text-3xl font-bold text-gray-900">₦{{ number_format($received, 2) }}</h3>
                                </div>
                                <div class="text-right">
                                    <div class="mb-1 flex items-center font-semibold text-green-600">
                                        <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        30.2%
                                    </div>
                                    <p class="text-xs text-gray-500">vs Last Week</p>
                                </div>
                            </div>
                            <div id="invoice_income"
                                class="mt-4 flex h-32 items-center justify-center rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50">
                                <p class="text-sm text-gray-400">Chart Placeholder</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
