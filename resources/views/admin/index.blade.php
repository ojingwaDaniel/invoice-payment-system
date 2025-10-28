@extends('layouts.app')
@section('content')
    <div class="">
        <div class="">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-semibold">Dashboard</h4>
                <p class="text-muted mb-0 fs-14">Welcome back! Here's your business overview</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Create New Dropdown -->
                <div class="dropdown" x-data="{ open: false }" @click.away="open = false">
                    <button class="btn btn-primary d-inline-flex align-items-center shadow-sm"
                            @click="open = !open"
                            type="button">
                        <i class="isax isax-add-circle me-2"></i>
                        <span>Create New</span>
                        <i class="fa-solid fa-chevron-down ms-2 fs-12"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                        :class="{ 'show': open }"
                        x-show="open"
                        x-transition>
                        <li>
                            <a href="add-invoice.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-text-1 me-3 text-primary"></i>
                                <div>
                                    <div class="fw-medium">Invoice</div>
                                    <small class="text-muted">Create new invoice</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="expenses.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-send me-3 text-danger"></i>
                                <div>
                                    <div class="fw-medium">Expense</div>
                                    <small class="text-muted">Record expense</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="add-credit-notes.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-add me-3 text-success"></i>
                                <div>
                                    <div class="fw-medium">Credit Note</div>
                                    <small class="text-muted">Issue credit note</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="add-debit-notes.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-recive me-3 text-warning"></i>
                                <div>
                                    <div class="fw-medium">Debit Note</div>
                                    <small class="text-muted">Issue debit note</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="add-purchases-orders.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document me-3 text-info"></i>
                                <div>
                                    <div class="fw-medium">Purchase Order</div>
                                    <small class="text-muted">Create PO</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="add-quotation.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-download me-3 text-purple"></i>
                                <div>
                                    <div class="fw-medium">Quotation</div>
                                    <small class="text-muted">Send quotation</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="add-delivery-challan.html" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-forward me-3 text-secondary"></i>
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
                    <button class="btn btn-outline-secondary d-inline-flex align-items-center"
                            @click="open = !open"
                            type="button">
                        <i class="isax isax-export-1 me-2"></i>
                        <span>Export</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                        :class="{ 'show': open }"
                        x-show="open"
                        x-transition>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                <i class="isax isax-document-text me-2 text-danger"></i>
                                Download as PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                <i class="isax isax-document-download me-2 text-success"></i>
                                Download as Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Welcome Banner -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h5 class="mb-2 text-white fw-semibold">Good Morning, Jafna Cremson! 👋</h5>
                        <p class="mb-3 text-white opacity-90">You have <span class="fw-semibold">15 pending invoices</span> saved to draft that need to be sent to customers</p>
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
                    <div class="col-lg-4 d-none d-lg-block text-end">
                        <img src="assets/img/icons/dashboard.svg" alt="Dashboard" class="img-fluid" style="max-height: 150px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row g-3 mb-4">
            <!-- Overview Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-2 bg-primary-subtle rounded-2 me-2">
                                <i class="isax isax-category text-primary"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Overview</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-primary-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document-text-1 text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Invoices</p>
                                        <h5 class="mb-0 fw-bold">1,041</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-success-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-profile-2user text-success"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Customers</p>
                                        <h5 class="mb-0 fw-bold">3,462</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-warning-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-dcube text-warning"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Amount Due</p>
                                        <h5 class="mb-0 fw-bold">₦1,642</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-info-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document-text text-info"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Quotations</p>
                                        <h5 class="mb-0 fw-bold">2,150</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Analytics Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-2 bg-success-subtle rounded-2 me-2">
                                <i class="isax isax-chart-21 text-success"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Sales Analytics</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-primary-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document-forward text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Total Sales</p>
                                        <h5 class="mb-0 fw-bold">₦40,569</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-success-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-programming-arrow text-success"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Purchase</p>
                                        <h5 class="mb-0 fw-bold">₦154,220</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-warning-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-dollar-circle text-warning"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Expenses</p>
                                        <h5 class="mb-0 fw-bold">₦10,041</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-info-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-flag text-info"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Credits</p>
                                        <h5 class="mb-0 fw-bold">₦12,150</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Statistics Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-2 bg-warning-subtle rounded-2 me-2">
                                <i class="isax isax-chart-success text-warning"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Invoice Statistics</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-primary-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Invoiced</p>
                                        <h5 class="mb-0 fw-bold">₦21,132</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-success-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document-forward text-success"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Received</p>
                                        <h5 class="mb-0 fw-bold">₦10,763</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-warning-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-document-previous text-warning"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Outstanding</p>
                                        <h5 class="mb-0 fw-bold">₦8,041</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-danger-subtle rounded-2 me-2 flex-shrink-0">
                                        <i class="isax isax-dislike text-danger"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1 fs-13">Overdue</p>
                                        <h5 class="mb-0 fw-bold">₦41,811</h5>
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
                <div class="card border-0 shadow-sm overflow-hidden position-relative"
                     style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="text-muted mb-2 fs-14">Total Products</p>
                                <h4 class="mb-1 fw-bold">897</h4>
                                <span class="badge bg-success-subtle text-success">
                                    <i class="fa fa-arrow-up me-1"></i>+45
                                </span>
                            </div>
                            <div class="p-3 bg-primary rounded-3">
                                <i class="isax isax-box text-white fs-4"></i>
                            </div>
                        </div>
                        <a href="inventory.html" class="btn btn-sm btn-primary w-100">View Inventory</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm overflow-hidden position-relative"
                     style="background: linear-gradient(135deg, #f093fb15 0%, #f5576c15 100%);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="text-muted mb-2 fs-14">Total Sales</p>
                                <h4 class="mb-1 fw-bold">645</h4>
                                <span class="badge bg-success-subtle text-success">
                                    <i class="fa fa-arrow-up me-1"></i>+45
                                </span>
                            </div>
                            <div class="p-3 bg-danger rounded-3">
                                <i class="isax isax-chart text-white fs-4"></i>
                            </div>
                        </div>
                        <a href="invoices.html" class="btn btn-sm btn-danger w-100">View Invoices</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm overflow-hidden position-relative"
                     style="background: linear-gradient(135deg, #4facfe15 0%, #00f2fe15 100%);">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="text-muted mb-2 fs-14">Total Quotations</p>
                                <h4 class="mb-1 fw-bold">128</h4>
                                <span class="badge bg-success-subtle text-success">
                                    <i class="fa fa-arrow-up me-1"></i>+45
                                </span>
                            </div>
                            <div class="p-3 bg-info rounded-3">
                                <i class="isax isax-document-text text-white fs-4"></i>
                            </div>
                        </div>
                        <a href="quotations.html" class="btn btn-sm btn-info w-100">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue & Customers Row -->
        <div class="row g-3 mb-4">
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h6 class="mb-1 fw-semibold">Revenue Overview</h6>
                                <p class="text-muted mb-0 fs-13">Total revenue this month</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle p-1 me-2"></span>
                                    <span class="fs-13 text-muted">Received</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary-subtle rounded-circle p-1 me-2"></span>
                                    <span class="fs-13 text-muted">Outstanding</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="mb-0 fw-bold me-2">₦897,000</h4>
                            <span class="badge bg-success-subtle text-success">
                                <i class="fa fa-arrow-up me-1"></i>+45%
                            </span>
                        </div>
                        <div id="revenue_chart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0 fw-semibold">Top Customers</h6>
                            <a href="customers.html" class="text-primary fs-14">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md rounded-circle me-3 flex-shrink-0 overflow-hidden">
                                                    <img src="assets/img/users/user-06.jpg" alt="Customer">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14">Emily Clark</h6>
                                                    <small class="text-muted">45 Invoices</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 text-end">
                                            <p class="mb-0 text-muted fs-13">Outstanding</p>
                                            <h6 class="mb-0 fw-semibold">₦3,589</h6>
                                        </td>
                                        <td class="border-0 text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="add-invoice.html" class="btn btn-sm btn-light" title="New Invoice">
                                                    <i class="isax isax-add-circle"></i>
                                                </a>
                                                <button class="btn btn-sm btn-light" title="Add Ledger">
                                                    <i class="isax isax-document-text-1"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md rounded-circle me-3 flex-shrink-0 overflow-hidden">
                                                    <img src="assets/img/users/user-01.jpg" alt="Customer">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14">John Smith</h6>
                                                    <small class="text-muted">16 Invoices</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 text-end">
                                            <p class="mb-0 text-muted fs-13">Outstanding</p>
                                            <h6 class="mb-0 fw-semibold">₦5,426</h6>
                                        </td>
                                        <td class="border-0 text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="add-invoice.html" class="btn btn-sm btn-light">
                                                    <i class="isax isax-add-circle"></i>
                                                </a>
                                                <button class="btn btn-sm btn-light">
                                                    <i class="isax isax-document-text-1"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md rounded-circle me-3 flex-shrink-0 overflow-hidden">
                                                    <img src="assets/img/users/user-38.jpg" alt="Customer">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14">Olivia Harris</h6>
                                                    <small class="text-muted">23 Invoices</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 text-end">
                                            <p class="mb-0 text-muted fs-13">Outstanding</p>
                                            <h6 class="mb-0 fw-semibold">₦1,493</h6>
                                        </td>
                                        <td class="border-0 text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="add-invoice.html" class="btn btn-sm btn-light">
                                                    <i class="isax isax-add-circle"></i>
                                                </a>
                                                <button class="btn btn-sm btn-light">
                                                    <i class="isax isax-document-text-1"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md rounded-circle me-3 flex-shrink-0 overflow-hidden">
                                                    <img src="assets/img/users/user-12.jpg" alt="Customer">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14">William Parker</h6>
                                                    <small class="text-muted">58 Invoices</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 text-end">
                                            <p class="mb-0 text-muted fs-13">Outstanding</p>
                                            <h6 class="mb-0 fw-semibold">₦7,854</h6>
                                        </td>
                                        <td class="border-0 text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="add-invoice.html" class="btn btn-sm btn-light">
                                                    <i class="isax isax-add-circle"></i>
                                                </a>
                                                <button class="btn btn-sm btn-light">
                                                    <i class="isax isax-document-text-1"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="customers.html" class="btn btn-light w-100 mt-3">View All Customers</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1 fw-semibold">Recent Invoices</h6>
                        <p class="text-muted mb-0 fs-13">Latest invoice transactions</p>
                    </div>
                    <a href="invoices.html" class="btn btn-primary">View All Invoices</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                            <tr>
                                <td>
                                    <a href="invoice-details.html" class="badge bg-primary-subtle text-primary fw-medium">INV00025</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                            <img src="assets/img/users/user-22.jpg" alt="img">
                                        </div>
                                        <h6 class="mb-0 fs-14">Emily Clark</h6>
                                    </div>
                                </td>
                                <td class="text-muted">22 Feb 2025</td>
                                <td class="fw-semibold">₦10,000</td>
                                <td class="text-success">₦5,000</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">Cash</span>
                                </td>
                                <td class="text-muted">04 Mar 2025</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="invoice-details.html" class="badge bg-primary-subtle text-primary fw-medium">INV00024</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                            <img src="assets/img/users/user-07.jpg" alt="img">
                                        </div>
                                        <h6 class="mb-0 fs-14">John Carter</h6>
                                    </div>
                                </td>
                                <td class="text-muted">07 Feb 2025</td>
                                <td class="fw-semibold">₦25,750</td>
                                <td class="text-success">₦5,000</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">Check</span>
                                </td>
                                <td class="text-muted">20 Feb 2025</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="invoice-details.html" class="badge bg-primary-subtle text-primary fw-medium">INV00023</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                            <img src="assets/img/users/user-16.jpg" alt="img">
                                        </div>
                                        <h6 class="mb-0 fs-14">Sophia White</h6>
                                    </div>
                                </td>
                                <td class="text-muted">09 Dec 2024</td>
                                <td class="fw-semibold">₦120,500</td>
                                <td class="text-success">₦60,000</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">Check</span>
                                </td>
                                <td class="text-muted">12 Nov 2024</td>
                                <td>
                                    <span class="badge bg-danger-subtle text-danger">Overdue</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="invoice-details.html" class="badge bg-primary-subtle text-primary fw-medium">INV00022</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                            <img src="assets/img/users/user-08.jpg" alt="img">
                                        </div>
                                        <h6 class="mb-0 fs-14">Michael Johnson</h6>
                                    </div>
                                </td>
                                <td class="text-muted">30 Nov 2024</td>
                                <td class="fw-semibold">₦750,300</td>
                                <td class="text-success">₦60,000</td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">Check</span>
                                </td>
                                <td class="text-muted">25 Oct 2024</td>
                                <td>
                                    <span class="badge bg-danger-subtle text-danger">Overdue</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="invoice-details.html" class="badge bg-primary-subtle text-primary fw-medium">INV00016</a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle me-2 flex-shrink-0 overflow-hidden">
                                            <img src="assets/img/users/user-15.jpg" alt="img">
                                        </div>
                                        <h6 class="mb-0 fs-14">Daniel Martinez</h6>
                                    </div>
                                </td>
                                <td class="text-muted">12 Oct 2024</td>
                                <td class="fw-semibold">₦999,999</td>
                                <td class="text-success">₦400,000</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">Cash</span>
                                </td>
                                <td class="text-muted">18 Oct 2024</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Transactions, Quotations, Sales Stats -->
        <div class="row g-3 mb-4">
            <!-- Recent Transactions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0 fw-semibold">Recent Transactions</h6>
                            <a href="transactions.html" class="text-primary fs-13">View All</a>
                        </div>

                        <h6 class="fs-13 fw-semibold text-muted mb-3">TODAY</h6>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-primary-subtle rounded-2 me-3">
                                        <i class="isax isax-arrow-down text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-14">Andrew James</h6>
                                        <small class="text-muted">#INV45478</small>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-semibold">+₦989</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-danger-subtle rounded-2 me-3">
                                        <i class="isax isax-arrow-up text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-14">John Carter</h6>
                                        <small class="text-muted">#INV45477</small>
                                    </div>
                                </div>
                                <span class="badge bg-danger-subtle text-danger fw-semibold">-₦300</span>
                            </div>
                        </div>

                        <h6 class="fs-13 fw-semibold text-muted mb-3">YESTERDAY</h6>
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-success-subtle rounded-2 me-3">
                                        <i class="isax isax-arrow-down text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-14">Sophia White</h6>
                                        <small class="text-muted">#INV45476</small>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-semibold">+₦669</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-primary-subtle rounded-2 me-3">
                                        <i class="isax isax-arrow-down text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-14">Daniel Martinez</h6>
                                        <small class="text-muted">#INV45475</small>
                                    </div>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-semibold">+₦474</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quotations -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0 fw-semibold">Recent Quotations</h6>
                            <a href="quotations.html" class="text-primary fs-13">View All</a>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded-circle me-3 overflow-hidden">
                                    <img src="assets/img/users/user-02.jpg" alt="img">
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-14">Emily Clark</h6>
                                    <small class="text-muted">QU0014</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success-subtle text-success mb-1">
                                    <i class="fa fa-check me-1"></i>Accepted
                                </span>
                                <p class="mb-0 text-muted fs-13">25 Mar 2025</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded-circle me-3 overflow-hidden">
                                    <img src="assets/img/users/user-07.jpg" alt="img">
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-14">David Anderson</h6>
                                    <small class="text-muted">QU0147</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-info-subtle text-info mb-1">
                                    <i class="fa fa-paper-plane me-1"></i>Sent
                                </span>
                                <p class="mb-0 text-muted fs-13">12 Feb 2025</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded-circle me-3 overflow-hidden">
                                    <img src="assets/img/users/user-16.jpg" alt="img">
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-14">Sophia White</h6>
                                    <small class="text-muted">QU1947</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-secondary-subtle text-secondary mb-1">
                                    <i class="fa fa-clock me-1"></i>Expired
                                </span>
                                <p class="mb-0 text-muted fs-13">08 Mar 2025</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded-circle me-3 overflow-hidden">
                                    <img src="assets/img/users/user-08.jpg" alt="img">
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-14">Michael Johnson</h6>
                                    <small class="text-muted">QU2842</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger-subtle text-danger mb-1">
                                    <i class="fa fa-times me-1"></i>Declined
                                </span>
                                <p class="mb-0 text-muted fs-13">31 Jan 2025</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded-circle me-3 overflow-hidden">
                                    <img src="assets/img/users/user-22.jpg" alt="img">
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-14">Emily Clark</h6>
                                    <small class="text-muted">QU7868</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success-subtle text-success mb-1">
                                    <i class="fa fa-check me-1"></i>Accepted
                                </span>
                                <p class="mb-0 text-muted fs-13">18 Jan 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Statistics -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="text-muted mb-1 fs-14">Total Invoice Income</p>
                                <h4 class="mb-0 fw-bold">₦98,545</h4>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0 fw-semibold text-success">
                                    <i class="fa fa-arrow-up me-1"></i>30.2%
                                </h6>
                                <small class="text-muted">vs Last Week</small>
                            </div>
                        </div>
                        <div id="invoice_income" style="height: 80px;"></div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3 fw-semibold">Top Sales Statistics</h6>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary rounded-circle p-1 me-2"></span>
                                <span class="fs-13">Dell XPS 13</span>
                            </div>
                            <span class="fw-semibold fs-14">45%</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary rounded-circle p-1 me-2"></span>
                                <span class="fs-13">Nike T-shirt</span>
                            </div>
                            <span class="fw-semibold fs-14">30%</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success rounded-circle p-1 me-2"></span>
                                <span class="fs-13">Apple iPhone 15</span>
                            </div>
                            <span class="fw-semibold fs-14">25%</span>
                        </div>
                        <div id="total_sales" style="height: 150px;" class="mt-3"></div>
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
