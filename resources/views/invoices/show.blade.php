@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="animate-fade-in mb-6 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="animate-fade-in mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Main Invoice Card -->
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">

                <!-- Header Section -->
                <div class="border-b border-gray-200 bg-white px-8 py-8">
                    <div class="flex items-start justify-between">
                        <!-- Left: Company Info -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Invoice</h1>
                            @if ($invoice->user)
                                <p class="mt-2 font-semibold text-gray-900">
                                    {{ $invoice->user->company->name ?? 'Company Name' }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $invoice->user->company->address ?? '15 Hodges Mews, High Wycombe HP12 3JL, United Kingdom' }}
                                </p>
                            @endif
                        </div>

                        <!-- Right: Status Badge & Logo -->
                        <div class="flex items-start gap-6">
                            @if ($invoice->status === 'paid')
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                                    <span class="text-xs font-bold uppercase text-green-700">Paid</span>
                                </div>
                            @elseif($invoice->status === 'partial')
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100">
                                    <span class="text-xs font-bold uppercase text-yellow-700">Partial</span>
                                </div>
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                    <span class="text-xs font-bold uppercase text-red-700">Unpaid</span>
                                </div>
                            @endif

                            @if ($invoice->user && $invoice->user->logo_path)
                                <div class="h-16 w-32">
                                    <img src="{{ asset('storage/' . $invoice->user->logo_path) }}"
                                        alt="{{ $invoice->user->company_name ?? 'Company Logo' }}"
                                        class="h-full w-full object-contain">
                                </div>
                            @else
                                <div
                                    class="flex h-16 w-32 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($invoice->user->company_name ?? 'CO', 0, 2) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Invoice Details Grid -->
                <div class="grid grid-cols-1 gap-8 border-b border-gray-200 bg-gray-50 px-8 py-8 lg:grid-cols-3">

                    <!-- Invoice Details -->
                    <div>
                        <h2 class="mb-4 text-sm font-bold text-gray-900">Invoice Details</h2>
                            <div>
                                <h2 class="mb-4 text-sm font-bold text-gray-900">Invoice Details</h2>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-gray-600">Invoice Number : </span>
                                        <span class="font-semibold text-gray-900">{{ $invoice->invoice_number }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Issued On : </span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $invoice->issue_date->format('d M Y') }}</span>
                                    </div>
                                    @if ($invoice->due_date)
                                        <div>
                                            <span class="text-gray-600">Due Date : </span>
                                            <span
                                                class="font-semibold text-gray-900">{{ $invoice->due_date->format('d M Y') }}</span>
                                        </div>
                                    @endif
                                    @if ($invoice->status !== 'paid' && $invoice->due_date)
                                        @php
                                            $daysUntilDue = \Carbon\Carbon::now()
                                                ->startOfDay()
                                                ->diffInDays($invoice->due_date->startOfDay(), false);
                                        @endphp
                                        <div class="pt-1">
                                            @if ($daysUntilDue > 0)
                                                <span
                                                    class="inline-block rounded bg-red-100 px-2 py-1 text-xs font-bold text-red-700">
                                                    Due in {{ abs($daysUntilDue) }}
                                                    {{ abs($daysUntilDue) == 1 ? 'day' : 'days' }}
                                                </span>
                                            @elseif ($daysUntilDue == 0)
                                                <span
                                                    class="inline-block rounded bg-orange-100 px-2 py-1 text-xs font-bold text-orange-700">
                                                    Due Today
                                                </span>
                                            @else
                                                <span
                                                    class="inline-block rounded bg-red-100 px-2 py-1 text-xs font-bold text-red-700">
                                                    Overdue by {{ abs($daysUntilDue) }}
                                                    {{ abs($daysUntilDue) == 1 ? 'day' : 'days' }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing From -->
                    <div>
                        <h2 class="mb-4 text-sm font-bold text-gray-900">Billing From</h2>
                        @if ($invoice->user)
                            <div class="space-y-2 text-sm">
                                <p class="font-semibold text-gray-900">
                                    {{ $invoice->user->company->name ?? 'Company Name' }}
                                </p>
                                <p class="text-gray-600">{{ $invoice->user->company->address }}</p>

                                <p class="text-gray-600">Phone : {{ $invoice->user->company->phone }}</p>

                                <p class="text-gray-600">Email : {{ $invoice->user->company->email }}</p>

                            </div>
                        @endif
                    </div>

                    <!-- Billing To -->
                    <div>
                        <h2 class="mb-4 text-sm font-bold text-gray-900">Billing To</h2>
                        <div class="flex items-start gap-3">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
                                <span class="text-sm font-bold">{{ substr($invoice->customer->name, 0, 1) }}</span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <p class="font-semibold text-gray-900">{{ $invoice->customer->name }}</p>
                                @if ($invoice->customer->address)
                                    <p class="text-gray-600">{{ $invoice->customer->address }}</p>
                                @endif
                                @if ($invoice->customer->phone)
                                    <p class="text-gray-600">Phone : {{ $invoice->customer->phone }}</p>
                                @endif
                                <p class="text-gray-600">Email : {{ $invoice->customer->email }}</p>
                                @if ($invoice->customer->gst)
                                    <p class="text-gray-600">GST : {{ $invoice->customer->gst }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="px-8 py-8">
                    <h2 class="mb-4 text-sm font-bold text-gray-900">Product / Service Items</h2>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        Product/Service
                                    </th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        Qty
                                    </th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        Unit Price
                                    </th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        Discount
                                    </th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-700">
                                        Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($invoice->items as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}
                                            </div>
                                            @if ($item->unit)
                                                <div class="text-xs text-gray-500">Unit: {{ $item->unit }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm text-gray-900">
                                            {{ $invoice->currency }} {{ number_format($item->rate, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            @if ($item->discount > 0)
                                                <span class="text-red-600">
                                                    -{{ $invoice->currency }} {{ number_format($item->discount, 2) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900">
                                            {{ $invoice->currency }} {{ number_format($item->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="mt-8 flex justify-end">
                        <div class="w-full max-w-sm space-y-3 text-sm">
                            @php
                                $subtotal = $invoice->items->sum('amount');
                                $afterDiscount = $subtotal - ($invoice->discount ?? 0);
                                $taxRate = $invoice->tax_rate ?? 7.5;
                            @endphp

                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $invoice->currency }} {{ number_format($subtotal, 2) }}
                                </span>
                            </div>

                            @if ($invoice->discount > 0)
                                <div class="flex justify-between text-red-600">
                                    <span>Discount:</span>
                                    <span class="font-semibold">
                                        -{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">After Discount:</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between text-green-600">
                                <span>VAT ({{ $taxRate }}%):</span>
                                <span class="font-semibold">
                                    {{ $invoice->currency }} {{ number_format($invoice->vat_amount, 2) }}
                                </span>
                            </div>

                            @if ($invoice->paid > 0)
                                <div class="flex justify-between rounded-lg bg-green-50 px-3 py-2 text-green-700">
                                    <span class="font-semibold">Amount Paid:</span>
                                    <span class="font-bold">
                                        {{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between border-t border-gray-300 pt-3 text-base">
                                @if ($invoice->total_amount - $invoice->paid > 0)
                                    <span class="font-bold text-gray-900">Amount Due:</span>
                                    <span class="font-bold text-red-600">
                                        {{ $invoice->currency }}
                                        {{ number_format($invoice->total_amount - $invoice->paid, 2) }}
                                    </span>
                                @else
                                    <span class="font-bold text-gray-900">Total Paid:</span>
                                    <span class="font-bold text-green-600">
                                        {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Section -->
                <div class="border-t border-gray-200 bg-gray-50 px-8 py-6">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Terms and Notes -->
                        <div>
                            @if ($invoice->payment_method)
                                <h3 class="mb-2 text-sm font-bold text-gray-900">Terms and Conditions</h3>
                                <p class="text-sm text-gray-600">Payment Method: {{ $invoice->payment_method }}</p>
                            @endif

                            @if ($invoice->notes)
                                <h3 class="mb-2 mt-4 text-sm font-bold text-gray-900">Notes</h3>
                                <p class="text-sm text-gray-600">{{ $invoice->notes }}</p>
                            @endif
                        </div>

                        <!-- Signature -->
                        <div class="flex flex-col items-end justify-end">
                            <div class="text-right">
                                <div class="mb-2 h-16 w-32 border-b-2 border-gray-300"></div>
                                @if ($invoice->user && $invoice->user->company_name)
                                    <p class="font-semibold text-gray-900">
                                        {{ $invoice->user->name ?? 'Authorized Signatory' }}</p>
                                    <p class="text-sm text-gray-600">Manager</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Footer -->
                <div class="border-t border-gray-200 bg-white px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            @if ($invoice->user)
                                <p class="font-semibold">{{ $invoice->user->company->name ?? 'Company Name' }}</p>
                                <p>{{ $invoice->user->company->address ?? '15 Hodges Mews, High Wycombe HP12 3JL, United Kingdom' }}
                                </p>
                            @endif
                        </div>
                        @if ($invoice->company && $invoice->company->logo_path)
                            <div class="h-12 w-24">
                                <img src="{{ asset('storage/' . $invoice->user->logo_path) }}"
                                    alt="{{ $invoice->user->company_name ?? 'Company Logo' }}"
                                    class="h-full w-full object-contain">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="no-print mt-6 flex flex-wrap gap-3">
                @if ($invoice->status !== 'paid')
                    <form method="POST" action="{{ route('invoice.send', $invoice) }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700">
                            <i class="fas fa-paper-plane"></i>
                            Send to Customer
                        </button>
                    </form>

                    <a href="{{ route('invoice.pay', $invoice->id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-green-700">
                        <i class="fas fa-credit-card"></i>
                        Pay Invoice
                    </a>

                    <form method="POST" action="{{ route('invoice.markPaid', $invoice) }}" class="inline"
                        onsubmit="return confirm('Are you sure the customer has paid in full?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-green-700">
                            <i class="fas fa-check-circle"></i>
                            Mark as Paid
                        </button>
                    </form>

                    <button type="button"
                        class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-yellow-600"
                        onclick="showPartialPaymentModal()">
                        <i class="fas fa-hourglass-half"></i>
                        Mark as Partial
                    </button>
                @endif

                <a href="{{ route('invoice.download', $invoice) }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                    <i class="fas fa-download"></i>
                    Download PDF
                </a>

                <a href="{{ route('invoice.edit', $invoice) }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                    <i class="fas fa-edit"></i>
                    Edit Invoice
                </a>

                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                    <i class="fas fa-print"></i>
                    Print Invoice
                </button>

                <a href="{{ route('invoice.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                    <i class="fas fa-arrow-left"></i>
                    Back to Invoices
                </a>
            </div>
        </div>

        <!-- Partial Payment Modal (keeping your existing modal) -->
        <div id="partialPaymentModal"
            class="fixed inset-0 z-[9999] hidden items-start justify-center overflow-y-auto bg-black bg-opacity-50 p-4 pb-20 pt-20">
            <div class="relative w-full max-w-md transform rounded-2xl bg-white shadow-2xl transition-all">
                <div class="rounded-t-2xl bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="flex items-center gap-2 text-xl font-bold text-white">
                            <i class="fas fa-money-bill-wave"></i>
                            Record Partial Payment
                        </h3>
                        <button type="button" onclick="closePartialPaymentModal()"
                            class="text-white transition-colors hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('invoice.markPartial', $invoice) }}" class="p-6">
                    @csrf
                    <div class="space-y-5">
                        <div class="space-y-2 rounded-lg bg-gray-50 p-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Amount:</span>
                                <span class="font-semibold text-gray-900">{{ $invoice->currency }}
                                    {{ number_format($invoice->total_amount, 2) }}</span>
                            </div>
                            @if ($invoice->paid > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Already Paid:</span>
                                    <span class="font-semibold">{{ $invoice->currency }}
                                        {{ number_format($invoice->paid, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between border-t border-gray-200 pt-2">
                                <span class="text-gray-600">Remaining Balance:</span>
                                <span class="font-bold text-red-600">{{ $invoice->currency }}
                                    {{ number_format($invoice->total_amount - $invoice->paid, 2) }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="partial_amount" class="mb-2 block text-sm font-semibold text-gray-700">
                                Payment Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="font-medium text-gray-500">{{ $invoice->currency }}</span>
                                </div>
                                <input type="number" name="partial_amount" id="partial_amount" step="0.01"
                                    min="0.01" max="{{ $invoice->total_amount - $invoice->paid }}" required
                                    class="block w-full rounded-lg border border-gray-300 py-3 pl-16 pr-4 text-gray-900 placeholder-gray-400 transition-colors focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label for="payment_date" class="mb-2 block text-sm font-semibold text-gray-700">
                                Payment Date (Optional)
                            </label>
                            <input type="date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}"
                                class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 transition-colors focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500">
                        </div>

                        <div>
                            <label for="payment_notes" class="mb-2 block text-sm font-semibold text-gray-700">
                                Payment Notes (Optional)
                            </label>
                            <textarea name="payment_notes" id="payment_notes" rows="3"
                                class="block w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-400 transition-colors focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                                placeholder="Add any notes about this payment..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" onclick="closePartialPaymentModal()"
                            class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-500 px-4 py-3 text-sm font-semibold text-white shadow-md transition-all hover:from-yellow-600 hover:to-orange-600">
                            <i class="fas fa-check mr-2"></i>
                            Record Payment
                        </button>
                    </div>
                </form>
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

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                font-size: 12px;
            }

            .bg-gradient-to-br {
                background: white !important;
            }

            .shadow-2xl,
            .shadow-lg,
            .shadow-sm,
            .shadow-md,
            .shadow-xl {
                box-shadow: none !important;
            }

            .border {
                border: 1px solid #e5e7eb !important;
            }

            .rounded-2xl {
                border-radius: 0.5rem !important;
            }

            /* Ensure proper contrast for printing */
            .text-gray-900 {
                color: #1f2937 !important;
            }

            .text-gray-600 {
                color: #4b5563 !important;
            }

            /* Hide decorative elements for print */
            .bg-gradient-to-r.from-blue-600.to-indigo-700 {
                background: #374151 !important;
            }

            .flex.h-12.w-12.items-center.justify-center.rounded-xl {
                display: none !important;
            }
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar for webkit */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script>
        function showPartialPaymentModal() {
            const modal = document.getElementById('partialPaymentModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Focus on the amount input
            setTimeout(() => {
                document.getElementById('partial_amount').focus();
            }, 100);
        }

        function closePartialPaymentModal() {
            const modal = document.getElementById('partialPaymentModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';

            // Reset form
            document.getElementById('partial_amount').value = '';
            document.getElementById('payment_notes').value = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePartialPaymentModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('partialPaymentModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closePartialPaymentModal();
            }
        });
    </script>
@endsection
