@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Enhanced Back Button -->
            <div class="mb-8">
                <a href="{{ route('branch.index') }}"
                    class="group inline-flex items-center rounded-full bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-200 transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:ring-gray-300">
                    <svg class="mr-2.5 h-4 w-4 transform transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to All Branches
                </a>
            </div>

            <!-- Premium Branch Header -->

            <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 lg:p-8">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $branch->name }}</h1>
                            <p class="mt-2 text-gray-600">Manage invoices and accountants for this branch</p>
                        </div>
                        <div class="flex space-x-4">
                            <button onclick="openModal('create-accountant-modal')"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-emerald-700 hover:to-emerald-800 hover:shadow-xl">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Accountant
                            </button>
                            <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-xl">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Create Invoice
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats Overview Cards -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-indigo-50 p-3">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $branch->invoices->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-emerald-50 p-3">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Paid</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $branch->invoices->where('status', 'paid')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-amber-50 p-3">
                                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $branch->invoices->where('status', 'pending')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-rose-50 p-3">
                                <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Overdue</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $branch->invoices->where('status', 'pending')->filter(function ($invoice) {return $invoice->due_date && $invoice->due_date->isPast();})->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <!-- Invoice Section (2/3 width) -->
                    <div class="lg:col-span-2">
                        <div class="rounded-2xl bg-white shadow-xl">
                            <div class="border-b border-gray-100 px-6 py-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">Recent Invoices</h2>
                                        <p class="mt-1 text-sm text-gray-600">All invoices for this branch</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-900">
                                            Total: {{ $branch->invoices->first()->currency ?? 'USD' }}
                                            {{ number_format($branch->invoices->sum('total_amount'), 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($branch->invoices->count())
                                <div class="overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <!-- Simplified Table Header -->
                                        <div class="min-w-full">
                                            <div
                                                class="grid grid-cols-12 gap-4 border-b border-gray-100 px-6 py-4 text-sm font-semibold text-gray-700">
                                                <div class="col-span-3">Invoice</div>
                                                <div class="col-span-3">Customer</div>
                                                <div class="col-span-2">Amount</div>
                                                <div class="col-span-2">Status</div>
                                                <div class="col-span-2">Actions</div>
                                            </div>
                                        </div>

                                        <!-- Invoice Items -->
                                        <div class="divide-y divide-gray-100">
                                            @foreach ($branch->invoices as $invoice)
                                                <div
                                                    class="group grid grid-cols-12 gap-4 px-6 py-5 transition-all duration-300 hover:bg-gray-50">
                                                    <!-- Invoice Column -->
                                                    <div class="col-span-3">
                                                        <div class="flex items-center">
                                                            <div class="mr-3 rounded-lg bg-indigo-50 p-2">
                                                                <svg class="h-5 w-5 text-indigo-600" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <div class="font-semibold text-gray-900">
                                                                    #{{ $invoice->invoice_number }}</div>
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $invoice->created_at->format('M d, Y') }}</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Customer Column -->
                                                    <div class="col-span-3">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $invoice->customer->name ?? 'N/A' }}</div>
                                                        <div class="truncate text-xs text-gray-500">
                                                            {{ $invoice->customer->email ?? 'No email' }}</div>
                                                        <div class="mt-1 flex items-center text-xs text-gray-500">
                                                            <svg class="mr-1 h-3 w-3" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            {{ $invoice->creator->name ?? ($invoice->user->name ?? 'Unknown') }}
                                                        </div>
                                                    </div>

                                                    <!-- Amount Column -->
                                                    <div class="col-span-2">
                                                        <div class="font-bold text-gray-900">{{ $invoice->currency }}
                                                            {{ number_format($invoice->total_amount, 2) }}</div>
                                                        @if ($invoice->paid > 0)
                                                            <div class="text-xs text-green-600">
                                                                Paid: {{ $invoice->currency }}
                                                                {{ number_format($invoice->paid, 2) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Status Column -->
                                                    <div class="col-span-2">
                                                        @if ($invoice->status === 'paid')
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                                Paid
                                                            </span>
                                                        @elseif($invoice->status === 'pending')
                                                            @if ($invoice->due_date && $invoice->due_date->isPast())
                                                                <span
                                                                    class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800">
                                                                    Overdue
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">
                                                                {{ ucfirst($invoice->status) }}
                                                            </span>
                                                        @endif
                                                        @if ($invoice->due_date)
                                                            <div class="mt-1 text-xs text-gray-500">
                                                                {{ $invoice->due_date->format('M d, Y') }}</div>
                                                        @endif
                                                    </div>

                                                    <!-- Actions Column -->
                                                    <div class="col-span-2">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                                class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-gray-200">
                                                                View
                                                            </a>
                                                            @if ($invoice->status !== 'paid')
                                                                <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                                    class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 transition-all duration-300 hover:bg-blue-100">
                                                                    Edit
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Summary Footer -->
                                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                            <div class="text-sm text-gray-600">
                                                Showing {{ $branch->invoices->count() }} invoices
                                            </div>
                                            <div class="mt-2 flex items-center space-x-6 sm:mt-0">
                                                <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                                    class="inline-flex items-center rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 px-5 py-2.5 font-semibold text-white transition-all duration-300 hover:from-indigo-700 hover:to-indigo-800">
                                                    Create New Invoice
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="py-16 text-center">
                                    <div
                                        class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900">No invoices yet</h3>
                                    <p class="mb-6 text-gray-500">Start by creating your first invoice</p>
                                    <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                        class="inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-xl">
                                        Create First Invoice
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Accountants Section (1/3 width) -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8 rounded-2xl bg-white shadow-xl">
                            <div class="border-b border-gray-100 px-6 py-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">Accountants</h2>
                                        <p class="mt-1 text-sm text-gray-600">Team managing this branch</p>
                                    </div>
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">
                                        {{ $branch->accountants->count() }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                @if ($branch->accountants->count())
                                    <div class="space-y-4">
                                        @foreach ($branch->accountants as $accountant)
                                            <div
                                                class="flex items-center justify-between rounded-xl border border-gray-200 p-4 transition-all duration-300 hover:border-emerald-300 hover:shadow-md">
                                                <div class="flex items-center">
                                                    <div
                                                        class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600">
                                                        <span class="text-sm font-semibold text-white">
                                                            {{ substr($accountant->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $accountant->name }}
                                                        </h3>
                                                        <p class="truncate text-xs text-gray-500">{{ $accountant->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <form
                                                    action="{{ route('branch.accountant.destroy', [$branch->id, $accountant->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Remove {{ $accountant->name }} from this branch?');"
                                                        class="rounded-lg p-2 text-gray-400 transition-colors duration-300 hover:bg-gray-100 hover:text-rose-600">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                            stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-12 text-center">
                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">No accountants</h3>
                                        <p class="mb-6 text-gray-500">Add accountants to manage this branch</p>
                                        <button onclick="openModal('create-accountant-modal')"
                                            class="inline-flex items-center rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-3 font-semibold text-white transition-all duration-300 hover:from-emerald-700 hover:to-emerald-800">
                                            Add Accountant
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Enhanced Create Accountant Modal -->
    <div id="create-accountant-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm"
        onclick="if(event.target === this) closeModal('create-accountant-modal')">
        <div class="relative w-full max-w-lg scale-95 transform opacity-0 transition-all duration-300" id="modal-content">
            <div class="relative overflow-hidden rounded-2xl bg-white shadow-2xl">
                <!-- Modal Header -->
                <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-white/20 p-2.5 backdrop-blur-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Add Accountant</h2>
                                <p class="text-sm text-emerald-100">Add to {{ $branch->name }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal('create-accountant-modal')"
                            class="rounded-lg p-2 text-white/80 transition hover:bg-white/10 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('branch.accountant.store', $branch->id) }}" method="POST" class="px-8 py-8">
                    @csrf

                    <div class="mb-8">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Full Name</label>
                            <span class="text-xs text-gray-500">Required</span>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" required
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3.5 pl-12 pr-4 font-medium text-gray-900 shadow-sm transition-all duration-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:ring-offset-2"
                                placeholder="Enter accountant name">
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Email Address</label>
                            <span class="text-xs text-gray-500">Required</span>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" required
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3.5 pl-12 pr-4 font-medium text-gray-900 shadow-sm transition-all duration-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:ring-offset-2"
                                placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 border-t border-gray-200 pt-8">
                        <button type="button" onclick="closeModal('create-accountant-modal')"
                            class="rounded-xl border border-gray-300 bg-white px-6 py-3 font-medium text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-50 hover:shadow-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-emerald-700 hover:to-emerald-800 hover:shadow-xl">
                            Add Accountant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById('modal-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById('modal-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('create-accountant-modal');
            }
        });
    </script>
@endsection
