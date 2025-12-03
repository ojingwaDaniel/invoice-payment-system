@extends('layouts.app')

@section('content')
    <div>
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h4 class="text-2xl font-semibold mb-1">
                    {{ isset($product) ? 'Edit Product / Service' : 'Add Product / Service' }}
                </h4>
                <p class="text-gray-600 text-sm">
                    {{ isset($product) ? 'Update product or service details' : 'Create a new product or service in your inventory' }}
                </p>
            </div>
            <div>
                <a href="{{ route('product.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to Products</span>
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="flex items-center p-4 mb-6 text-green-800 bg-green-50 border border-green-200 rounded-lg">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-red-800 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-grow">
                        <h6 class="font-semibold mb-2">Please fix the following errors:</h6>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6" x-data="{ type: '{{ old('type', $product->type ?? 'product') }}' }">

                <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <!-- Product Type -->
                    <div class="mb-6">
                        <h6 class="text-lg font-semibold mb-4">Product Type</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Product -->
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="product" x-model="type" class="sr-only"
                                    {{ old('type', $product->type ?? 'product') === 'product' ? 'checked' : '' }}>
                                <div class="border-2 rounded-lg transition-all"
                                    :class="type === 'product' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                    <div class="p-6 text-center">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <h6 class="font-semibold mb-1">Product</h6>
                                        <small class="text-gray-600">Physical goods with inventory tracking</small>
                                    </div>
                                </div>
                            </label>

                            <!-- Service -->
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="service" x-model="type" class="sr-only"
                                    {{ old('type', $product->type ?? '') === 'service' ? 'checked' : '' }}>
                                <div class="border-2 rounded-lg transition-all"
                                    :class="type === 'service' ? 'border-cyan-500 bg-cyan-50' : 'border-gray-200 hover:border-gray-300'">
                                    <div class="p-6 text-center">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <h6 class="font-semibold mb-1">Service</h6>
                                        <small class="text-gray-600">Non-physical service or consulting</small>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
                        <div class="md:col-span-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('name', $product->name ?? '') }}"
                                placeholder="Enter name">
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="code"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('code', $product->code ?? '') }}"
                                placeholder="e.g. P001">
                        </div>

                        <!-- Category -->
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <select name="unit"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price (₦)</label>
                            <input type="number" name="selling_price" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('selling_price', $product->selling_price ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Price (₦)</label>
                            <input type="number" name="purchase_price" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
                        </div>

                        <!-- Quantity -->
                        <div x-show="type === 'product'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="quantity" min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('quantity', $product->quantity ?? 0) }}">
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <!-- Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image (Optional)</label>
                            <input type="file" name="image"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*">
                        </div>

                        @if (isset($product) && $product->image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                                <div class="bg-gray-100 rounded-lg border border-gray-200 p-4 text-center">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="max-h-40 mx-auto rounded object-cover"
                                        alt="Product image">
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr class="my-6 border-gray-200">

                    <!-- Actions -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('product.index') }}"
                            class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ isset($product) ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
