@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-400 mr-2"></i>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                        <button type="button" @click="show = false" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                        <p class="mt-2 text-gray-600">Manage your inventory and product catalog</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Export Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                <i class="fas fa-download text-gray-500"></i>
                                Export
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-pdf mr-3 text-red-500"></i>
                                        Download as PDF
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-excel mr-3 text-green-500"></i>
                                        Download as Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- New Product Button -->
                        <a href="{{ route('product.create') }}"
                           class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            <i class="fas fa-plus"></i>
                            New Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Search Bar -->
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text"
                                   class="block w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Search products...">
                        </div>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{ open: false, selected: 'Latest' }">
                        <button @click="open = !open"
                                class="flex w-full items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-sort text-gray-500"></i>
                                <span x-text="selected"></span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             class="absolute left-0 right-0 z-10 mt-2 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="javascript:void(0);"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   @click="selected = 'Latest'; open = false">Latest</a>
                                <a href="javascript:void(0);"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   @click="selected = 'Oldest'; open = false">Oldest</a>
                                <a href="javascript:void(0);"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   @click="selected = 'Name (A-Z)'; open = false">Name (A-Z)</a>
                                <a href="javascript:void(0);"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   @click="selected = 'Name (Z-A)'; open = false">Name (Z-A)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    <input type="checkbox"
                                           id="select-all"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Code
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Product
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Type
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Category
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Unit
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Quantity
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Selling Price
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Purchase Price
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <input type="checkbox"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full border border-blue-300 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                            {{ $product->code }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                                <i class="fas fa-box text-blue-600 text-sm"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500">SKU: {{ $product->code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                            {{ $product->type === 'product' ? 'bg-blue-100 text-blue-800' : 'bg-cyan-100 text-cyan-800' }}">
                                            {{ ucfirst($product->type) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        {{ $product->category }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $product->unit }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                            {{ $product->quantity > 50 ? 'bg-green-100 text-green-800' :
                                               ($product->quantity > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $product->quantity }} {{ $product->unit }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        ₦{{ number_format($product->selling_price, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        ₦{{ number_format($product->purchase_price, 2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('product.edit', $product->id) }}"
                                               class="rounded-lg bg-gray-100 p-2 text-gray-600 transition-colors hover:bg-gray-200 hover:text-gray-900"
                                               title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('product.destroy', $product->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"
                                                        class="rounded-lg bg-red-50 p-2 text-red-600 transition-colors hover:bg-red-100 hover:text-red-900"
                                                        title="Delete">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-box text-4xl mb-4 opacity-20"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">No Products Yet</p>
                                            <p class="text-sm text-gray-600 mb-4">Get started by adding your first product to the inventory</p>
                                            <a href="{{ route('product.create') }}"
                                               class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                                <i class="fas fa-plus mr-2"></i>
                                                Add Your First Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->isNotEmpty())
                    <div class="border-t border-gray-200 px-6 py-4">
                        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $products->firstItem() }}</span> to
                                <span class="font-medium">{{ $products->lastItem() }}</span> of
                                <span class="font-medium">{{ $products->total() }}</span> results
                            </div>
                            <div class="flex items-center gap-2">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Select all checkboxes
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Search functionality (you can implement this based on your needs)
        const searchInput = document.querySelector('input[placeholder="Search products..."]');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Implement search logic here
                    console.log('Searching for:', this.value);
                }, 500);
            });
        }
    </script>

    <!-- Alpine.js for dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
