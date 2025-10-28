@extends('layouts.app')

@section('content')
<div class="">
    <div class="">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-1">Customer Details</h5>
                <p class="text-muted mb-0">View customer information and invoices</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Back
                </a>
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>Edit Customer
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Customer Info Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar avatar-xxl bg-primary-transparent rounded-circle mx-auto mb-3">
                            <span class="fs-1 fw-bold text-primary">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </span>
                        </div>
                        <h4 class="mb-1">{{ $customer->name }}</h4>
                        <p class="text-muted mb-3">Customer ID: #{{ $customer->id }}</p>

                        <div class="d-grid gap-2">
                            <a href="mailto:{{ $customer->email }}" class="btn btn-outline-primary">
                                <i class="ti ti-mail me-1"></i>Send Email
                            </a>
                            <a href="tel:{{ $customer->phone }}" class="btn btn-outline-primary">
                                <i class="ti ti-phone me-1"></i>Call Customer
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Contact Information</h6>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Email</small>
                            <p class="mb-0">{{ $customer->email }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Phone</small>
                            <p class="mb-0">{{ $customer->phone }}</p>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Address</small>
                            <p class="mb-0">{{ $customer->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoices List -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Recent Invoices</h5>
                            <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                               class="btn btn-sm btn-primary">
                                <i class="ti ti-plus me-1"></i>New Invoice
                            </a>
                        </div>

                        @if($customer->invoices->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customer->invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('invoice.show', $invoice->id) }}">
                                                        {{ $invoice->invoice_number }}
                                                    </a>
                                                </td>
                                                <td>{{ $invoice->issue_date->format('d M, Y') }}</td>
                                                <td>₦{{ number_format($invoice->total_amount, 2) }}</td>
                                                <td>
                                                    @if($invoice->status === 'paid')
                                                        <span class="badge badge-soft-success">Paid</span>
                                                    @elseif($invoice->status === 'partial')
                                                        <span class="badge badge-soft-info">Partial</span>
                                                    @else
                                                        <span class="badge badge-soft-warning">Unpaid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('invoice.show', $invoice->id) }}"
                                                       class="btn btn-sm btn-outline-primary">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ti ti-file-invoice fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-3">No invoices yet</p>
                                <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="ti ti-plus me-1"></i>Create First Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted mb-1">Joined Date</p>
                                <h5>{{ $customer->created_at->format('d M, Y') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted mb-1">Last Updated</p>
                                <h5>{{ $customer->updated_at->format('d M, Y') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
