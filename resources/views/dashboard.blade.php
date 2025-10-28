@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">
                <i class="bi bi-speedometer2"></i> Dashboard
            </h1>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        @php
            $totalInvoices = Auth::user()->invoices()->count();
            $paidInvoices = Auth::user()->invoices()->where('status', 'paid')->count();
            $unpaidInvoices = Auth::user()->invoices()->where('status', 'unpaid')->count();
            $totalRevenue = Auth::user()->invoices()->where('status', 'paid')->sum('total_amount');
            $pendingAmount = Auth::user()->invoices()->where('status', 'unpaid')->sum('total_amount');
        @endphp

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Invoices</p>
                            <h3 class="mb-0">{{ $totalInvoices }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Paid Invoices</p>
                            <h3 class="mb-0 text-success">{{ $paidInvoices }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Unpaid Invoices</p>
                            <h3 class="mb-0 text-danger">{{ $unpaidInvoices }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-exclamation-circle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Revenue</p>
                            <h3 class="mb-0 text-primary">₦{{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('invoice.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Create Invoice
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.create') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-person-plus"></i> Add Customer
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('products.create') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-box"></i> Add Product
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('invoice.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-list"></i> View All Invoices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Invoices</h5>
                    <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentInvoices = Auth::user()->invoices()
                            ->with('customer')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentInvoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <strong>{{ $invoice->invoice_number }}</strong>
                                        </td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>{{ $invoice->issue_date->format('M d, Y') }}</td>
                                        <td>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            @if($invoice->status === 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($invoice->status === 'partial')
                                                <span class="badge bg-warning">Partial</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No invoices yet. Create your first invoice!</p>
                            <a href="{{ route('invoice.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Create Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
