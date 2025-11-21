@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ isset($invoice) ? 'Edit Invoice' : 'Create Invoice' }}
                        </h1>
                        <p class="mt-2 text-gray-600">
                            {{ isset($invoice) ? 'Update invoice details' : 'Create a new invoice for your customer' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Error / Alert Section -->
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                                <p class="text-sm font-medium text-red-700">Please fix the following errors:</p>
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800 ml-4">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Data Preparation --}}
            @php
                if (old('items')) {
                    $itemsData = old('items');
                    $discountData = old('discount', 0);
                    $taxRateData = old('tax_rate', 7.5);
                } elseif (isset($invoice)) {
                    $itemsData = $invoice->items
                        ->map(function ($item) {
                            return [
                                'product_id' => (int) $item->product_id,
                                'quantity' => (float) $item->quantity,
                                'unit' => $item->unit ?? '',
                                'rate' => (float) $item->rate,
                                'discount' => (float) ($item->discount ?? 0),
                                'amount' => (float) $item->amount,
                            ];
                        })
                        ->toArray();
                    $discountData = (float) ($invoice->discount ?? 0);
                    $taxRateData = (float) ($invoice->tax_rate ?? 7.5);
                } else {
                    $itemsData = [];
                    $discountData = 0;
                    $taxRateData = 7.5;
                }
            @endphp

            <form action="{{ isset($invoice) ? route('invoice.update', $invoice->id) : route('invoice.store') }}"
                method="POST" id="invoiceForm">
                @csrf
                @if (isset($invoice))
                    @method('PUT')
                @endif

                <!-- Invoice Details Card -->
                <div class="mb-6 rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Details</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                        <!-- Invoice Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Invoice Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="invoice_number"
                                value="{{ old('invoice_number', $invoice->invoice_number ?? ($invoice_number ?? '')) }}"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                readonly>
                        </div>

                        <!-- Customer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Customer <span class="text-red-500">*</span>
                            </label>
                            <select name="customer_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('customer_id', $invoice->customer_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} @if ($c->email)
                                            ({{ $c->email }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Issue Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Issue Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="issue_date" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('issue_date', isset($invoice) ? $invoice->issue_date->format('Y-m-d') : date('Y-m-d')) }}"
                                required>
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                            <input type="date" name="due_date" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('due_date', isset($invoice->due_date) ? $invoice->due_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <!-- Currency -->
                    <div class="mt-4 max-w-xs">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Currency <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="currency" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            value="{{ old('currency', $invoice->currency ?? 'NGN') }}" required>
                    </div>
                </div>

                <!-- Invoice Items Card -->
                <div class="mb-6 rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Invoice Items</h3>
                        <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700" id="addItemBtn">
                            <i class="fas fa-plus"></i>
                            Add Item
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Product <span class="text-red-500">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Qty <span class="text-red-500">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Unit
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Rate <span class="text-red-500">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Discount
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Amount
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="invoiceItemsBody" class="divide-y divide-gray-200">
                                <!-- Items will be added here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Notes Section -->
                    <div class="lg:col-span-2">
                        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Details</h3>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" rows="4"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Add any additional notes or terms...">{{ old('notes', $invoice->notes ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="lg:col-span-1">
                        <div class="rounded-xl bg-gray-50 p-6 border border-gray-200 sticky top-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Summary</h3>

                            <!-- Global Discount -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Global Discount</label>
                                <input type="number" step="0.01" min="0" name="discount"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="globalDiscount" value="{{ $discountData }}">
                            </div>

                            <!-- VAT Rate -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">VAT Rate (%)</label>
                                <input type="number" step="0.01" min="0" name="tax_rate"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="taxRate" value="{{ $taxRateData }}">
                                <p class="mt-1 text-xs text-gray-500">Default: 7.5% (Nigerian VAT)</p>
                            </div>

                            <hr class="mb-4">

                            <!-- Summary Breakdown -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Subtotal:</span>
                                    <strong class="text-gray-900" id="subtotalDisplay">₦0.00</strong>
                                </div>
                                <div class="flex justify-between items-center text-red-600">
                                    <span class="text-sm">Discount:</span>
                                    <strong id="discountDisplay">₦0.00</strong>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">After Discount:</span>
                                    <strong class="text-gray-900" id="afterDiscountDisplay">₦0.00</strong>
                                </div>
                                <div class="flex justify-between items-center text-green-600">
                                    <span class="text-sm">VAT (<span id="taxRateDisplay">7.5</span>%):</span>
                                    <strong id="taxAmountDisplay">₦0.00</strong>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Total -->
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total:</span>
                                <strong class="text-2xl text-blue-600" id="totalDisplay">₦0.00</strong>
                            </div>

                            <input type="hidden" name="vat_amount" id="vatAmountInput">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                    <a href="{{ route('invoice.index') }}"
                       class="mt-3 sm:mt-0 inline-flex justify-center items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 sm:col-start-1">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-save"></i>
                        {{ isset($invoice) ? 'Update Invoice' : 'Save Invoice' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Product data from backend
        const PRODUCTS = @json($products);

        // Initial items data
        const INITIAL_ITEMS = @json($itemsData);

        // Invoice Manager
        const InvoiceManager = {
            items: [],
            nextId: 1,

            init() {
                // Load initial items or add empty row
                if (INITIAL_ITEMS && INITIAL_ITEMS.length > 0) {
                    INITIAL_ITEMS.forEach(item => this.addItem(item));
                } else {
                    this.addItem();
                }

                // Event listeners
                document.getElementById('addItemBtn').addEventListener('click', () => this.addItem());
                document.getElementById('globalDiscount').addEventListener('input', () => this.updateSummary());
                document.getElementById('taxRate').addEventListener('input', () => this.updateSummary());

                this.updateSummary();
            },

            addItem(data = null) {
                const id = this.nextId++;
                const item = {
                    id: id,
                    product_id: data?.product_id || '',
                    quantity: data?.quantity || 1,
                    unit: data?.unit || '',
                    rate: data?.rate || 0,
                    discount: data?.discount || 0,
                    amount: data?.amount || 0
                };

                this.items.push(item);
                this.renderItem(item);
                this.updateSummary();
            },

            renderItem(item) {
                const tbody = document.getElementById('invoiceItemsBody');
                const index = this.items.findIndex(i => i.id === item.id);
                const row = document.createElement('tr');
                row.id = `row-${item.id}`;
                row.className = 'hover:bg-gray-50';

                row.innerHTML = `
                    <td class="px-4 py-3">
                        <select name="items[${index}][product_id]"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 product-select"
                                data-item-id="${item.id}" required>
                            <option value="">-- Select Product --</option>
                            ${PRODUCTS.map(p => `
                                <option value="${p.id}"
                                    data-rate="${p.selling_price}"
                                    data-unit="${p.unit}"
                                    ${item.product_id == p.id ? 'selected' : ''}>
                                    ${p.name}
                                </option>
                            `).join('')}
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" step="0.01" min="0.01"
                            name="items[${index}][quantity]"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 item-quantity"
                            data-item-id="${item.id}"
                            value="${item.quantity}" required>
                    </td>
                    <td class="px-4 py-3">
                        <input type="text"
                            name="items[${index}][unit]"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 item-unit"
                            data-item-id="${item.id}"
                            value="${item.unit}" readonly>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" step="0.01" min="0"
                            name="items[${index}][rate]"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 item-rate"
                            data-item-id="${item.id}"
                            value="${item.rate}" required>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" step="0.01" min="0"
                            name="items[${index}][discount]"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 item-discount"
                            data-item-id="${item.id}"
                            value="${item.discount}">
                    </td>
                    <td class="px-4 py-3">
                        <input type="text"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-900 item-amount-display"
                            value="${this.formatMoney(item.amount)}" readonly>
                        <input type="hidden" name="items[${index}][amount]"
                            class="item-amount-hidden"
                            data-item-id="${item.id}"
                            value="${item.amount}">
                    </td>
                    <td class="px-4 py-3">
                        <button type="button"
                            class="inline-flex items-center justify-center rounded-lg bg-red-100 p-2 text-red-600 hover:bg-red-200 hover:text-red-700 remove-item-btn transition-colors"
                            data-item-id="${item.id}"
                            ${this.items.length === 1 ? 'disabled' : ''}
                            title="Remove Item">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </td>
                `;

                tbody.appendChild(row);

                // Attach event listeners to this row
                this.attachRowListeners(item.id);
            },

            attachRowListeners(itemId) {
                const row = document.getElementById(`row-${itemId}`);

                // Product selection
                row.querySelector('.product-select').addEventListener('change', (e) => {
                    this.onProductChange(itemId, e.target);
                });

                // Quantity, rate, discount changes
                row.querySelector('.item-quantity').addEventListener('input', () => this.recomputeItem(itemId));
                row.querySelector('.item-rate').addEventListener('input', () => this.recomputeItem(itemId));
                row.querySelector('.item-discount').addEventListener('input', () => this.recomputeItem(itemId));

                // Remove button
                row.querySelector('.remove-item-btn')?.addEventListener('click', () => this.removeItem(itemId));
            },

            onProductChange(itemId, selectElement) {
                const item = this.items.find(i => i.id === itemId);
                if (!item) return;

                const selectedOption = selectElement.options[selectElement.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;

                item.product_id = selectedOption.value;
                item.rate = parseFloat(selectedOption.dataset.rate) || 0;
                item.unit = selectedOption.dataset.unit || '';

                // Update the rate and unit inputs
                const row = document.getElementById(`row-${itemId}`);
                row.querySelector('.item-rate').value = item.rate;
                row.querySelector('.item-unit').value = item.unit;

                this.recomputeItem(itemId);
            },

            recomputeItem(itemId) {
                const item = this.items.find(i => i.id === itemId);
                if (!item) return;

                const row = document.getElementById(`row-${itemId}`);

                item.quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                item.rate = parseFloat(row.querySelector('.item-rate').value) || 0;
                item.discount = parseFloat(row.querySelector('.item-discount').value) || 0;

                const base = item.rate * item.quantity;
                item.amount = Math.max(0, Math.round((base - item.discount) * 100) / 100);

                // Update displays
                row.querySelector('.item-amount-display').value = this.formatMoney(item.amount);
                row.querySelector('.item-amount-hidden').value = item.amount;

                this.updateSummary();
            },

            removeItem(itemId) {
                if (this.items.length === 1) return;

                this.items = this.items.filter(i => i.id !== itemId);
                document.getElementById(`row-${itemId}`).remove();

                // Re-render all items to fix indices
                this.reRenderAll();
                this.updateSummary();
            },

            reRenderAll() {
                const tbody = document.getElementById('invoiceItemsBody');
                tbody.innerHTML = '';
                this.items.forEach((item, idx) => {
                    this.renderItem(item);
                });
            },

            updateSummary() {
                const subtotal = this.items.reduce((sum, item) => sum + (parseFloat(item.amount) || 0), 0);
                const globalDiscount = parseFloat(document.getElementById('globalDiscount').value) || 0;
                const afterDiscount = Math.max(0, subtotal - globalDiscount);
                const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
                const taxAmount = Math.round((afterDiscount * taxRate / 100) * 100) / 100;
                const total = Math.round((afterDiscount + taxAmount) * 100) / 100;

                document.getElementById('subtotalDisplay').textContent = this.formatMoney(subtotal);
                document.getElementById('discountDisplay').textContent = this.formatMoney(globalDiscount);
                document.getElementById('afterDiscountDisplay').textContent = this.formatMoney(afterDiscount);
                document.getElementById('taxRateDisplay').textContent = taxRate;
                document.getElementById('taxAmountDisplay').textContent = this.formatMoney(taxAmount);
                document.getElementById('totalDisplay').textContent = this.formatMoney(total);
                document.getElementById('vatAmountInput').value = taxAmount;

                // Update remove button states
                document.querySelectorAll('.remove-item-btn').forEach(btn => {
                    btn.disabled = this.items.length === 1;
                    if (btn.disabled) {
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            },

            formatMoney(amount) {
                amount = parseFloat(amount) || 0;
                return '₦' + amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        };

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            InvoiceManager.init();
        });
    </script>
@endsection
