<!DOCTYPE html>
<html>
<head>
    <title>Receipt - Invoice #{{ $invoice->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .print-shadow { box-shadow: none !important; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen py-8 px-4">

<div class="max-w-4xl mx-auto">

    <!-- Action Buttons -->
    <div class="no-print flex justify-between items-center mb-6 animate-fade-in">
        <a href="javascript:history.back()"
           class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>

        <div class="flex gap-3">
            <button onclick="window.print()"
                    class="inline-flex items-center bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>

            <a href="{{ route('invoice.show.receipt', $invoice->id) }}?download=1"
               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download
            </a>
        </div>
    </div>

    <!-- Receipt Card -->
    <div class="bg-white print-shadow shadow-2xl rounded-2xl overflow-hidden animate-fade-in">

        <!-- Header with Success Badge -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-6">
            <div class="flex justify-between items-start">
                <div>
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5 mb-3">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold">PAID</span>
                    </div>
                    <h1 class="text-3xl font-bold mb-1">Payment Receipt</h1>
                    <p class="text-green-50">Thank you for your payment!</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-green-50 mb-1">Receipt Number</div>
                    <div class="text-xl font-bold">#{{ $invoice->invoice_number }}</div>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-10">

            <!-- Company & Customer Info -->
            <div class="grid md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                <!-- From -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">From</h3>
                    <div class="space-y-1">
                        <p class="text-lg font-bold text-gray-900">{{ $user->company->name }}</p>
                        <p class="text-gray-600">{{ $user->company->address }}</p>

                        <p class="text-gray-600">{{ $user->company->email }}</p>
                        <p class="text-gray-600">{{ $user->company->phone }}</p>
                    </div>
                </div>

                <!-- To -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Bill To</h3>
                    <div class="space-y-1">
                        <p class="text-lg font-bold text-gray-900">{{ $invoice->customer->name }}</p>
                        @if($invoice->customer->email)
                            <p class="text-gray-600">{{ $invoice->customer->email }}</p>
                        @endif
                        @if($invoice->customer->phone)
                            <p class="text-gray-600">{{ $invoice->customer->phone }}</p>
                        @endif
                        @if($invoice->customer->address)
                            <p class="text-gray-600">{{ $invoice->customer->address }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5">
                    <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-2">Invoice Date</div>
                    <div class="text-lg font-bold text-gray-900">
                        {{ $invoice->created_at->format('d M Y') }}
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5">
                    <div class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-2">Payment Date</div>
                    <div class="text-lg font-bold text-gray-900">
                        {{ $invoice->paid_at->format('d M Y') }}
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5">
                    <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-2">Payment Method</div>
                    <div class="text-lg font-bold text-gray-900">
                        {{ $invoice->payment_method ?? 'Online Payment' }}
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            @if($invoice->items && $invoice->items->count() > 0)
            <div class="mb-8">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Items</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-y border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Description</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Unit Price</th>
                                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($invoice->items as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-gray-900">{{ $item->product->name }}</div>

                                </td>
                                <td class="py-4 px-4 text-center text-gray-900">{{ $item->quantity }}</td>
                                <td class="py-4 px-4 text-right text-gray-900">₦{{ number_format($item->rate, 2) }}</td>
                                <td class="py-4 px-4 text-right font-semibold text-gray-900">
                                    ₦{{ number_format($item->amount, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Totals -->
            <div class="flex justify-end mb-8">
                <div class="w-full md:w-80 space-y-3">
                    @if(isset($invoice->subtotal))
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal:</span>
                        <span class="font-semibold">₦{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @endif

                    @if(isset($invoice->tax) && $invoice->tax > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Tax:</span>
                        <span class="font-semibold">₦{{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    @endif

                    @if(isset($invoice->discount) && $invoice->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount:</span>
                        <span class="font-semibold">-₦{{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    @endif

                    <div class="border-t-2 border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Amount:</span>
                            <span class="text-2xl font-bold text-green-600">
                                ₦{{ number_format($invoice->total_amount, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Reference -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Payment Reference
                        </div>
                        <div class="font-mono text-lg font-bold text-gray-900">
                            {{ $invoice->payment_reference }}
                        </div>
                    </div>
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-bold">
                        VERIFIED
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="text-center pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-2">
                    This is an official payment receipt. For any queries, please contact our support team.
                </p>
                <p class="text-xs text-gray-400">
                    Generated on {{ now()->format('d M Y, h:i A') }}
                </p>
            </div>

        </div>
    </div>

</div>

</body>
</html>
