@extends('layouts.app')
@section('content')
    <div class="">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-1">Invoices</h5>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center table-header flex-wrap">
                    <div class="mb-2 me-2">
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="ti ti-file-export me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                            class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                            class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('invoice.create') }}" class="btn btn-md btn-primary d-flex align-items-center"><i
                                class="ti ti-circle-plus me-2"></i>Add Invoice</a>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-xl-3 col-sm-6">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 overflow-hidden">
                                <div>
                                    <p class="text-truncate mb-1">Total Invoices</p>
                                    <h6>{{ $invoices->total() }}</h6>
                                </div>
                            </div>
                            <div class="attendance-report-bar mb-2">
                                <div class="progress" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                    aria-valuemax="100" style="height: 5px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <div>
                                <p class="d-flex align-items-center text-truncate">
                                    <span class="text-muted fs-12">Total count</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 overflow-hidden">
                                <div>
                                    <p class="text-truncate mb-1">Paid</p>
                                    <h6>₦{{ number_format($stats['paid_amount'], 2) }}</h6>
                                </div>
                            </div>
                            <div class="attendance-report-bar mb-2">
                                <div class="progress" role="progressbar" aria-valuenow="{{ $stats['paid_percentage'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                    <div class="progress-bar bg-success" style="width: {{ $stats['paid_percentage'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <p class="d-flex align-items-center text-truncate">
                                    <span class="text-success fs-12 d-flex align-items-center me-1">
                                        {{ $stats['paid_count'] }} invoices
                                    </span>
                                    ({{ number_format($stats['paid_percentage'], 1) }}%)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 overflow-hidden">
                                <div>
                                    <p class="text-truncate mb-1">Unpaid</p>
                                    <h6>₦{{ number_format($stats['unpaid_amount'], 2) }}</h6>
                                </div>
                            </div>
                            <div class="attendance-report-bar mb-2">
                                <div class="progress" role="progressbar" aria-valuenow="{{ $stats['unpaid_percentage'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $stats['unpaid_percentage'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <p class="d-flex align-items-center text-truncate">
                                    <span class="text-warning fs-12 d-flex align-items-center me-1">
                                        {{ $stats['unpaid_count'] }} invoices
                                    </span>
                                    ({{ number_format($stats['unpaid_percentage'], 1) }}%)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 overflow-hidden">
                                <div>
                                    <p class="text-truncate mb-1">Partial</p>
                                    <h6>₦{{ number_format($stats['partial_amount'], 2) }}</h6>
                                </div>
                            </div>
                            <div class="attendance-report-bar mb-2">
                                <div class="progress" role="progressbar" aria-valuenow="{{ $stats['partial_percentage'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 5px;">
                                    <div class="progress-bar bg-info" style="width: {{ $stats['partial_percentage'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <p class="d-flex align-items-center text-truncate">
                                    <span class="text-info fs-12 d-flex align-items-center me-1">
                                        {{ $stats['partial_count'] }} invoices
                                    </span>
                                    ({{ number_format($stats['partial_percentage'], 1) }}%)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Statistics -->

            <!-- Invoices Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div>
                        <div class="d-flex align-items-center justify-content-between row-gap-3 mb-3 flex-wrap">
                            <h5 class="d-flex align-items-center">All Invoices
                                <span class="badge bg-light text-dark fs-12 ms-2">{{ $invoices->total() }} Total</span>
                            </h5>
                            <div class="d-flex align-items-center row-gap-3 table-header flex-wrap">
                                <div class="input-icon position-relative me-2">
                                    <input type="text" class="form-control h-auto py-1" placeholder="Search invoices...">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-search"></i>
                                    </span>
                                </div>
                                <div class="dropdown me-2">
                                    <a href="javascript:void(0);"
                                        class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                                        data-bs-toggle="dropdown">
                                        Filter Status
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li><a href="{{ route('invoice.index') }}" class="dropdown-item rounded-1">All</a></li>
                                        <li><a href="{{ route('invoice.index', ['status' => 'paid']) }}" class="dropdown-item rounded-1">Paid</a></li>
                                        <li><a href="{{ route('invoice.index', ['status' => 'unpaid']) }}" class="dropdown-item rounded-1">Unpaid</a></li>
                                        <li><a href="{{ route('invoice.index', ['status' => 'partial']) }}" class="dropdown-item rounded-1">Partial</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);"
                                        class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center fw-medium"
                                        data-bs-toggle="dropdown">
                                        <span class="d-inline-flex me-1">Sort By: </span> Latest
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li><a href="{{ route('invoice.index', ['sort' => 'latest']) }}" class="dropdown-item rounded-1">Latest First</a></li>
                                        <li><a href="{{ route('invoice.index', ['sort' => 'oldest']) }}" class="dropdown-item rounded-1">Oldest First</a></li>
                                        <li><a href="{{ route('invoice.index', ['sort' => 'amount_high']) }}" class="dropdown-item rounded-1">Amount (High to Low)</a></li>
                                        <li><a href="{{ route('invoice.index', ['sort' => 'amount_low']) }}" class="dropdown-item rounded-1">Amount (Low to High)</a></li>
                                        <li><a href="{{ route('invoice.index', ['sort' => 'due_date']) }}" class="dropdown-item rounded-1">Due Date</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="card-body p-0">
                            <div class="table-responsive table-nowrap">
                                <table class="mb-0 table border">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="no-sort">
                                                <div class="form-check form-check-md">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                </div>
                                            </th>
                                            <th class="fw-medium fs-14">Invoice #</th>
                                            <th class="fw-medium fs-14">Customer</th>
                                            <th class="fw-medium fs-14">Issue Date</th>
                                            <th class="fw-medium fs-14">Due Date</th>
                                            <th class="fw-medium fs-14">Total Amount</th>
                                            <th class="fw-medium fs-14">Paid</th>
                                            <th class="fw-medium fs-14">Balance</th>
                                            <th class="fw-medium fs-14">Status</th>
                                            <th class="fw-medium fs-14">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $invoice)
                                            @php
                                                $balance = $invoice->total_amount - $invoice->paid;
                                                $isOverdue = $invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-md">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('invoice.show', $invoice->id) }}"
                                                        class="tb-data text-primary fw-medium">
                                                        {{ $invoice->invoice_number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{ route('invoice.show', $invoice->id) }}" class="avatar avatar-md me-2 bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                            <span class="fw-medium text-primary">
                                                                {{ strtoupper(substr($invoice->customer->name ?? 'U', 0, 2)) }}
                                                            </span>
                                                        </a>
                                                        <div>
                                                            <h6 class="fw-medium fs-14 mb-0">
                                                                <a href="{{ route('invoice.show', $invoice->id) }}">
                                                                    {{ $invoice->customer->name ?? 'Unknown' }}
                                                                </a>
                                                            </h6>
                                                            @if($invoice->customer && $invoice->customer->email)
                                                                <small class="text-muted">{{ $invoice->customer->email }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $invoice->issue_date ? $invoice->issue_date->format('d M, Y') : 'N/A' }}</td>
                                                <td>
                                                    @if($invoice->due_date)
                                                        <span class="{{ $isOverdue ? 'text-danger fw-medium' : '' }}">
                                                            {{ $invoice->due_date->format('d M, Y') }}
                                                            @if($isOverdue)
                                                                <br><small class="badge badge-soft-danger">Overdue</small>
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="fw-medium">₦{{ number_format($invoice->total_amount, 2) }}</td>
                                                <td class="text-success">₦{{ number_format($invoice->paid, 2) }}</td>
                                                <td class="{{ $balance > 0 ? 'text-danger fw-medium' : 'text-muted' }}">
                                                    ₦{{ number_format($balance, 2) }}
                                                </td>
                                                <td>
                                                    @if($invoice->status === 'paid')
                                                        <span class="badge badge-soft-success d-inline-flex align-items-center">
                                                            <i class="ti ti-circle-check-filled me-1"></i>Paid
                                                        </span>
                                                    @elseif($invoice->status === 'partial')
                                                        <span class="badge badge-soft-info d-inline-flex align-items-center">
                                                            <i class="ti ti-clock me-1"></i>Partial
                                                        </span>
                                                    @else
                                                        <span class="badge badge-soft-warning d-inline-flex align-items-center">
                                                            <i class="ti ti-alert-circle me-1"></i>Unpaid
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                                            class="me-2" title="View">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                        <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                            class="me-2" title="Edit">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="text-danger"
                                                            title="Delete"
                                                            onclick="confirmDelete({{ $invoice->id }})">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="ti ti-file-invoice fs-1 d-block mb-2"></i>
                                                        <p class="mb-2">No invoices found</p>
                                                        <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-primary">
                                                            <i class="ti ti-plus me-1"></i>Create First Invoice
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
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} entries
                                    </div>
                                    <div>
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->

        </div>
        <!-- End Content -->

    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete this invoice? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(invoiceId) {
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/invoice/${invoiceId}`;

            const modal = new bootstrap.Modal(document.getElementById('delete_modal'));
            modal.show();
        }

        // Select all checkboxes
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
