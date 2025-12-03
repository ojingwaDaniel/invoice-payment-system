@extends('layouts.app')

@section('content')
    <div>
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h4 class="mb-1 text-2xl font-semibold">
                    {{ isset($product) ? 'Edit Product / Service' : 'Add Product / Service' }}
                </h4>
                <p class="text-sm text-gray-600">
                    {{ isset($product) ? 'Update product or service details' : 'Create a new product or service in your inventory' }}
                </p>
            </div>
            <div>
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Products</span>
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mb-6 flex items-center rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800">
                <div class="flex items-start">
                    <svg class="mr-3 mt-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-grow">
                        <h6 class="mb-2 font-semibold">Please fix the following errors:</h6>
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="rounded-lg bg-white shadow-sm">
            <div class="p-6" x-data="{ type: '{{ old('type', $product->type ?? 'product') }}' }">

                <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <!-- Product Type -->
                    <div class="mb-6">
                        <h6 class="mb-4 text-lg font-semibold">Product Type</h6>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            <!-- Product -->
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="product" x-model="type" class="sr-only"
                                    {{ old('type', $product->type ?? 'product') === 'product' ? 'checked' : '' }}>
                                <div class="rounded-lg border-2 transition-all"
                                    :class="type === 'product' ? 'border-blue-500 bg-blue-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="p-6 text-center">
                                        <svg class="mx-auto mb-3 h-12 w-12 text-blue-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <h6 class="mb-1 font-semibold">Product</h6>
                                        <small class="text-gray-600">Physical goods with inventory tracking</small>
                                    </div>
                                </div>
                            </label>

                            <!-- Service -->
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="service" x-model="type" class="sr-only"
                                    {{ old('type', $product->type ?? '') === 'service' ? 'checked' : '' }}>
                                <div class="rounded-lg border-2 transition-all"
                                    :class="type === 'service' ? 'border-cyan-500 bg-cyan-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <div class="p-6 text-center">
                                        <svg class="mx-auto mb-3 h-12 w-12 text-cyan-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <h6 class="mb-1 font-semibold">Service</h6>
                                        <small class="text-gray-600">Non-physical service or consulting</small>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <!-- Basic Info -->
                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-12">
                        <div class="md:col-span-8">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                value="{{ old('name', $product->name ?? '') }}" placeholder="Enter name">
                        </div>

                        <div class="md:col-span-4">
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="code"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                value="{{ old('code', $product->code ?? '') }}" placeholder="e.g. P001">
                        </div>

                        <!-- Category -->
                        <div class="md:col-span-6">
                            <label class="mb-2 block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unit -->
                        <div class="md:col-span-6">
                            <label class="mb-2 block text-sm font-medium text-gray-700">Unit</label>
                            <select name="unit"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Select Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->name }}"
                                        {{ old('unit', $product->unit ?? '') == $unit->name ? 'selected' : '' }}>
                                        {{ ucfirst($unit->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <!-- Pricing + Quantity -->
                    <div x-data="{ value: '{{ old('selling_price', $product->selling_price ?? '') }}' }">
                        <label class="mb-2 block text-sm font-medium text-gray-700">Selling Price (₦)</label>
                        <input type="text" name="selling_price" x-model="value"
                            x-on:input="
                   value = value.replace(/[^0-9.]/g,'');
                   let parts = value.split('.');
                   parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                   value = parts.join('.');
               "
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="0.00">
                    </div>

                    <!-- Purchase Price -->
                    <div x-data="{ value: '{{ old('purchase_price', $product->purchase_price ?? '') }}' }">
                        <label class="mb-2 block text-sm font-medium text-gray-700">Purchase Price (₦)</label>
                        <input type="text" name="purchase_price" x-model="value"
                            x-on:input="
                   value = value.replace(/[^0-9.]/g,'');
                   let parts = value.split('.');
                   parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                   value = parts.join('.');
               "
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="0.00">
                    </div>

                    <!-- Quantity -->
                    <div x-show="type === 'product'" x-transition>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="quantity" min="0"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            value="{{ old('quantity', $product->quantity ?? 0) }}">
                    </div>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Image -->
            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Upload Image (Optional)</label>
                    <input type="file" name="image"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        accept="image/*">
                </div>

                @if (isset($product) && $product->image)
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Current Image</label>
                        <div class="rounded-lg border border-gray-200 bg-gray-100 p-4 text-center">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="mx-auto max-h-40 rounded object-cover" alt="Product image">
                        </div>
                    </div>
                @endif
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-6 py-2 text-gray-700 hover:bg-gray-50">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ isset($product) ? 'Update Product' : 'Save Product' }}
                </button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
