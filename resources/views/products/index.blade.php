@extends('layouts.app')
@section('content')
    <div class="">
        <div class="">

            <!-- Success Message with Animation -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 5000)">
                    <i class="isax isax-tick-circle me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" @click="show = false"></button>
                </div>
            @endif

            <!-- Page Header with Better Spacing -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-1 fw-semibold">Products</h4>
                    <p class="text-muted mb-0 fs-14">Manage your inventory and product catalog</p>
                </div>
                <div class="d-flex align-items-center gap-2">
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

                    <!-- New Product Button -->
                    <a href="{{ route('product.create') }}" class="btn btn-primary d-inline-flex align-items-center shadow-sm">
                        <i class="isax isax-add-circle me-2"></i>
                        <span>New Product</span>
                    </a>
                </div>
            </div>

            <!-- Search and Filter Section with Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Search Bar -->
                        <div class="col-lg-4 col-md-6">
                            <div class="position-relative">
                                <input type="text"
                                       class="form-control ps-5"
                                       placeholder="Search products..."
                                       x-data
                                       x-ref="searchInput">
                                <i class="isax isax-search-normal position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-lg-2 col-md-3 col-6">
                            <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#customcanvas">
                                <i class="isax isax-filter me-2"></i>
                                <span>Filter</span>
                            </button>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="col-lg-3 col-md-3 col-6" x-data="{ open: false, selected: 'Latest' }" @click.away="open = false">
                            <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between"
                                    @click="open = !open"
                                    type="button">
                                <span class="d-flex align-items-center">
                                    <i class="isax isax-sort me-2"></i>
                                    <span x-text="selected"></span>
                                </span>
                                <i class="fa-solid fa-chevron-down fs-12"></i>
                            </button>
                            <ul class="dropdown-menu w-100 shadow-sm"
                                :class="{ 'show': open }"
                                x-show="open"
                                x-transition>
                                <li>
                                    <a href="javascript:void(0);"
                                       class="dropdown-item"
                                       @click="selected = 'Latest'; open = false">Latest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"
                                       class="dropdown-item"
                                       @click="selected = 'Oldest'; open = false">Oldest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"
                                       class="dropdown-item"
                                       @click="selected = 'Name (A-Z)'; open = false">Name (A-Z)</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"
                                       class="dropdown-item"
                                       @click="selected = 'Name (Z-A)'; open = false">Name (Z-A)</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Column Selector -->
                        <div class="col-lg-3 col-md-12" x-data="{ open: false }" @click.away="open = false">
                            <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between"
                                    @click="open = !open"
                                    type="button">
                                <span class="d-flex align-items-center">
                                    <i class="isax isax-grid-3 me-2"></i>
                                    <span>Columns</span>
                                </span>
                                <i class="fa-solid fa-chevron-down fs-12"></i>
                            </button>
                            <ul class="dropdown-menu w-100 shadow-sm"
                                :class="{ 'show': open }"
                                x-show="open"
                                x-transition
                                @click.stop>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Code</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Product Name</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Type</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Category</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Unit</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                        <span>Quantity</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Selling Price</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="dropdown-item d-flex align-items-center form-switch mb-0">
                                        <input class="form-check-input m-0 me-2" type="checkbox">
                                        <span>Purchase Price</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    <div class="d-flex align-items-center flex-wrap gap-2 mt-3" x-data="{ filters: ['Electronics', 'In Stock', 'Price: $0-$100'] }">
                        <span class="text-muted fs-13 fw-medium me-1">Active Filters:</span>
                        <template x-for="(filter, index) in filters" :key="index">
                            <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-2 px-3 py-2">
                                <span x-text="filter"></span>
                                <button type="button"
                                        class="btn-close btn-close-sm"
                                        style="font-size: 10px;"
                                        @click="filters.splice(index, 1)"></button>
                            </span>
                        </template>
                        <a href="javascript:void(0);"
                           class="text-danger fs-13 fw-medium text-decoration-none"
                           x-show="filters.length > 0"
                           @click="filters = []">
                            Clear All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th class="border-0 py-3">Code</th>
                                    <th class="border-0 py-3">Product</th>
                                    <th class="border-0 py-3">Type</th>
                                    <th class="border-0 py-3">Category</th>
                                    <th class="border-0 py-3">Unit</th>
                                    <th class="border-0 py-3">Quantity</th>
                                    <th class="border-0 py-3">Selling Price</th>
                                    <th class="border-0 py-3">Purchase Price</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3 pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-primary border border-primary fw-medium">
                                                {{ $product->code }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm rounded me-3 bg-light p-2">
                                                    <i class="isax isax-box text-primary fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14 fw-medium">{{ $product->name }}</h6>
                                                    <small class="text-muted">SKU: {{ $product->code }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $product->type === 'product' ? 'primary' : 'info' }}-subtle text-{{ $product->type === 'product' ? 'primary' : 'info' }} px-3 py-2">
                                                {{ ucfirst($product->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $product->category }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->unit }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $product->quantity > 50 ? 'bg-success-subtle text-success' : ($product->quantity > 10 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }} px-3 py-2">
                                                {{ $product->quantity }} units
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-medium text-dark">₦{{ number_format($product->selling_price, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">₦{{ number_format($product->purchase_price, 2) }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" checked>
                                            </div>
                                        </td>
                                        <td class="pe-4" x-data="{ open: false }" @click.away="open = false">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                   class="btn btn-sm btn-light d-inline-flex align-items-center"
                                                   title="Edit">
                                                    <i class="isax isax-edit"></i>
                                                </a>

                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-sm btn-light"
                                                            @click="open = !open"
                                                            type="button">
                                                        <i class="isax isax-more"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                                                        :class="{ 'show': open }"
                                                        x-show="open"
                                                        x-transition>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                                                                <i class="isax isax-eye me-2 text-info"></i>
                                                                View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('product.edit', $product->id) }}" class="dropdown-item d-flex align-items-center">
                                                                <i class="isax isax-edit me-2 text-primary"></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                                                                <i class="isax isax-copy me-2 text-success"></i>
                                                                Duplicate
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                               class="dropdown-item d-flex align-items-center text-danger"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#delete_modal">
                                                                <i class="isax isax-trash me-2"></i>
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5">
                                            <div class="py-5">
                                                <div class="mb-4">
                                                    <i class="isax isax-box-1 text-muted" style="font-size: 64px;"></i>
                                                </div>
                                                <h5 class="mb-2">No Products Yet</h5>
                                                <p class="text-muted mb-4">Get started by adding your first product to the inventory</p>
                                                <a href="{{ route('product.create') }}" class="btn btn-primary">
                                                    <i class="isax isax-add-circle me-2"></i>Add Your First Product
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- @if($products->isNotEmpty())
                        <div class="d-flex align-items-center justify-content-between border-top p-4">
                            <div class="text-muted fs-14">
                                Showing <span class="fw-medium">{{ $products->firstItem() }}</span> to
                                <span class="fw-medium">{{ $products->lastItem() }}</span> of
                                <span class="fw-medium">{{ $products->total() }}</span> results
                            </div>
                            <div>
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>

        </div>




    </div>

    <!-- Add custom styles for better visual -->
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .table > tbody > tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .dropdown-menu {
            border: 1px solid #e9ecef;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.075);
        }

        .dropdown-item {
            padding: 0.625rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            padding-left: 1.25rem;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
