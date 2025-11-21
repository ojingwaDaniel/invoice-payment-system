@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Customers</h1>
                        <p class="mt-2 text-gray-600">Manage your customer database</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Export Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                <i class="fas fa-download text-gray-500"></i>
                                Export
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-pdf mr-3 text-red-500"></i>
                                        Export as PDF
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-excel mr-3 text-green-500"></i>
                                        Export as Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Add Customer Button -->
                        <a href="{{ route('customer.create') }}"
                           class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-plus"></i>
                            Add Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Customers -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-blue-100 p-3">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $customers->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Customers -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-green-100 p-3">
                                <i class="fas fa-user-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_customers'] ?? $customers->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Invoices -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-cyan-100 p-3">
                                <i class="fas fa-file-invoice text-cyan-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_invoices'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- New This Month -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-orange-100 p-3">
                                <i class="fas fa-calendar-plus text-orange-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">New This Month</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['new_this_month'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-medium text-gray-900">All Customers</h3>
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                {{ $customers->total() }} Total
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Search -->
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <form action="{{ route('customer.index') }}" method="GET">
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           placeholder="Search customers..."
                                           class="block w-64 rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                           onchange="this.form.submit()">
                                    @foreach (request()->except(['search', 'page']) as $k => $v)
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endforeach
                                </form>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                        class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-sort"></i>
                                    Sort
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>

                                <div x-show="open"
                                     @click.away="open = false"
                                     class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="{{ route('customer.index', ['sort' => 'name']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'name' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Name (A-Z)
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'name_desc']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'name_desc' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Name (Z-A)
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'latest']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'latest' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Latest First
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'oldest']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'oldest' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Oldest First
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="mx-6 mt-4 rounded-lg bg-green-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                            <button type="button" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-6 mt-4 rounded-lg bg-red-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                            <button type="button" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    <input type="checkbox"
                                           id="select-all"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Phone
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Address
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Invoices
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Joined Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <input type="checkbox"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                       class="hover:text-blue-600">
                                                        {{ $customer->name }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">ID: {{ $customer->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="mailto:{{ $customer->email }}"
                                           class="text-blue-600 hover:text-blue-900 text-sm">
                                            {{ $customer->email }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        <a href="tel:{{ $customer->phone }}"
                                           class="hover:text-blue-600">
                                            {{ $customer->phone }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $customer->address }}">
                                            {{ $customer->address }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if($customer->invoices_count > 0)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                {{ $customer->invoices_count }} {{ Str::plural('invoice', $customer->invoices_count) }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-500">No invoices</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        {{ $customer->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('customer.show', $customer->id) }}"
                                               class="text-blue-600 hover:text-blue-900 rounded-lg p-2 hover:bg-blue-50"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('customer.edit', $customer->id) }}"
                                               class="text-gray-600 hover:text-gray-900 rounded-lg p-2 hover:bg-gray-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $customer->id }})"
                                                    class="text-red-600 hover:text-red-900 rounded-lg p-2 hover:bg-red-50"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-users text-4xl mb-4 opacity-20"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">No customers found</p>
                                            <p class="text-sm text-gray-600 mb-4">Get started by adding your first customer</p>
                                            <a href="{{ route('customer.create') }}"
                                               class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                                <i class="fas fa-plus mr-2"></i>
                                                Add First Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $customers->firstItem() }}</span> to
                                <span class="font-medium">{{ $customers->lastItem() }}</span> of
                                <span class="font-medium">{{ $customers->total() }}</span> results
                            </div>
                            <div class="flex items-center gap-2">
                                {{ $customers->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Delete Customer</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete this customer? This action cannot be undone.</p>
                                <p class="text-sm text-red-600 mt-2 font-medium">
                                    <strong>Warning:</strong> All related invoices will also be deleted.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Delete Customer
                        </button>
                    </form>
                    <button type="button"
                            onclick="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(customerId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/customer/${customerId}`;
            document.getElementById('delete_modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('delete_modal').classList.add('hidden');
        }

        // Select all checkboxes
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Close modal when clicking outside
        document.getElementById('delete_modal').addEventListener('click', function(e) {
            if (e.target.id === 'delete_modal') {
                closeModal();
            }
        });

        // Auto-submit search on input (with debounce)
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        }
    </script>

    <!-- Alpine.js for dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Customers</h1>
                        <p class="mt-2 text-gray-600">Manage your customer database</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Export Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                <i class="fas fa-download text-gray-500"></i>
                                Export
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-pdf mr-3 text-red-500"></i>
                                        Export as PDF
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-excel mr-3 text-green-500"></i>
                                        Export as Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Add Customer Button -->
                        <a href="{{ route('customer.create') }}"
                           class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-plus"></i>
                            Add Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Customers -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-blue-100 p-3">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $customers->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Customers -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-green-100 p-3">
                                <i class="fas fa-user-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_customers'] ?? $customers->total() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Invoices -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-cyan-100 p-3">
                                <i class="fas fa-file-invoice text-cyan-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_invoices'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- New This Month -->
                <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-lg bg-orange-100 p-3">
                                <i class="fas fa-calendar-plus text-orange-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">New This Month</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['new_this_month'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-medium text-gray-900">All Customers</h3>
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                {{ $customers->total() }} Total
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Search -->
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <form action="{{ route('customer.index') }}" method="GET">
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           placeholder="Search customers..."
                                           class="block w-64 rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                           onchange="this.form.submit()">
                                    @foreach (request()->except(['search', 'page']) as $k => $v)
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endforeach
                                </form>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                        class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-sort"></i>
                                    Sort
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>

                                <div x-show="open"
                                     @click.away="open = false"
                                     class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="{{ route('customer.index', ['sort' => 'name']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'name' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Name (A-Z)
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'name_desc']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'name_desc' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Name (Z-A)
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'latest']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'latest' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Latest First
                                        </a>
                                        <a href="{{ route('customer.index', ['sort' => 'oldest']) }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'oldest' ? 'bg-blue-50 text-blue-600' : '' }}">
                                            Oldest First
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="mx-6 mt-4 rounded-lg bg-green-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                            <button type="button" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-6 mt-4 rounded-lg bg-red-50 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                            <button type="button" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    <input type="checkbox"
                                           id="select-all"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Phone
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Address
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Invoices
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Joined Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <input type="checkbox"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                       class="hover:text-blue-600">
                                                        {{ $customer->name }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">ID: {{ $customer->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="mailto:{{ $customer->email }}"
                                           class="text-blue-600 hover:text-blue-900 text-sm">
                                            {{ $customer->email }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        <a href="tel:{{ $customer->phone }}"
                                           class="hover:text-blue-600">
                                            {{ $customer->phone }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $customer->address }}">
                                            {{ $customer->address }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if($customer->invoices_count > 0)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                {{ $customer->invoices_count }} {{ Str::plural('invoice', $customer->invoices_count) }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-500">No invoices</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        {{ $customer->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('customer.show', $customer->id) }}"
                                               class="text-blue-600 hover:text-blue-900 rounded-lg p-2 hover:bg-blue-50"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('customer.edit', $customer->id) }}"
                                               class="text-gray-600 hover:text-gray-900 rounded-lg p-2 hover:bg-gray-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $customer->id }})"
                                                    class="text-red-600 hover:text-red-900 rounded-lg p-2 hover:bg-red-50"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-users text-4xl mb-4 opacity-20"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">No customers found</p>
                                            <p class="text-sm text-gray-600 mb-4">Get started by adding your first customer</p>
                                            <a href="{{ route('customer.create') }}"
                                               class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                                <i class="fas fa-plus mr-2"></i>
                                                Add First Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $customers->firstItem() }}</span> to
                                <span class="font-medium">{{ $customers->lastItem() }}</span> of
                                <span class="font-medium">{{ $customers->total() }}</span> results
                            </div>
                            <div class="flex items-center gap-2">
                                {{ $customers->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Delete Customer</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete this customer? This action cannot be undone.</p>
                                <p class="text-sm text-red-600 mt-2 font-medium">
                                    <strong>Warning:</strong> All related invoices will also be deleted.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Delete Customer
                        </button>
                    </form>
                    <button type="button"
                            onclick="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(customerId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/customer/${customerId}`;
            document.getElementById('delete_modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('delete_modal').classList.add('hidden');
        }

        // Select all checkboxes
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Close modal when clicking outside
        document.getElementById('delete_modal').addEventListener('click', function(e) {
            if (e.target.id === 'delete_modal') {
                closeModal();
            }
        });

        // Auto-submit search on input (with debounce)
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        }
    </script>

    <!-- Alpine.js for dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
