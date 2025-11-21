@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Customer Details</h1>
                        <p class="mt-2 text-gray-600">View customer information and invoices</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('customer.index') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </a>
                        <a href="{{ route('customer.edit', $customer->id) }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-edit"></i>
                            Edit Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4">
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

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
                <!-- Customer Info Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Profile Card -->
                    <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200 text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-blue-100">
                            <span class="text-2xl font-bold text-blue-600">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $customer->name }}</h3>
                        <p class="text-gray-500 mb-4">Customer ID: #{{ $customer->id }}</p>

                        <div class="space-y-3">
                            <a href="mailto:{{ $customer->email }}"
                               class="flex w-full items-center justify-center gap-2 rounded-lg border border-blue-300 bg-white px-4 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-50">
                                <i class="fas fa-envelope"></i>
                                Send Email
                            </a>
                            <a href="tel:{{ $customer->phone }}"
                               class="flex w-full items-center justify-center gap-2 rounded-lg border border-blue-300 bg-white px-4 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-50">
                                <i class="fas fa-phone"></i>
                                Call Customer
                            </a>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                                <p class="text-gray-900">{{ $customer->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Phone</p>
                                <p class="text-gray-900">{{ $customer->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Address</p>
                                <p class="text-gray-900">{{ $customer->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 p-6 border border-blue-200">
                        <h4 class="text-lg font-medium text-blue-900 mb-4">Customer Stats</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-blue-700">Total Invoices</span>
                                <span class="text-lg font-bold text-blue-900">{{ $customer->invoices->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-blue-700">Member Since</span>
                                <span class="text-sm font-medium text-blue-900">{{ $customer->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-blue-700">Last Updated</span>
                                <span class="text-sm font-medium text-blue-900">{{ $customer->updated_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Invoices Section -->
                    <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                                <h4 class="text-lg font-medium text-gray-900">Recent Invoices</h4>
                                <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                                   class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                    <i class="fas fa-plus"></i>
                                    New Invoice
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($customer->invoices->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Invoice #
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Date
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Amount
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Status
                                                </th>
                                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach($customer->invoices as $invoice)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="whitespace-nowrap px-4 py-4">
                                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                                           class="font-medium text-blue-600 hover:text-blue-900">
                                                            {{ $invoice->invoice_number }}
                                                        </a>
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900">
                                                        {{ $invoice->issue_date->format('d M, Y') }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                                        ₦{{ number_format($invoice->total_amount, 2) }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-4">
                                                        @if($invoice->status === 'paid')
                                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                                <i class="fas fa-check-circle mr-1"></i>
                                                                Paid
                                                            </span>
                                                        @elseif($invoice->status === 'partial')
                                                            <span class="inline-flex items-center rounded-full bg-cyan-100 px-2.5 py-0.5 text-xs font-medium text-cyan-800">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                Partial
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                                Unpaid
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                                           class="inline-flex items-center rounded-lg bg-blue-100 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-200">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                        <i class="fas fa-file-invoice text-2xl text-gray-400"></i>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">No invoices yet</h4>
                                    <p class="text-gray-600 mb-4">Create the first invoice for this customer</p>
                                    <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        <i class="fas fa-plus"></i>
                                        Create First Invoice
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Joined Date -->
                        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="rounded-lg bg-blue-100 p-3">
                                    <i class="fas fa-calendar-plus text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Joined Date</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $customer->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                            <div class="flex items-center">
                                <div class="rounded-lg bg-green-100 p-3">
                                    <i class="fas fa-calendar-check text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $customer->updated_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="rounded-xl bg-gradient-to-r from-gray-50 to-white p-6 border border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Customer Summary</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="text-center">
                                <div class="rounded-lg bg-blue-50 p-3 inline-block">
                                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Total Invoices</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $customer->invoices->count() }}</p>
                            </div>
                            <div class="text-center">
                                <div class="rounded-lg bg-green-50 p-3 inline-block">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Paid Invoices</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $customer->invoices->where('status', 'paid')->count() }}
                                </p>
                            </div>
                            <div class="text-center">
                                <div class="rounded-lg bg-yellow-50 p-3 inline-block">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Pending Invoices</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $customer->invoices->where('status', 'unpaid')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-lift {
            transition: all 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>

    <script>
        // Add any interactive functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // You can add customer-specific interactions here
            console.log('Customer details page loaded');
        });
    </script>
@endsection
