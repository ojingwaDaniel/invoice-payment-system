@extends('layouts.app')
@section('content')
    <!-- Add Tailwind CSS and dependencies -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Prevent zoom on mobile */
        input, select, textarea {
            font-size: 16px !important;
        }
    </style>

    <div class="min-h-screen bg-gray-50">
        <!-- Start Content -->
        <div class="container mx-auto px-3 py-4">

            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4 gap-3">
                <div>
                    <h5 class="text-lg font-bold text-gray-900">Invoices</h5>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <!-- Export Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm flex items-center gap-1 transition-colors"
                                @click="open = !open">
                            <i class="fas fa-file-export text-xs"></i>
                            Export
                        </button>
                        <div class="absolute right-0 mt-1 w-40 bg-white rounded shadow-lg border border-gray-200 z-10 py-1"
                             x-show="open" x-transition>
                            <a href="javascript:void(0);" class="flex items-center px-3 py-2 text-sm hover:bg-gray-50 transition-colors">
                                <i class="fas fa-file-pdf text-red-500 mr-2 text-xs"></i>
                                Export as PDF
                            </a>
                            <a href="javascript:void(0);" class="flex items-center px-3 py-2 text-sm hover:bg-gray-50 transition-colors">
                                <i class="fas fa-file-excel text-green-500 mr-2 text-xs"></i>
                                Export as Excel
                            </a>
                        </div>
                    </div>

                    <!-- Add Invoice Button -->
                    <a href="{{ route('invoice.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm flex items-center gap-1 transition-colors shadow-sm">
                        <i class="fas fa-circle-plus text-xs"></i>
                        Add Invoice
                    </a>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                <!-- Total Invoices -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center mb-3">
                        <div>
                            <p class="text-gray-600 text-xs truncate">Total Invoices</p>
                            <h6 class="text-xl font-bold text-gray-900">{{ $invoices->total() }}</h6>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1 mb-2">
                        <div class="bg-blue-600 h-1 rounded-full" style="width: 100%"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs flex items-center">
                            Total count
                        </p>
                    </div>
                </div>

                <!-- Paid -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center mb-3">
                        <div>
                            <p class="text-gray-600 text-xs truncate">Paid</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['paid_amount'], 2) }}</h6>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1 mb-2">
                        <div class="bg-green-500 h-1 rounded-full" style="width: {{ $stats['paid_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs flex items-center">
                            <span class="text-green-500 flex items-center mr-1">
                                {{ $stats['paid_count'] }} invoices
                            </span>
                            ({{ number_format($stats['paid_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>

                <!-- Unpaid -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center mb-3">
                        <div>
                            <p class="text-gray-600 text-xs truncate">Unpaid</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['unpaid_amount'], 2) }}</h6>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1 mb-2">
                        <div class="bg-yellow-500 h-1 rounded-full" style="width: {{ $stats['unpaid_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs flex items-center">
                            <span class="text-yellow-500 flex items-center mr-1">
                                {{ $stats['unpaid_count'] }} invoices
                            </span>
                            ({{ number_format($stats['unpaid_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>

                <!-- Partial -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center mb-3">
                        <div>
                            <p class="text-gray-600 text-xs truncate">Partial</p>
                            <h6 class="text-xl font-bold text-gray-900">₦{{ number_format($stats['partial_amount'], 2) }}</h6>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1 mb-2">
                        <div class="bg-cyan-500 h-1 rounded-full" style="width: {{ $stats['partial_percentage'] }}%"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs flex items-center">
                            <span class="text-cyan-500 flex items-center mr-1">
                                {{ $stats['partial_count'] }} invoices
                            </span>
                            ({{ number_format($stats['partial_percentage'], 1) }}%)
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Statistics -->

            <!-- Invoices Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Header -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                        <h5 class="flex items-center text-base font-semibold text-gray-900">
                            All Invoices
                            <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full ml-2">
                                {{ $invoices->total() }} Total
                            </span>
                        </h5>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text"
                                       class="pl-8 pr-3 py-2 border border-gray-300 rounded text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-48"
                                       placeholder="Search invoices...">
                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-xs"></i>
                                </div>
                            </div>

                            <!-- Status Filter Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm flex items-center gap-1 transition-colors"
                                        @click="open = !open">
                                    Filter Status
                                </button>
                                <div class="absolute right-0 mt-1 w-40 bg-white rounded shadow-lg border border-gray-200 z-10 py-1"
                                     x-show="open" x-transition>
                                    <a href="{{ route('invoice.index') }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">All</a>
                                    <a href="{{ route('invoice.index', ['status' => 'paid']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Paid</a>
                                    <a href="{{ route('invoice.index', ['status' => 'unpaid']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Unpaid</a>
                                    <a href="{{ route('invoice.index', ['status' => 'partial']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Partial</a>
                                </div>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm flex items-center gap-1 transition-colors"
                                        @click="open = !open">
                                    <span class="flex items-center mr-1">Sort By: </span> Latest
                                </button>
                                <div class="absolute right-0 mt-1 w-48 bg-white rounded shadow-lg border border-gray-200 z-10 py-1"
                                     x-show="open" x-transition>
                                    <a href="{{ route('invoice.index', ['sort' => 'latest']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Latest First</a>
                                    <a href="{{ route('invoice.index', ['sort' => 'oldest']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Oldest First</a>
                                    <a href="{{ route('invoice.index', ['sort' => 'amount_high']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Amount (High to Low)</a>
                                    <a href="{{ route('invoice.index', ['sort' => 'amount_low']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Amount (Low to High)</a>
                                    <a href="{{ route('invoice.index', ['sort' => 'due_date']) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 transition-colors">Due Date</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                <div class="px-4 pt-3">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded text-sm mb-3 flex justify-between items-center">
                            {{ session('success') }}
                            <button type="button" class="text-green-700 hover:text-green-900">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded text-sm mb-3 flex justify-between items-center">
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
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 scale-75">
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">VAT</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($invoices as $invoice)
                                @php
                                    $balance = $invoice->total_amount - $invoice->paid;
                                    $isOverdue = $invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 scale-75">
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                            {{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-blue-600 font-medium text-xs">
                                                    {{ strtoupper(substr($invoice->customer->name ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 text-sm">
                                                    <a href="{{ route('invoice.show', $invoice->id) }}" class="hover:text-blue-600">
                                                        {{ $invoice->customer->name ?? 'Unknown' }}
                                                    </a>
                                                </div>
                                                @if($invoice->customer && $invoice->customer->email)
                                                    <div class="text-gray-500 text-xs truncate" style="max-width: 120px;">{{ $invoice->customer->email }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 text-sm">
                                        {{ $invoice->issue_date ? $invoice->issue_date->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($invoice->due_date)
                                            <div class="{{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-600' }} text-sm">
                                                {{ $invoice->due_date->format('d M, Y') }}
                                                @if($isOverdue)
                                                    <div class="bg-red-100 text-red-800 text-xs px-1 py-0.5 rounded text-xs mt-0.5">Overdue</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 text-sm">
                                        ₦{{ number_format($invoice->total_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 text-sm">
                                        ₦{{ number_format($invoice->vat_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-green-600 font-medium text-sm">
                                        ₦{{ number_format($invoice->paid, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-sm {{ $balance > 0 ? 'text-red-600' : 'text-gray-600' }}">
                                        ₦{{ number_format($balance, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($invoice->status === 'paid')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                                <i class="fas fa-check-circle text-xs"></i>
                                                Paid
                                            </span>
                                        @elseif($invoice->status === 'partial')
                                            <span class="bg-cyan-100 text-cyan-800 text-xs px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                                <i class="fas fa-clock text-xs"></i>
                                                Partial
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                                <i class="fas fa-exclamation-circle text-xs"></i>
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                class="text-blue-600 hover:text-blue-800 transition-colors"
                                                title="View">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                class="text-gray-600 hover:text-gray-800 transition-colors"
                                                title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $invoice->id }})"
                                                class="text-red-600 hover:text-red-800 transition-colors"
                                                title="Delete">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-8 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-file-invoice text-2xl mb-2 block"></i>
                                            <p class="text-sm mb-3">No invoices found</p>
                                            <a href="{{ route('invoice.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm inline-flex items-center gap-1 transition-colors">
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
                @if($invoices->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
                        <div class="text-gray-500">
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} entries
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
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="delete_modal" style="display: none;">
        <div class="relative top-20 mx-auto p-4 border w-80 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                </div>
                <div class="mt-2 text-center">
                    <h3 class="text-base font-medium text-gray-900">Confirm Delete</h3>
                    <div class="mt-2 px-2 py-2">
                        <p class="text-xs text-gray-500">Are you sure you want to delete this invoice? This action cannot be undone.</p>
                    </div>
                </div>
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="items-center px-2 py-2 flex gap-2 justify-center">
                        <button type="button"
                                onclick="closeModal()"
                                class="px-3 py-1.5 bg-gray-300 text-gray-700 rounded text-sm hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-3 py-1.5 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
