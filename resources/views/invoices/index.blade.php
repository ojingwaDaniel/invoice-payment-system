@extends('layouts.app')
@section('content')
    <!-- Add Tailwind CSS and dependencies -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Prevent zoom on mobile */
        input,
        select,
        textarea {
            font-size: 16px !important;
        }

        /* Ensure dropdowns work properly */
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen bg-gray-50">
        <!-- Start Content -->
        <div class="container mx-auto px-3 py-4">

            <!-- Page Header -->
            <div class="mb-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h5 class="text-lg font-bold text-gray-900">Invoices</h5>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <!-- Export Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button type="button"
                            class="flex items-center gap-1 rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-50"
                            @click="open = !open">
                            <i class="fas fa-file-export text-xs"></i>
                            Export
                        </button>
                        <div class="absolute right-0 z-10 mt-1 w-40 rounded border border-gray-200 bg-white py-1 shadow-lg"
                            x-show="open" x-transition style="display: none;">
                            <a href="javascript:void(0);"
                                class="flex items-center px-3 py-2 text-sm transition-colors hover:bg-gray-50">
                                <i class="fas fa-file-pdf mr-2 text-xs text-red-500"></i>
                                Export as PDF
                            </a>
                            <a href="javascript:void(0);"
                                class="flex items-center px-3 py-2 text-sm transition-colors hover:bg-gray-50">
                                <i class="fas fa-file-excel mr-2 text-xs text-green-500"></i>
                                Export as Excel
                            </a>
                        </div>
                    </div>

                    <!-- Add Invoice Button -->
                    <a href="{{ route('invoice.create') }}"
                        class="flex items-center gap-1 rounded bg-blue-600 px-3 py-2 text-sm text-white shadow-sm transition-colors hover:bg-blue-700">
                        <i class="fas fa-circle-plus text-xs"></i>
                        Add Invoice
                    </a>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Statistics Cards -->
            <div class="mb-4 grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Invoices -->
                <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center">
                        <div>
                            <p class="truncate text-xs text-gray-600">Total Invoices</p>
                            <h6 class="text-xl font-bold text-gray-900">{{ $invoices->total() }}</h6>
                        </div>
                    </div>
                    <div class="mb-2 h-1 w-full rounded-full bg-gray-200">
                        <div class="h-1 rounded-full bg-blue-600" style="width: 100%"></div>
                    </div>
                    <div>
                        <p class="flex items-center text-xs text-gray-500">
                            Total count
                        </p>
                    </div>
                </div>

                <!-- Paid -->
                <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center">
                        <div>
                            <p class="truncate text-xs text-gray-600">Paid</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['paid_amount'], 2) }}</h6>
                        </div>
                    </div>
                    <div class="mb-2 h-1 w-full rounded-full bg-gray-200">
                        <div class="h-1 rounded-full bg-green-500" style="width: {{ $stats['paid_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="flex items-center text-xs text-gray-500">
                            <span class="mr-1 flex items-center text-green-500">
                                {{ $stats['paid_count'] }} invoices
                            </span>
                            ({{ number_format($stats['paid_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>

                <!-- Unpaid -->
                <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center">
                        <div>
                            <p class="truncate text-xs text-gray-600">Unpaid</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['unpaid_amount'], 2) }}
                            </h6>
                        </div>
                    </div>
                    <div class="mb-2 h-1 w-full rounded-full bg-gray-200">
                        <div class="h-1 rounded-full bg-yellow-500" style="width: {{ $stats['unpaid_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="flex items-center text-xs text-gray-500">
                            <span class="mr-1 flex items-center text-yellow-500">
                                {{ $stats['unpaid_count'] }} invoices
                            </span>
                            ({{ number_format($stats['unpaid_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>

                <!-- Partial -->
                <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="mb-3 flex items-center">
                        <div>
                            <p class="truncate text-xs text-gray-600">Partial</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['partial_amount'], 2) }}
                            </h6>
                        </div>
                    </div>
                    <div class="mb-2 h-1 w-full rounded-full bg-gray-200">
                        <div class="h-1 rounded-full bg-cyan-500" style="width: {{ $stats['partial_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="flex items-center text-xs text-gray-500">
                            <span class="mr-1 flex items-center text-cyan-500">
                                {{ $stats['partial_count'] }} invoices
                            </span>
                            ({{ number_format($stats['partial_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Statistics -->

            <!-- Filters Section - Fixed Overflow and Layout -->
            <div class="mb-4">
                <div class="flex flex-wrap items-center gap-3">

                    <!-- Search -->
                    <form action="{{ route('invoice.index') }}" method="GET" class="relative flex-shrink-0">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-48 rounded border border-gray-300 py-2 pl-8 pr-10 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            placeholder="Search..." onchange="this.form.submit()">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                            <i class="fas fa-search text-xs text-gray-400"></i>
                        </div>
                        <button type="submit"
                            class="absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>

                        @foreach (request()->except(['search', 'page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                    </form>

                    <!-- Customer Filter with Selected Name -->
                    <div class="relative flex-shrink-0" x-data="{ open: false }" @click.outside="open=false">
                        <button type="button" @click="open=!open"
                            class="{{ request('customer_id') ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-300 bg-white text-gray-700' }} flex items-center gap-2 rounded border px-3 py-2 text-sm hover:bg-gray-50">

                            <!-- Optional: You can change icon color dynamically -->
                            <i
                                class="fas fa-user {{ request('customer_id') ? 'text-blue-600' : 'text-gray-700' }} text-xs"></i>

                            @php
                                $selectedCustomer = request('customer_id')
                                    ? $customers->firstWhere('id', request('customer_id'))
                                    : null;
                            @endphp
                            <span class="max-w-[150px] truncate">
                                {{ $selectedCustomer ? $selectedCustomer->name : 'Customer' }}
                            </span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 mt-1 max-h-60 w-56 overflow-y-auto rounded border border-gray-200 bg-white py-1 shadow-xl"
                            style="display: none;">

                            <!-- All Customers -->
                            <a href="{{ request()->fullUrlWithQuery(['customer_id' => null, 'page' => null]) }}"
                                class="{{ !request('customer_id') ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                <i class="fas fa-users mr-2 text-xs"></i>
                                All Customers
                            </a>

                            @foreach ($customers as $customer)
                                <a href="{{ request()->fullUrlWithQuery(['customer_id' => $customer->id, 'page' => null]) }}"
                                    class="{{ request('customer_id') == $customer->id ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                    {{ $customer->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Date Range -->
                    <form action="{{ route('invoice.index') }}" method="GET" class="flex flex-shrink-0 gap-2">

                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-36 rounded border border-gray-300 px-2 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-36 rounded border border-gray-300 px-2 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                        @foreach (request()->except(['from', 'to', 'page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach

                        <button type="submit" class="rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700">
                            Apply
                        </button>
                    </form>

                    <!-- Status Filter with Selected Status -->
                    <div class="relative flex-shrink-0" x-data="{ open: false }" @click.outside="open = false">
                        <button type="button"
                            class="{{ request('status') ? 'border-blue-500 bg-blue-50' : '' }} flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            @click="open = !open">
                            <i class="fas fa-filter text-xs"></i>
                            @if (request('status'))
                                <span>{{ ucfirst(request('status')) }}</span>
                            @else
                                <span>Status</span>
                            @endif
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 z-50 mt-1 w-40 rounded border border-gray-200 bg-white py-1 shadow-xl"
                            style="display: none;">
                            <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}"
                                class="{{ !request('status') ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                All
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'paid', 'page' => null]) }}"
                                class="{{ request('status') == 'paid' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Paid
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'unpaid', 'page' => null]) }}"
                                class="{{ request('status') == 'unpaid' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Unpaid
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'partial', 'page' => null]) }}"
                                class="{{ request('status') == 'partial' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Partial
                            </a>
                        </div>
                    </div>

                    <!-- Sort with Selected Option -->
                    <div class="relative flex-shrink-0" x-data="{ open: false }" @click.outside="open = false">
                        <button type="button"
                            class="flex items-center gap-2 rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            @click="open = !open">
                            <i class="fas fa-sort text-xs"></i>
                            Sort
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-1 w-48 rounded border border-gray-200 bg-white py-1 shadow-xl"
                            style="display: none;">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest', 'page' => null]) }}"
                                class="{{ request('sort', 'latest') == 'latest' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Latest
                            </a>

                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest', 'page' => null]) }}"
                                class="{{ request('sort') == 'oldest' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Oldest
                            </a>

                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount_high', 'page' => null]) }}"
                                class="{{ request('sort') == 'amount_high' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Amount High → Low
                            </a>

                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount_low', 'page' => null]) }}"
                                class="{{ request('sort') == 'amount_low' ? 'bg-blue-50 text-blue-600' : '' }} block px-3 py-2 text-sm hover:bg-gray-50">
                                Amount Low → High
                            </a>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    @if (request()->anyFilled(['search', 'customer_id', 'from', 'to', 'status', 'sort']))
                        <a href="{{ route('invoice.index') }}"
                            class="flex flex-shrink-0 items-center gap-1 rounded bg-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-300">
                            <i class="fas fa-times text-xs"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Invoices Table -->
            <div class="overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm">
                <!-- Table Header -->
                <div class="border-b border-gray-200 p-4">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                        <h5 class="flex items-center text-base font-semibold text-gray-900">
                            All Invoices
                            <span class="ml-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-700">
                                {{ $invoices->total() }} Total
                            </span>
                        </h5>

                    </div>
                </div>

                <!-- Alerts -->
                <div class="px-4 pt-3">
                    @if (session('success'))
                        <div
                            class="mb-3 flex items-center justify-between rounded border border-green-200 bg-green-50 px-3 py-2 text-sm text-green-700">
                            {{ session('success') }}
                            <button type="button" class="text-green-700 hover:text-green-900">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-3 flex items-center justify-between rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                            {{ session('error') }}
                            <button type="button" class="text-red-700 hover:text-red-900">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    <input type="checkbox"
                                        class="scale-75 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Invoice #</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Customer</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Issue Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Due Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Total</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    VAT</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Paid</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Balance</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Sent</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($invoices as $invoice)
                                @php
                                    $balance = $invoice->total_amount - $invoice->paid;
                                    $isOverdue =
                                        $invoice->due_date &&
                                        $invoice->due_date->isPast() &&
                                        $invoice->status !== 'paid';
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <input type="checkbox"
                                            class="scale-75 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                            {{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <div class="flex items-center">
                                            <div
                                                class="mr-2 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100">
                                                <span class="text-xs font-medium text-blue-600">
                                                    {{ strtoupper(substr($invoice->customer->name ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('invoice.show', $invoice->id) }}"
                                                        class="hover:text-blue-600">
                                                        {{ $invoice->customer->name ?? 'Unknown' }}
                                                    </a>
                                                </div>
                                                @if ($invoice->customer && $invoice->customer->email)
                                                    <div class="truncate text-xs text-gray-500" style="max-width: 120px;">
                                                        {{ $invoice->customer->email }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                        {{ $invoice->issue_date ? $invoice->issue_date->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        @if ($invoice->due_date)
                                            <div
                                                class="{{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-600' }} text-sm">
                                                {{ $invoice->due_date->format('d M, Y') }}
                                                @if ($isOverdue)
                                                    <div
                                                        class="mt-0.5 rounded bg-red-100 px-1 py-0.5 text-xs text-xs text-red-800">
                                                        Overdue</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">
                                        ₦{{ number_format($invoice->total_amount, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">
                                        ₦{{ number_format($invoice->vat_amount, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-green-600">
                                        ₦{{ number_format($invoice->paid, 2) }}
                                    </td>
                                    <td
                                        class="{{ $balance > 0 ? 'text-red-600' : 'text-gray-600' }} whitespace-nowrap px-4 py-3 text-sm font-medium">
                                        ₦{{ number_format($balance, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        @if ($invoice->status === 'paid')
                                            <span
                                                class="flex w-fit items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">
                                                <i class="fas fa-check-circle text-xs"></i>
                                                Paid
                                            </span>
                                        @elseif($invoice->status === 'partial')
                                            <span
                                                class="flex w-fit items-center gap-1 rounded-full bg-cyan-100 px-2 py-1 text-xs text-cyan-800">
                                                <i class="fas fa-clock text-xs"></i>
                                                Partial
                                            </span>
                                        @else
                                            <span
                                                class="flex w-fit items-center gap-1 rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800">
                                                <i class="fas fa-exclamation-circle text-xs"></i>
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        @if ($invoice->is_sent)
                                            <span class="rounded bg-green-100 px-2 py-1 text-xs text-green-800">Sent</span>
                                        @else
                                            <span class="rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-800">Not
                                                Sent</span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                class="text-blue-600 transition-colors hover:text-blue-800"
                                                title="View">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                class="text-gray-600 transition-colors hover:text-gray-800"
                                                title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $invoice->id }})"
                                                class="text-red-600 transition-colors hover:text-red-800" title="Delete">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="px-4 py-8 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-file-invoice mb-2 block text-2xl"></i>
                                            <p class="mb-3 text-sm">No invoices found</p>
                                            <a href="{{ route('invoice.create') }}"
                                                class="inline-flex items-center gap-1 rounded bg-blue-600 px-3 py-1.5 text-sm text-white transition-colors hover:bg-blue-700">
                                                <i class="fas fa-plus text-xs"></i>
                                                Create First Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($invoices->hasPages())
                    <div
                        class="flex flex-col gap-3 border-t border-gray-200 px-4 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-gray-500">
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                            {{ $invoices->total() }} entries
                        </div>
                        <div class="text-xs">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                @endif
            </div>
            <!-- End Table -->

        </div>
        <!-- End Content -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="fixed inset-0 z-50 h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50" id="delete_modal"
        style="display: none;">
        <div class="relative top-20 mx-auto w-80 rounded-md border bg-white p-4 shadow-lg">
            <div class="mt-3">
                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-sm text-red-600"></i>
                </div>
                <div class="mt-2 text-center">
                    <h3 class="text-base font-medium text-gray-900">Confirm Delete</h3>
                    <div class="mt-2 px-2 py-2">
                        <p class="text-xs text-gray-500">Are you sure you want to delete this invoice? This action cannot
                            be undone.</p>
                    </div>
                </div>
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-center gap-2 px-2 py-2">
                        <button type="button" onclick="closeModal()"
                            class="rounded bg-gray-300 px-3 py-1.5 text-sm text-gray-700 transition-colors hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded bg-red-600 px-3 py-1.5 text-sm text-white transition-colors hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Hide Alpine.js elements before initialization */
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        function confirmDelete(invoiceId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/invoice/${invoiceId}`;
            document.getElementById('delete_modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('delete_modal').style.display = 'none';
        }

        // Select all checkboxes
        document.querySelector('thead input[type="checkbox"]')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('delete_modal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
@endsection
