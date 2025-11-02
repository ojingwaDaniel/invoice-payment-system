@extends('layouts.app')

@section('content')
    <div class="">
        <div class="container mx-auto py-6">
            <h2>{{ isset($invoice) ? 'Edit Invoice' : 'Create Invoice' }}</h2>

            {{-- Error / Alert Section --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

                {{-- Invoice Details --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Invoice Details</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                                <input type="text" name="invoice_number"
                                    value="{{ old('invoice_number', $invoice->invoice_number ?? ($invoice_number ?? '')) }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" class="form-control" required>
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

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Issue Date <span class="text-danger">*</span></label>
                                <input type="date" name="issue_date" class="form-control"
                                    value="{{ old('issue_date', isset($invoice) ? $invoice->issue_date->format('Y-m-d') : date('Y-m-d')) }}"
                                    required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control"
                                    value="{{ old('due_date', isset($invoice->due_date) ? $invoice->due_date->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Currency <span class="text-danger">*</span></label>
                                <input type="text" name="currency" class="form-control"
                                    value="{{ old('currency', $invoice->currency ?? 'NGN') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Invoice Items --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Invoice Items</h5>

                        <div class="table-responsive">
                            <table class="table-bordered table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:30%">Product <span class="text-danger">*</span></th>
                                        <th style="width:12%">Qty <span class="text-danger">*</span></th>
                                        <th style="width:12%">Unit</th>
                                        <th style="width:15%">Rate <span class="text-danger">*</span></th>
                                        <th style="width:15%">Discount</th>
                                        <th style="width:15%">Amount</th>
                                        <th style="width:6%"></th>
                                    </tr>
                                </thead>
                                <tbody id="invoiceItemsBody">
                                    <!-- Items will be added here by JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                                                <i class="ti ti-plus me-1"></i>Add Item
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Additional Details --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" rows="4" class="form-control">{{ old('notes', $invoice->notes ?? '') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Summary</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Global Discount</label>
                                            <input type="number" step="0.01" min="0" name="discount"
                                                class="form-control" id="globalDiscount" value="{{ $discountData }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">VAT Rate (%)</label>
                                            <input type="number" step="0.01" min="0" name="tax_rate"
                                                class="form-control" id="taxRate" value="{{ $taxRateData }}">
                                            <small class="text-muted">Default: 7.5% (Nigerian VAT)</small>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <strong id="subtotalDisplay">₦0.00</strong>
                                        </div>
                                        <div class="d-flex justify-content-between text-danger mb-2">
                                            <span>Discount:</span>
                                            <strong id="discountDisplay">₦0.00</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>After Discount:</span>
                                            <strong id="afterDiscountDisplay">₦0.00</strong>
                                        </div>
                                        <div class="d-flex justify-content-between text-success mb-2">
                                            <span>VAT (<span id="taxRateDisplay">7.5</span>%):</span>
                                            <strong id="taxAmountDisplay">₦0.00</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="h5 mb-0">Total:</span>
                                            <strong class="h5 text-primary mb-0" id="totalDisplay">₦0.00</strong>
                                        </div>

                                        <input type="hidden" name="vat_amount" id="vatAmountInput">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
                        <i class="ti ti-x me-1"></i>Cancel
                    </a>
                    <button class="btn btn-success" type="submit">
                        <i class="ti ti-device-floppy me-1"></i>{{ isset($invoice) ? 'Update Invoice' : 'Save Invoice' }}
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

                row.innerHTML = `
                    <td>
                        <select name="items[${index}][product_id]" class="form-control form-control-sm product-select" data-item-id="${item.id}" required>
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
                    <td>
                        <input type="number" step="0.01" min="0.01"
                            name="items[${index}][quantity]"
                            class="form-control form-control-sm item-quantity"
                            data-item-id="${item.id}"
                            value="${item.quantity}" required>
                    </td>
                    <td>
                        <input type="text"
                            name="items[${index}][unit]"
                            class="form-control form-control-sm item-unit"
                            data-item-id="${item.id}"
                            value="${item.unit}">
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0"
                            name="items[${index}][rate]"
                            class="form-control form-control-sm item-rate"
                            data-item-id="${item.id}"
                            value="${item.rate}" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0"
                            name="items[${index}][discount]"
                            class="form-control form-control-sm item-discount"
                            data-item-id="${item.id}"
                            value="${item.discount}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm item-amount-display"
                            value="${this.formatMoney(item.amount)}" readonly>
                        <input type="hidden" name="items[${index}][amount]"
                            class="item-amount-hidden"
                            data-item-id="${item.id}"
                            value="${item.amount}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn"
                            data-item-id="${item.id}"
                            ${this.items.length === 1 ? 'disabled' : ''}>
                            <i class="ti ti-trash"></i>
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

            // Debug: Log form data before submission
            document.getElementById('invoiceForm').addEventListener('submit', function(e) {
                const formData = new FormData(this);
                console.log('=== FORM SUBMISSION DEBUG ===');
                console.log('Items in memory:', JSON.parse(JSON.stringify(InvoiceManager.items)));
                console.log('\nForm data being submitted:');
                for (let [key, value] of formData.entries()) {
                    if (key.startsWith('items[')) {
                        console.log(`${key} = ${value}`);
                    }
                }
            });
        });
    </script>
@endsection
