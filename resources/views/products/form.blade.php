@extends('layouts.app')

@section('content')
<div class="">
    <div class="">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-semibold mb-1">
                    {{ isset($product) ? 'Edit Product / Service' : 'Add Product / Service' }}
                </h4>
                <p class="text-muted fs-14 mb-0">
                    {{ isset($product) ? 'Update product or service details' : 'Create a new product or service in your inventory' }}
                </p>
            </div>
            <div>
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                    <i class="isax isax-arrow-left me-2"></i>
                    <span>Back to Products</span>
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
                <i class="isax isax-tick-circle fs-5 me-3"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <div class="d-flex align-items-start">
                    <i class="isax isax-danger fs-5 me-3"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-2">Please fix the following errors:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <!-- Product Type -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Product Type</h6>
                        <div class="row g-3">

                            <!-- Product -->
                            <div class="col-md-6">
                                <label class="form-check-card w-100">
                                    <input type="radio" name="type" value="product"
                                        {{ old('type', $product->type ?? '') === 'product' ? 'checked' : '' }}>
                                    <div class="card border-2 {{ old('type', $product->type ?? '') === 'product' ? 'border-primary bg-primary-subtle' : '' }}">
                                        <div class="card-body py-4 text-center">
                                            <i class="isax isax-box fs-1 mb-3 text-primary"></i>
                                            <h6 class="mb-1">Product</h6>
                                            <small class="text-muted">Physical goods with inventory tracking</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Service -->
                            <div class="col-md-6">
                                <label class="form-check-card w-100">
                                    <input type="radio" name="type" value="service"
                                        {{ old('type', $product->type ?? '') === 'service' ? 'checked' : '' }}>
                                    <div class="card border-2 {{ old('type', $product->type ?? '') === 'service' ? 'border-info bg-info-subtle' : '' }}">
                                        <div class="card-body py-4 text-center">
                                            <i class="isax isax-briefcase fs-1 mb-3 text-info"></i>
                                            <h6 class="mb-1">Service</h6>
                                            <small class="text-muted">Non-physical service or consulting</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Basic Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $product->name ?? '') }}" placeholder="Enter name">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control"
                                   value="{{ old('code', $product->code ?? '') }}" placeholder="e.g. P001">
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <select name="category" class="form-select">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ old('category', $product->category ?? '') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unit -->
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Unit</label>
                            <select name="unit" class="form-select">
                                <option value="">-- Select Unit --</option>
                                @foreach (['pcs', 'kg', 'litre', 'hrs', 'set', 'box', 'meter'] as $unit)
                                    <option value="{{ $unit }}"
                                        {{ old('unit', $product->unit ?? '') == $unit ? 'selected' : '' }}>
                                        {{ ucfirst($unit) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Pricing -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Selling Price (₦)</label>
                            <input type="number" name="selling_price" step="0.01" class="form-control"
                                   value="{{ old('selling_price', $product->selling_price ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Purchase Price (₦)</label>
                            <input type="number" name="purchase_price" step="0.01" class="form-control"
                                   value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
                        </div>

                        <!-- Quantity (Only show if Product) -->
                        @php
                            $showQuantity = old('type', $product->type ?? '') === 'product';
                        @endphp
                        @if ($showQuantity)
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Quantity</label>
                                <input type="number" name="quantity" min="0" class="form-control"
                                       value="{{ old('quantity', $product->quantity ?? 0) }}">
                            </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <!-- Image -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Upload Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        @if(isset($product) && $product->image)
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Current Image</label>
                                <div class="bg-light rounded border p-3 text-center">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                         style="max-height:150px;object-fit:cover;">
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                            <i class="isax isax-close-circle me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="isax isax-tick-circle me-2"></i>
                            {{ isset($product) ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
