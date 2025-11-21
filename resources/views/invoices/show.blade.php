@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Flash Messages -->
            @if (session('success'))
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

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
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

            <!-- Invoice Card -->
            <div class="rounded-xl bg-white shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8">

                    <!-- Header Section -->
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-1">INVOICE</h1>
                            <p class="text-gray-600">#{{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="text-right">
                            <div class="mb-3">
                                @if ($invoice->status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        PAID
                                    </span>
                                @elseif($invoice->status === 'partial')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800">
                                        <i class="fas fa-clock mr-2"></i>
                                        PARTIALLY PAID
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-sm font-medium text-red-800">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        UNPAID
                                    </span>
                                @endif
                            </div>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</p>
                                @if ($invoice->due_date)
                                    <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bill To Section -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Bill To</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $invoice->customer->name }}</h4>
                                <p class="text-gray-600 mb-1">{{ $invoice->customer->email }}</p>
                                @if ($invoice->customer->phone)
                                    <p class="text-gray-600 mb-1">{{ $invoice->customer->phone }}</p>
                                @endif
                                @if ($invoice->customer->address)
                                    <p class="text-gray-600">{{ $invoice->customer->address }}</p>
                                @endif
                            </div>
                        </div>

                        @if ($invoice->user)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">From</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $invoice->user->company_name }}</h4>
                                    <p class="text-gray-600 mb-1">{{ $invoice->user->email }}</p>
                                    <p class="text-gray-600 mb-1">{{ $invoice->user->phone }}</p>
                                    <p class="text-gray-600">{{ $invoice->user->address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Items Table -->
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Items</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Product/Services
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500" style="width: 100px;">
                                            Qty
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500" style="width: 120px;">
                                            Unit Price
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500" style="width: 100px;">
                                            Discount
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500" style="width: 140px;">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($invoice->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4">
                                                <div class="font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}</div>
                                                @if ($item->unit)
                                                    <div class="text-sm text-gray-500 mt-1">Unit: {{ $item->unit }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center text-gray-900">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-4 text-right text-gray-900">
                                                {{ $invoice->currency }} {{ number_format($item->rate, 2) }}
                                            </td>
                                            <td class="px-4 py-4 text-right text-gray-900">
                                                @if ($item->discount > 0)
                                                    {{ $invoice->currency }} {{ number_format($item->discount, 2) }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-right font-medium text-gray-900">
                                                {{ $invoice->currency }} {{ number_format($item->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totals Section -->
                    <div class="flex justify-end mb-8">
                        <div class="w-full md:w-80">
                            @php
                                // Calculate subtotal (sum of all item amounts)
                                $subtotal = $invoice->items->sum('amount');

                                // Calculate after discount
                                $afterDiscount = $subtotal - ($invoice->discount ?? 0);

                                // Calculate VAT (tax_rate from invoice)
                                $taxRate = $invoice->tax_rate ?? 0;
                                $vatAmount = ($afterDiscount * $taxRate) / 100;

                                // Total amount
                                $totalAmount = $afterDiscount + $vatAmount;
                            @endphp

                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-medium text-gray-900">
                                            {{ $invoice->currency }} {{ number_format($subtotal, 2) }}
                                        </span>
                                    </div>

                                    @if ($invoice->discount > 0)
                                        <div class="flex justify-between items-center text-red-600">
                                            <span>Discount:</span>
                                            <span class="font-medium">-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($invoice->discount > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">After Discount:</span>
                                            <span class="font-medium text-gray-900">
                                                {{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center text-green-600">
                                        <span>VAT ({{ $taxRate }}%):</span>
                                        <span class="font-medium">{{ $invoice->currency }} {{ number_format($invoice->vat_amount, 2) }}</span>
                                    </div>

                                    <hr class="my-3">

                                    @if ($invoice->paid > 0)
                                        <div class="flex justify-between items-center text-green-600">
                                            <span>Paid:</span>
                                            <span class="font-medium">{{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($invoice->total_amount - $invoice->paid > 0)
                                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                            <span class="text-lg font-bold text-red-600">Amount Due:</span>
                                            <span class="text-lg font-bold text-red-600">
                                                {{ $invoice->currency }} {{ number_format($invoice->total_amount - $invoice->paid, 2) }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                            <span class="text-lg font-bold text-green-600">Total Paid:</span>
                                            <span class="text-lg font-bold text-green-600">
                                                {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if ($invoice->notes)
                        <div class="border-t border-gray-200 pt-6 mb-6">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Notes</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-line">{{ $invoice->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Method -->
                    @if ($invoice->payment_method)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600">
                                <strong>Payment Method:</strong> {{ $invoice->payment_method }}
                            </p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-wrap gap-3">
                            @if ($invoice->status !== 'paid')
                                <form method="POST" action="{{ route('invoice.send', $invoice) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                                        <i class="fas fa-envelope"></i>
                                        Send to Customer
                                    </button>
                                </form>
                            @endif

                            @if ($invoice->status !== 'paid')
                                <a href="{{ route('invoice.pay', $invoice->id) }}"
                                   class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">
                                    <i class="fas fa-credit-card"></i>
                                    Pay Invoice
                                </a>
                            @endif

                            <a href="{{ route('invoice.download', $invoice) }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </a>

                            <a href="{{ route('invoice.edit', $invoice) }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-white px-4 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-50">
                                <i class="fas fa-edit"></i>
                                Edit Invoice
                            </a>

                            <a href="{{ route('invoice.index') }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-arrow-left"></i>
                                Back to Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-gray-50 {
                background-color: #f9fafb !important;
            }

            .shadow-lg {
                box-shadow: none !important;
            }

            .border {
                border: 1px solid #e5e7eb !important;
            }
        }
    </style>

    <script>
        // Add print functionality if needed
        function printInvoice() {
            window.print();
        }

        // You can add a print button and attach this function
        document.addEventListener('DOMContentLoaded', function() {
            // Add print button dynamically if needed
            const actionButtons = document.querySelector('.flex-wrap.gap-3');
            const printButton = document.createElement('button');
            printButton.innerHTML = '<i class="fas fa-print"></i> Print Invoice';
            printButton.className = 'inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 no-print';
            printButton.onclick = printInvoice;
            actionButtons.appendChild(printButton);
        });
    </script>
@endsection
