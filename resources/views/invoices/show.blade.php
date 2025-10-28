@extends('layouts.app')

@section('content')
    <div class="">
        {{-- ✅ Flash Message Section --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Invoice Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-md-5 p-4">

                        <!-- Header Section -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h1 class="h2 fw-bold text-primary mb-1">INVOICE</h1>
                                <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="col-md-6 text-md-end mt-md-0 mt-3">
                                <div class="mb-2">
                                    @if ($invoice->status === 'paid')
                                        <span class="badge bg-success fs-6 px-3 py-2">PAID</span>
                                    @elseif($invoice->status === 'partial')
                                        <span class="badge bg-warning fs-6 px-3 py-2">PARTIALLY PAID</span>
                                    @else
                                        <span class="badge bg-danger fs-6 px-3 py-2">UNPAID</span>
                                    @endif
                                </div>
                                <p class="mb-1"><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}
                                </p>
                                @if ($invoice->due_date)
                                    <p class="mb-0"><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Bill To Section -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h6 class="text-uppercase text-muted small mb-2">Bill To</h6>
                                <h5 class="fw-bold mb-1">{{ $invoice->customer->name }}</h5>
                                <p class="text-muted mb-0">{{ $invoice->customer->email }}</p>
                                @if ($invoice->customer->phone)
                                    <p class="text-muted mb-0">{{ $invoice->customer->phone }}</p>
                                @endif
                                @if ($invoice->customer->address)
                                    <p class="text-muted mb-0">{{ $invoice->customer->address }}</p>
                                @endif
                            </div>
                            @if ($invoice->user)
                                <div class="col-md-6 text-md-end mt-md-0 mt-3">
                                    <h6 class="text-uppercase text-muted small mb-2">From</h6>
                                    <h5 class="fw-bold mb-1">{{ $invoice->user->name ?? 'Your Company' }}</h5>
                                    <p class="text-muted mb-0">{{ $invoice->user->email ?? '' }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Items Table -->
                        <div class="table-responsive mb-4">
                            <table class="table-hover table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Product/Services</th>
                                        <th class="border-0 text-center" style="width: 100px;">Qty</th>
                                        <th class="border-0 text-end" style="width: 120px;">Rate</th>
                                        <th class="border-0 text-center" style="width: 80px;">Tax %</th>
                                        <th class="border-0 text-end" style="width: 140px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $item->product->name ?? 'N/A' }} </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ $invoice->currency }}
                                                {{ number_format($item->rate, 2) }}</td>
                                            <td class="text-center">{{ $item->tax_percent }}%</td>
                                            <td class="fw-semibold text-end">{{ $invoice->currency }}
                                                {{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals Section -->
                        <div class="row justify-content-end">
                            <div class="col-md-5 col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        @php
                                            $subtotal = $invoice->items->sum('amount');
                                            $taxTotal = $invoice->items->sum(function ($item) {
                                                return ($item->quantity * $item->rate * $item->tax_percent) / 100;
                                            });
                                        @endphp

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span>{{ $invoice->currency }}
                                                {{ number_format($subtotal - $taxTotal, 2) }}</span>
                                        </div>

                                        @if ($taxTotal > 0)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Tax:</span>
                                                <span>{{ $invoice->currency }} {{ number_format($taxTotal, 2) }}</span>
                                            </div>
                                        @endif

                                        @if ($invoice->discount > 0)
                                            <div class="d-flex justify-content-between text-success mb-2">
                                                <span>Discount:</span>
                                                <span>-{{ $invoice->currency }}
                                                    {{ number_format($invoice->discount, 2) }}</span>
                                            </div>
                                        @endif

                                        <hr class="my-2">

                                        <div class="d-flex justify-content-between fw-bold fs-5 mb-2">
                                            <span>Total:</span>
                                            <span class="text-primary">{{ $invoice->currency }}
                                                {{ number_format($invoice->total_amount, 2) }}</span>
                                        </div>

                                        @if ($invoice->paid > 0)
                                            <div class="d-flex justify-content-between text-success">
                                                <span>Paid:</span>
                                                <span>{{ $invoice->currency }}
                                                    {{ number_format($invoice->paid, 2) }}</span>
                                            </div>
                                        @endif

                                        @if ($invoice->total_amount - $invoice->paid > 0)
                                            <div
                                                class="d-flex justify-content-between fw-bold text-danger border-top mt-2 pt-2">
                                                <span>Amount Due:</span>
                                                <span>{{ $invoice->currency }}
                                                    {{ number_format($invoice->total_amount - $invoice->paid, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        @if ($invoice->notes)
                            <div class="border-top mt-4 pt-4">
                                <h6 class="text-muted small text-uppercase mb-2">Notes</h6>
                                <p class="mb-0">{{ $invoice->notes }}</p>
                            </div>
                        @endif

                        <!-- Payment Method -->
                        @if ($invoice->payment_method)
                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>Payment Method:</strong> {{ $invoice->payment_method }}
                                </small>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="border-top d-flex mt-5 flex-wrap gap-2 pt-4">
                            @if ($invoice->status !== 'paid')
                                <form method="POST" action="{{ route('invoice.send', $invoice) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-envelope"></i> Send to Customer
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('invoice.download', $invoice) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-download"></i> Download PDF
                            </a>

                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="bi bi-printer"></i> Print
                            </button>

                            <a href="{{ route('invoice.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            form {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>
@endsection
