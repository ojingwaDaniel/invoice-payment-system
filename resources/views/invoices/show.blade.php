@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        <!-- Enhanced Flash Messages -->
        @if (session('success'))
        <div class="mb-8 animate-fade-in rounded-xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                    </div>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button type="button" class="text-green-500 hover:text-green-700 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-8 animate-fade-in rounded-xl border border-red-200 bg-gradient-to-r from-red-50 to-rose-50 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                        <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                    </div>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Premium Invoice Card -->
        <div class="rounded-2xl bg-white shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Header Gradient Bar -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i class="fas fa-receipt text-white text-lg"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-white">INVOICE</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Invoice Number</p>
                        <p class="text-white font-semibold text-lg">#{{ $invoice->invoice_number }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">

                <!-- Top Section with Logo and Status -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 gap-8">
                    <div class="flex items-center gap-6">
                        @if($invoice->user && $invoice->user->logo_path)
                        <div class="flex-shrink-0">
                            <div class="h-32 w-32 rounded-2xl bg-white p-3">
                                <img src="{{ asset('storage/' . $invoice->user->logo_path) }}" 
                                     alt="{{ $invoice->user->company_name ?? 'Company Logo' }}" 
                                     class="h-full w-full object-contain">
                            </div>
                        </div>
                        @else
                        <div class="flex-shrink-0">
                            <div class="h-24 w-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-2xl">
                                    {{ substr($invoice->user->company_name ?? 'CO', 0, 2) }}
                                </span>
                            </div>
                        </div>
                        @endif
                        <div>
                            @if($invoice->user && $invoice->user->company_name)
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Issued By</p>
                            <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $invoice->user->company_name }}</h1>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end space-y-4">
                        <div>
                            @if ($invoice->status === 'paid')
                            <span class="inline-flex items-center rounded-full bg-green-100 px-6 py-3 text-sm font-semibold text-green-800 shadow-sm">
                                <div class="h-2 w-2 rounded-full bg-green-500 mr-3 animate-pulse"></div>
                                <i class="fas fa-check-circle mr-2"></i>
                                PAID
                            </span>
                            @elseif($invoice->status === 'partial')
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-6 py-3 text-sm font-semibold text-yellow-800 shadow-sm">
                                <div class="h-2 w-2 rounded-full bg-yellow-500 mr-3"></div>
                                <i class="fas fa-clock mr-2"></i>
                                PARTIALLY PAID
                            </span>
                            @else
                            <span class="inline-flex items-center rounded-full bg-red-100 px-6 py-3 text-sm font-semibold text-red-800 shadow-sm">
                                <div class="h-2 w-2 rounded-full bg-red-500 mr-3"></div>
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                UNPAID
                            </span>
                            @endif
                        </div>
                        <div class="text-right space-y-2">
                            <div class=" items-center justify-end space-x-4 text-sm">
                                <div class="text-gray-500">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}
                                </div> 
                                @if ($invoice->due_date)
                                <div class="text-gray-500">
                                    <i class="fas fa-clock mr-2"></i>
                                    <strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company & Customer Details -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12">
                    <!-- Bill To Section -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider flex items-center">
                            <div class="h-1 w-6 bg-blue-500 mr-3 rounded-full"></div>
                            Bill To
                        </h3>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-xl mb-2">{{ $invoice->customer->name }}</h4>
                                    <div class="space-y-1 text-gray-600">
                                        <p class="flex items-center">
                                            <i class="fas fa-envelope mr-3 text-gray-400 w-4"></i>
                                            {{ $invoice->customer->email }}
                                        </p>
                                        @if ($invoice->customer->phone)
                                        <p class="flex items-center">
                                            <i class="fas fa-phone mr-3 text-gray-400 w-4"></i>
                                            {{ $invoice->customer->phone }}
                                        </p>
                                        @endif
                                        @if ($invoice->customer->address)
                                        <p class="flex items-start">
                                            <i class="fas fa-map-marker-alt mr-3 text-gray-400 w-4 mt-1"></i>
                                            <span class="flex-1">{{ $invoice->customer->address }}</span>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- From Section -->
                    @if ($invoice->user)
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider flex items-center">
                            <div class="h-1 w-6 bg-indigo-500 mr-3 rounded-full"></div>
                            From
                        </h3>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                    <i class="fas fa-building text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-xl mb-2">{{ $invoice->user->company_name ?? 'Company Name' }}</h4>
                                    <div class="space-y-1 text-gray-600">
                                        <p class="flex items-center">
                                            <i class="fas fa-envelope mr-3 text-gray-400 w-4"></i>
                                            {{ $invoice->user->email }}
                                        </p>
                                        @if ($invoice->user->phone)
                                        <p class="flex items-center">
                                            <i class="fas fa-phone mr-3 text-gray-400 w-4"></i>
                                            {{ $invoice->user->phone }}
                                        </p>
                                        @endif
                                        @if ($invoice->user->address)
                                        <p class="flex items-start">
                                            <i class="fas fa-map-marker-alt mr-3 text-gray-400 w-4 mt-1"></i>
                                            <span class="flex-1">{{ $invoice->user->address }}</span>
                                        </p>
                                        @endif
                                        @if ($invoice->user->website)
                                        <p class="flex items-center">
                                            <i class="fas fa-globe mr-3 text-gray-400 w-4"></i>
                                            <a href="{{ $invoice->user->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                                {{ $invoice->user->website }}
                                            </a>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Items Table -->
                <div class="mb-12">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider flex items-center mb-6">
                        <div class="h-1 w-6 bg-green-500 mr-3 rounded-full"></div>
                        Items & Services
                    </h3>
                    <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Product/Services
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600" style="width: 100px;">
                                        Qty
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600" style="width: 120px;">
                                        Unit Price
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600" style="width: 100px;">
                                        Discount
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600" style="width: 140px;">
                                        Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($invoice->items as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $item->product->name ?? 'N/A' }}</div>
                                        @if ($item->unit)
                                        <div class="text-sm text-gray-500 mt-1 flex items-center">
                                            <i class="fas fa-cube mr-2 text-gray-400 text-xs"></i>
                                            Unit: {{ $item->unit }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-800 font-medium text-sm">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-900">
                                        {{ $invoice->currency }} {{ number_format($item->rate, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($item->discount > 0)
                                        <span class="text-red-600 font-medium">
                                            -{{ $invoice->currency }} {{ number_format($item->discount, 2) }}
                                        </span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                        {{ $invoice->currency }} {{ number_format($item->amount, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="flex justify-end mb-12">
                    <div class="w-full lg:w-96">
                        @php
                            $subtotal = $invoice->items->sum('amount');
                            $afterDiscount = $subtotal - ($invoice->discount ?? 0);
                            $taxRate = $invoice->tax_rate ?? 7.5;
                            $vatAmount = ($afterDiscount * $taxRate) / 100;
                            $totalAmount = $afterDiscount + $vatAmount;
                        @endphp

                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-200 shadow-lg">
                            <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-calculator mr-3 text-blue-600"></i>
                                Invoice Summary
                            </h4>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $invoice->currency }} {{ number_format($subtotal, 2) }}
                                    </span>
                                </div>

                                @if ($invoice->discount > 0)
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 text-red-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-tag mr-2"></i>
                                        Discount
                                    </span>
                                    <span class="font-semibold">-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600">After Discount:</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}
                                    </span>
                                </div>
                                @endif

                                <div class="flex justify-between items-center py-2 border-b border-gray-200 text-green-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-percentage mr-2"></i>
                                        VAT ({{ $taxRate }}%)
                                    </span>
                                    <span class="font-semibold">{{ $invoice->currency }} {{ number_format($invoice->vat_amount, 2) }}</span>
                                </div>

                                @if ($invoice->paid > 0)
                                <div class="flex justify-between items-center py-2 border-b border-green-200 bg-green-50 rounded-lg px-3 -mx-1 text-green-700">
                                    <span class="flex items-center font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Amount Paid
                                    </span>
                                    <span class="font-bold">{{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}</span>
                                </div>
                                @endif

                                <div class="flex justify-between items-center pt-4 border-t border-gray-300">
                                    @if ($invoice->total_amount - $invoice->paid > 0)
                                    <span class="text-xl font-bold text-red-600 flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        Amount Due:
                                    </span>
                                    <span class="text-xl font-bold text-red-600">
                                        {{ $invoice->currency }} {{ number_format($invoice->total_amount - $invoice->paid, 2) }}
                                    </span>
                                    @else
                                    <span class="text-xl font-bold text-green-600 flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Total Paid:
                                    </span>
                                    <span class="text-xl font-bold text-green-600">
                                        {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if ($invoice->notes)
                <div class="border-t border-gray-200 pt-8 mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider flex items-center mb-4">
                        <div class="h-1 w-6 bg-purple-500 mr-3 rounded-full"></div>
                        Additional Notes
                    </h3>
                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-6 border border-purple-100">
                        <div class="flex items-start space-x-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600 flex-shrink-0">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $invoice->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Payment Method -->
                @if ($invoice->payment_method)
                <div class="mb-8">
                    <div class="flex items-center space-x-3 text-sm text-gray-600 bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <i class="fas fa-credit-card text-blue-500"></i>
                        <span><strong>Preferred Payment Method:</strong> {{ $invoice->payment_method }}</span>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-8">
                    <div class="flex flex-wrap gap-4 no-print">
                        @if ($invoice->status !== 'paid')
                        <form method="POST" action="{{ route('invoice.send', $invoice) }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3.5 text-sm font-semibold text-white hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane group-hover:scale-110 transition-transform"></i>
                                Send to Customer
                            </button>
                        </form>
                        @endif

                        @if ($invoice->status !== 'paid')
                        <a href="{{ route('invoice.pay', $invoice->id) }}"
                           class="group inline-flex items-center gap-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-3.5 text-sm font-semibold text-white hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-credit-card group-hover:scale-110 transition-transform"></i>
                            Pay Invoice
                        </a>
                        @endif

                        <a href="{{ route('invoice.download', $invoice) }}"
                           class="group inline-flex items-center gap-3 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-download group-hover:scale-110 transition-transform"></i>
                            Download PDF
                        </a>

                        <a href="{{ route('invoice.edit', $invoice) }}"
                           class="group inline-flex items-center gap-3 rounded-xl border border-blue-300 bg-white px-6 py-3.5 text-sm font-semibold text-blue-600 hover:bg-blue-50 hover:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-edit group-hover:scale-110 transition-transform"></i>
                            Edit Invoice
                        </a>

                        <button onclick="printInvoice()"
                                class="group inline-flex items-center gap-3 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-print group-hover:scale-110 transition-transform"></i>
                            Print Invoice
                        </button>

                        <a href="{{ route('invoice.index') }}"
                           class="group inline-flex items-center gap-3 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            Back to Invoices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
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

        .shadow-2xl, .shadow-lg, .shadow-sm, .shadow-md, .shadow-xl {
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
    function printInvoice() {
        window.print();
    }

    // Enhanced keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            printInvoice();
        }
        
        // Escape key to go back
        if (e.key === 'Escape') {
            window.location.href = "{{ route('invoice.index') }}";
        }
    });

    // Add smooth interactions
    

        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>
@endsection