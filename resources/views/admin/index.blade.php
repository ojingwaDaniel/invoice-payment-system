@extends('layouts.app')
@section('content')
    <div class="">
        <div class="">
            @if (auth()->user()->paystack_access_code)
                <p class="text-success">✅ Paystack Connected</p>
            @else
                <a href="{{ route('paystack.connect') }}" class="btn btn-primary">Connect Paystack Account</a>
            @endif

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-semibold mb-1">Dashboard</h4>
                    <p class="text-muted fs-14 mb-0">Welcome back! Here's your business overview</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <!-- Create New Dropdown -->
                    <div class="dropdown" x-data="{ open: false }" @click.away="open = false">
                        <button class="btn btn-primary d-inline-flex align-items-center shadow-sm" @click="open = !open"
                            type="button">
                            <i class="isax isax-add-circle me-2"></i>
                            <span>Create New</span>
                            <i class="fa-solid fa-chevron-down fs-12 ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" :class="{ 'show': open }" x-show="open"
                            x-transition>
                            <li>
                                <a href="add-invoice.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-document-text-1 text-primary me-3"></i>
                                    <div>
                                        <div class="fw-medium">Invoice</div>
                                        <small class="text-muted">Create new invoice</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="expenses.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-money-send text-danger me-3"></i>
                                    <div>
                                        <div class="fw-medium">Expense</div>
                                        <small class="text-muted">Record expense</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="add-credit-notes.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-money-add text-success me-3"></i>
                                    <div>
                                        <div class="fw-medium">Credit Note</div>
                                        <small class="text-muted">Issue credit note</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="add-debit-notes.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-money-recive text-warning me-3"></i>
                                    <div>
                                        <div class="fw-medium">Debit Note</div>
                                        <small class="text-muted">Issue debit note</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="add-purchases-orders.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-document text-info me-3"></i>
                                    <div>
                                        <div class="fw-medium">Purchase Order</div>
                                        <small class="text-muted">Create PO</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="add-quotation.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-document-download text-purple me-3"></i>
                                    <div>
                                        <div class="fw-medium">Quotation</div>
                                        <small class="text-muted">Send quotation</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="add-delivery-challan.html" class="dropdown-item d-flex align-items-center">
                                    <i class="isax isax-document-forward text-secondary me-3"></i>
                                    <div>
                                        <div class="fw-medium">Delivery Challan</div>
                                        <small class="text-muted">Create challan</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Export Dropdown -->
                    <div class="dropdown" x-data="{ open: false }" @click.away="open = false">
                        <button class="btn btn-outline-secondary d-inline-flex align-items-center" @click="open = !open"
                            type="button">
                            <i class="isax isax-export-1 me-2"></i>
                            <span>Export</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" :class="{ 'show': open }" x-show="open"
                            x-transition>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <i class="isax isax-document-text text-danger me-2"></i>
                                    Download as PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <i class="isax isax-document-download text-success me-2"></i>
                                    Download as Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="card mb-4 overflow-hidden border-0 shadow-sm"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body position-relative p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h5 class="fw-semibold mb-2 text-white">Good Morning , {{ Auth::user()->name }}! 👋</h5>
                            <p class="mb-3 text-white opacity-90">You have <span class="fw-semibold">15 pending
                                    invoices</span> saved to draft that need to be sent to customers</p>
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center text-white">
                                    <i class="isax isax-calendar me-2"></i>
                                    <span class="fs-14">Friday, 24 Mar 2025</span>
                                </div>
                                <div class="d-flex align-items-center text-white">
                                    <i class="isax isax-clock me-2"></i>
                                    <span class="fs-14">11:24 AM</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            <div class="row g-3 mb-4">
                <!-- Overview Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary-subtle rounded-2 me-2 p-2">
                                    <i class="isax isax-category text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-0">Overview</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document-text-1 text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Invoices</p>
                                            <h5 class="fw-bold mb-0">{{ number_format($totalInvoices) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-profile-2user text-success"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Customers</p>
                                            <h5 class="fw-bold mb-0">{{ number_format($totalCustomers) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-dcube text-warning"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Amount Due</p>
                                            <h5 class="fw-bold mb-0">{{ number_format($totalAmountDue) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document-text text-info"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Quotations</p>
                                            <h5 class="fw-bold mb-0">2,150</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Analytics Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success-subtle rounded-2 me-2 p-2">
                                    <i class="isax isax-chart-21 text-success"></i>
                                </div>
                                <h6 class="fw-semibold mb-0">Sales Analytics</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document-forward text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Total Sales</p>
                                            <h5 class="fw-bold mb-0">₦40,569</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-programming-arrow text-success"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Purchase</p>
                                            <h5 class="fw-bold mb-0">₦154,220</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-dollar-circle text-warning"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Expenses</p>
                                            <h5 class="fw-bold mb-0">₦10,041</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-flag text-info"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Credits</p>
                                            <h5 class="fw-bold mb-0">₦12,150</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Statistics Card -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning-subtle rounded-2 me-2 p-2">
                                    <i class="isax isax-chart-success text-warning"></i>
                                </div>
                                <h6 class="fw-semibold mb-0">Invoice Statistics</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Invoiced</p>
                                            <h5 class="fw-bold mb-0">₦{{ number_format($invoiced) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document-forward text-success"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Received</p>
                                            <h5 class="fw-bold mb-0">₦{{ number_format($received) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-document-previous text-warning"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Outstanding</p>
                                            <h5 class="fw-bold mb-0">₦{{ number_format($outstanding) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-danger-subtle rounded-2 me-2 flex-shrink-0 p-2">
                                            <i class="isax isax-dislike text-danger"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted fs-13 mb-1">Overdue</p>
                                            <h5 class="fw-bold mb-0">₦{{ number_format($overdue) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Highlighted Cards Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card position-relative overflow-hidden border-0 shadow-sm"
                        style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <p class="text-muted fs-14 mb-2">Total Products</p>
                                    <h4 class="fw-bold mb-1">{{ $totalProducts }}</h4>
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="fa fa-arrow-up me-1"></i>+45
                                    </span>
                                </div>
                                <div class="bg-primary rounded-3 p-3">
                                    <i class="isax isax-box fs-4 text-white"></i>
                                </div>
                            </div>
                            <a href="{{ route('product.index') }}" class="btn btn-sm btn-primary w-100">View
                                Inventory</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card position-relative overflow-hidden border-0 shadow-sm"
                        style="background: linear-gradient(135deg, #f093fb15 0%, #f5576c15 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <p class="text-muted fs-14 mb-2">Total Sales</p>
                                    <h4 class="fw-bold mb-1">645</h4>
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="fa fa-arrow-up me-1"></i>+45
                                    </span>
                                </div>
                                <div class="bg-danger rounded-3 p-3">
                                    <i class="isax isax-chart fs-4 text-white"></i>
                                </div>
                            </div>
                            <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-danger w-100">View Invoices</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card position-relative overflow-hidden border-0 shadow-sm"
                        style="background: linear-gradient(135deg, #4facfe15 0%, #00f2fe15 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <p class="text-muted fs-14 mb-2">Total Quotations</p>
                                    <h4 class="fw-bold mb-1">128</h4>
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="fa fa-arrow-up me-1"></i>+45
                                    </span>
                                </div>
                                <div class="bg-info rounded-3 p-3">
                                    <i class="isax isax-document-text fs-4 text-white"></i>
                                </div>
                            </div>
                            <a href="quotations.html" class="btn btn-sm btn-info w-100">View All</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue & Customers Row -->

            <div>
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-semibold mb-0">Top Customers</h6>
                            <a href="{{ route('customer.index') }}" class="text-primary fs-14">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table-hover mb-0 table align-middle">
                                <tbody>
                                    @forelse($topCustomers as $customer)
                                        <tr>
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar avatar-md rounded-circle me-3 flex-shrink-0 overflow-hidden">
                                                        <img src="{{ $customer->avatar_url ?? asset('assets/img/users/default.jpg') }}"
                                                            alt="{{ $customer->name }}">
                                                    </div>
                                                    <div>
                                                        <h6 class="fs-14 mb-0">{{ $customer->name }}</h6>
                                                        <small class="text-muted">{{ $customer->invoices_count }}
                                                            Invoices</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0 text-end">
                                                <p class="text-muted fs-13 mb-0">Total Paid</p>
                                                <h6 class="fw-semibold mb-0">
                                                    ₦{{ number_format($customer->total_paid, 2) }}</h6>
                                            </td>
                                            <td class="border-0 text-end">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                                                        class="btn btn-sm btn-light" title="New Invoice">
                                                        <i class="isax isax-add-circle"></i>
                                                    </a>
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                        class="btn btn-sm btn-light" title="View Customer Details">
                                                        <i class="isax isax-user"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted py-3 text-center">
                                                No customers found yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('customer.index') }}" class="btn btn-light w-100 mt-3">View All Customers</a>
                    </div>
                </div>

            </div>

            <!-- Recent Invoices -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h6 class="fw-semibold mb-1">Recent Invoices</h6>
                            <p class="text-muted fs-13 mb-0">Latest invoice transactions</p>
                        </div>
                        <a href="{{ route('invoice.index') }}" class="btn btn-primary">View All Invoices</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Created On</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Paid</th>
                                    <th class="border-0">Payment Mode</th>
                                    <th class="border-0">Due Date</th>
                                    <th class="border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="{{ route('invoice.show', $invoice->id) }}"
                                                class="badge bg-primary-subtle text-primary fw-medium">
                                                {{ $invoice->invoice_number ?? 'INV' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                                    <img src="{{ $invoice->customer->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($invoice->customer->name ?? 'N/A') }}"
                                                        alt="{{ $invoice->customer->name ?? 'N/A' }}">
                                                </div>
                                                <h6 class="fs-14 mb-0">{{ $invoice->customer->name ?? 'N/A' }}</h6>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $invoice->created_at->format('d M Y') }}</td>
                                        <td class="fw-semibold">₦{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td class="text-success">₦{{ number_format($invoice->amount_paid ?? 0, 2) }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">
                                                {{ ucfirst($invoice->payment_mode ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="text-muted">
                                            {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '—' }}
                                        </td>
                                        <td>
                                            @if ($invoice->status === 'paid')
                                                <span class="badge bg-success-subtle text-success">Paid</span>
                                            @elseif ($invoice->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                                            @elseif ($invoice->status === 'overdue')
                                                <span class="badge bg-danger-subtle text-danger">Overdue</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary">{{ ucfirst($invoice->status ?? 'Unknown') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-muted py-4 text-center">No recent invoices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Bottom Row: Transactions, Quotations, Sales Stats -->
            <div class="row g-3 mb-4">
                <!-- Recent Transactions -->
                <div>
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="fw-semibold mb-0">Recent Transactions</h6>
                                <a href="transactions.html" class="text-primary fs-13">View All</a>
                            </div>

                            <h6 class="fs-13 fw-semibold text-muted mb-3">TODAY</h6>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-subtle rounded-2 me-3 p-2">
                                            <i class="isax isax-arrow-down text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-0">Andrew James</h6>
                                            <small class="text-muted">#INV45478</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success fw-semibold">+₦989</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger-subtle rounded-2 me-3 p-2">
                                            <i class="isax isax-arrow-up text-danger"></i>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-0">John Carter</h6>
                                            <small class="text-muted">#INV45477</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger-subtle text-danger fw-semibold">-₦300</span>
                                </div>
                            </div>

                            <h6 class="fs-13 fw-semibold text-muted mb-3">YESTERDAY</h6>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success-subtle rounded-2 me-3 p-2">
                                            <i class="isax isax-arrow-down text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-0">Sophia White</h6>
                                            <small class="text-muted">#INV45476</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success fw-semibold">+₦669</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-subtle rounded-2 me-3 p-2">
                                            <i class="isax isax-arrow-down text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-0">Daniel Martinez</h6>
                                            <small class="text-muted">#INV45475</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success fw-semibold">+₦474</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Statistics -->
                <div class="col-lg-4">
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <p class="text-muted fs-14 mb-1">Total Invoice Income</p>
                                    <h4 class="fw-bold mb-0">₦98,545</h4>
                                </div>
                                <div class="text-end">
                                    <h6 class="fw-semibold text-success mb-0">
                                        <i class="fa fa-arrow-up me-1"></i>30.2%
                                    </h6>
                                    <small class="text-muted">vs Last Week</small>
                                </div>
                            </div>
                            <div id="invoice_income" style="height: 80px;"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Custom Styles -->
        <style>
            .card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
            }

            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
                cursor: pointer;
            }

            .badge {
                font-weight: 500;
                padding: 0.375rem 0.75rem;
            }

            .avatar {
                transition: transform 0.2s ease;
            }

            .avatar:hover {
                transform: scale(1.05);
            }

            .dropdown-menu {
                border: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .dropdown-item {
                padding: 0.625rem 1rem;
                transition: all 0.2s ease;
            }

            .dropdown-item:hover {
                background-color: #f8f9fa;
                padding-left: 1.25rem;
            }

            .btn {
                transition: all 0.2s ease;
            }

            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
        </style>
    @endsection
