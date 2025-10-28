@extends('layouts.app')

@section('content')
<div class="">
    <div class="">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-1">Customers</h5>
                <p class="text-muted mb-0">Manage your customer database</p>
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
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                    <i class="ti ti-file-type-pdf me-1"></i>Export as PDF
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                    <i class="ti ti-file-type-xls me-1"></i>Export as Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-2">
                    <a href="{{ route('customer.create') }}" class="btn btn-md btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Add Customer
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 overflow-hidden">
                            <div class="me-3">
                                <span class="avatar avatar-lg bg-primary-transparent rounded-circle">
                                    <i class="ti ti-users fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="text-truncate mb-1">Total Customers</p>
                                <h4 class="mb-0">{{ $customers->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 overflow-hidden">
                            <div class="me-3">
                                <span class="avatar avatar-lg bg-success-transparent rounded-circle">
                                    <i class="ti ti-user-check fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="text-truncate mb-1">Active Customers</p>
                                <h4 class="mb-0">{{ $stats['active_customers'] ?? $customers->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 overflow-hidden">
                            <div class="me-3">
                                <span class="avatar avatar-lg bg-info-transparent rounded-circle">
                                    <i class="ti ti-file-invoice fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="text-truncate mb-1">Total Invoices</p>
                                <h4 class="mb-0">{{ $stats['total_invoices'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 overflow-hidden">
                            <div class="me-3">
                                <span class="avatar avatar-lg bg-warning-transparent rounded-circle">
                                    <i class="ti ti-calendar-plus fs-4"></i>
                                </span>
                            </div>
                            <div>
                                <p class="text-truncate mb-1">New This Month</p>
                                <h4 class="mb-0">{{ $stats['new_this_month'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Statistics -->

        <!-- Customers Table -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between row-gap-3 mb-3 flex-wrap">
                            <h5 class="d-flex align-items-center mb-0">
                                All Customers
                                <span class="badge bg-light text-dark fs-12 ms-2">{{ $customers->total() }} Total</span>
                            </h5>
                            <div class="d-flex align-items-center row-gap-3 table-header flex-wrap">
                                <div class="input-icon position-relative me-2">
                                    <form action="{{ route('customer.index') }}" method="GET">
                                        <input type="text" name="search" class="form-control h-auto py-1"
                                            placeholder="Search customers..."
                                            value="{{ request('search') }}">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                    </form>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);"
                                        class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center fw-medium"
                                        data-bs-toggle="dropdown">
                                        <span class="d-inline-flex me-1">Sort By: </span> Name
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li><a href="{{ route('customer.index', ['sort' => 'name']) }}" class="dropdown-item rounded-1">Name (A-Z)</a></li>
                                        <li><a href="{{ route('customer.index', ['sort' => 'name_desc']) }}" class="dropdown-item rounded-1">Name (Z-A)</a></li>
                                        <li><a href="{{ route('customer.index', ['sort' => 'latest']) }}" class="dropdown-item rounded-1">Latest First</a></li>
                                        <li><a href="{{ route('customer.index', ['sort' => 'oldest']) }}" class="dropdown-item rounded-1">Oldest First</a></li>
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

                        <div class="table-responsive table-nowrap">
                            <table class="mb-0 table border">
                                <thead class="table-light">
                                    <tr>
                                        <th class="no-sort">
                                            <div class="form-check form-check-md">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                            </div>
                                        </th>
                                        <th class="fw-medium fs-14">Customer</th>
                                        <th class="fw-medium fs-14">Email</th>
                                        <th class="fw-medium fs-14">Phone</th>
                                        <th class="fw-medium fs-14">Address</th>
                                        <th class="fw-medium fs-14">Invoices</th>
                                        <th class="fw-medium fs-14">Joined Date</th>
                                        <th class="fw-medium fs-14">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-md">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                        class="avatar avatar-md me-2 bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center">
                                                        <span class="fw-medium text-primary">
                                                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                        </span>
                                                    </a>
                                                    <div>
                                                        <h6 class="fw-medium fs-14 mb-0">
                                                            <a href="{{ route('customer.show', $customer->id) }}">
                                                                {{ $customer->name }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">ID: {{ $customer->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $customer->email }}" class="text-primary">
                                                    {{ $customer->email }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="tel:{{ $customer->phone }}" class="text-dark">
                                                    {{ $customer->phone }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                    title="{{ $customer->address }}">
                                                    {{ $customer->address }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($customer->invoices_count > 0)
                                                    <span class="badge bg-primary-transparent">
                                                        {{ $customer->invoices_count }} {{ Str::plural('invoice', $customer->invoices_count) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">No invoices</span>
                                                @endif
                                            </td>
                                            <td>{{ $customer->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <div class="action-icon d-inline-flex">
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                        class="me-2" title="View">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                                        class="me-2" title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="text-danger"
                                                        title="Delete"
                                                        onclick="confirmDelete({{ $customer->id }})">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ti ti-users fs-1 d-block mb-2"></i>
                                                    <p class="mb-2">No customers found</p>
                                                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-plus me-1"></i>Add First Customer
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($customers->hasPages())
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                                </div>
                                <div>
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->

    </div>
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
                    <p>Are you sure you want to delete this customer? This action cannot be undone.</p>
                    <p class="text-danger"><strong>Warning:</strong> All related invoices will also be deleted.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(customerId) {
        const deleteForm = document.getElementById('delete-form');
        deleteForm.action = `/customer/${customerId}`;

        const modal = new bootstrap.Modal(document.getElementById('delete_modal'));
        modal.show();
    }

    // Select all checkboxes
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Auto-submit search on input (with debounce)
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
</script>
@endsection
