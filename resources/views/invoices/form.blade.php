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

            {{-- ✅ Corrected Data Preparation --}}
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
                    $itemsData = [
                        [
                            'product_id' => '',
                            'quantity' => 1,
                            'unit' => '',
                            'rate' => 0,
                            'discount' => 0,
                            'amount' => 0,
                        ],
                    ];
                    $discountData = 0;
                    $taxRateData = 7.5;
                }
            @endphp

            {{-- ✅ Alpine Form --}}
            <form action="{{ isset($invoice) ? route('invoice.update', $invoice->id) : route('invoice.store') }}"
                method="POST" x-data="invoiceForm(@js($itemsData), @js($discountData), @js($taxRateData))" x-init="console.log('=== INVOICE DEBUG ===');
                console.log('Loaded Items:', JSON.parse(JSON.stringify(items)));
                console.log('Discount:', globalDiscount);
                console.log('Tax Rate:', taxRate);
                console.log('Is Edit Mode:', isEditMode);

                if (!isEditMode) {
                    // Only auto-fill on create mode (new invoice)
                    setTimeout(() => {
                        items.forEach((_, i) => fillFromProduct(i));
                        recomputeAll();
                    }, 50);
                } else {
                    // Edit mode: just recompute existing data without overwriting
                    recomputeAll();
                }">
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
                                    value="{{ old('currency', $invoice->currency ?? 'Naira') }}" required>
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
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td>
                                                <select :name="`items[${index}][product_id]`" x-model="item.product_id"
                                                    @change="fillFromProduct(index)" class="form-control form-control-sm"
                                                    required>
                                                    <option value="">-- Select Product --</option>
                                                    @foreach ($products as $p)
                                                        <option value="{{ $p->id }}"
                                                            data-rate="{{ $p->selling_price }}"
                                                            data-unit="{{ $p->unit }}">
                                                            {{ $p->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" step="0.01" min="0.01"
                                                    :name="`items[${index}][quantity]`" x-model.number="item.quantity"
                                                    @input="recompute(index)" class="form-control form-control-sm" required>
                                            </td>
                                            <td><input type="text" :name="`items[${index}][unit]`" x-model="item.unit"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" step="0.01" min="0"
                                                    :name="`items[${index}][rate]`" x-model.number="item.rate"
                                                    @input="recompute(index)" class="form-control form-control-sm" required>
                                            </td>
                                            <td><input type="number" step="0.01" min="0"
                                                    :name="`items[${index}][discount]`" x-model.number="item.discount"
                                                    @input="recompute(index)" class="form-control form-control-sm"></td>
                                            <td>
                                                <input type="text" :value="formatMoney(item.amount)"
                                                    class="form-control form-control-sm" readonly>
                                                <input type="hidden" :name="`items[${index}][amount]`"
                                                    :value="item.amount">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    @click="remove(index)" :disabled="items.length === 1">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <button type="button" class="btn btn-sm btn-primary" @click="add()">
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
                                                class="form-control" x-model.number="globalDiscount"
                                                @input="recomputeAll()">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">VAT Rate (%)</label>
                                            <input type="number" step="0.01" min="0" name="tax_rate"
                                                class="form-control" x-model.number="taxRate" @input="recomputeAll()">
                                            <small class="text-muted">Default: 7.5% (Nigerian VAT)</small>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <strong x-text="formatMoney(subtotal)"></strong>
                                        </div>
                                        <div class="d-flex justify-content-between text-danger mb-2">
                                            <span>Discount:</span>
                                            <strong x-text="formatMoney(globalDiscount)"></strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>After Discount:</span>
                                            <strong x-text="formatMoney(afterDiscount)"></strong>
                                        </div>
                                        <div class="d-flex justify-content-between text-success mb-2">
                                            <span>VAT (<span x-text="taxRate"></span>%):</span>
                                            <strong x-text="formatMoney(taxAmount)"></strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="h5 mb-0">Total:</span>
                                            <strong class="h5 text-primary mb-0" x-text="formatMoney(total)"></strong>
                                        </div>

                                        {{-- Hidden field to save VAT amount --}}
                                        <input type="hidden" name="vat_amount" :value="taxAmount">
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

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function invoiceForm(existingItems = [], existingDiscount = 0, existingTaxRate = 7.5) {
            return {
                items: existingItems.length ? existingItems : [{
                    product_id: '',
                    quantity: 1,
                    unit: '',
                    rate: 0,
                    discount: 0,
                    amount: 0
                }],
                globalDiscount: parseFloat(existingDiscount) || 0,
                taxRate: parseFloat(existingTaxRate) || 7.5,
                isEditMode: existingItems.length > 0 && existingItems[0].product_id !== '',
                hasInitialized: false,

                get subtotal() {
                    return this.items.reduce((sum, it) => sum + (parseFloat(it.amount || 0) || 0), 0);
                },
                get afterDiscount() {
                    const disc = parseFloat(this.globalDiscount) || 0;
                    return Math.max(0, this.subtotal - disc);
                },
                get taxAmount() {
                    const rate = parseFloat(this.taxRate) || 0;
                    return Math.round((this.afterDiscount * rate) / 100 * 100) / 100;
                },
                get total() {
                    return Math.round((this.afterDiscount + this.taxAmount) * 100) / 100;
                },

                add() {
                    this.items.push({
                        product_id: '',
                        quantity: 1,
                        unit: '',
                        rate: 0,
                        discount: 0,
                        amount: 0
                    });
                },
                remove(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.recomputeAll();
                    }
                },

                fillFromProduct(index) {
                    const select = document.getElementsByName(`items[${index}][product_id]`)[0];
                    if (!select) return;

                    const opt = select.options[select.selectedIndex];
                    if (!opt || !opt.value) return;

                    const item = this.items[index];
                    const newRate = parseFloat(opt.dataset.rate) || 0;
                    const newUnit = opt.dataset.unit || '';

                    if (this.hasInitialized || !this.isEditMode) {
                        item.rate = newRate;
                        item.unit = newUnit;
                    }

                    this.recompute(index);
                },

                recompute(index) {
                    const it = this.items[index];
                    let rate = parseFloat(it.rate) || 0;
                    let qty = parseFloat(it.quantity) || 0;
                    let discount = parseFloat(it.discount) || 0;
                    let base = rate * qty;
                    let afterDiscount = Math.max(0, base - discount);
                    it.amount = Math.round(afterDiscount * 100) / 100;
                },

                recomputeAll() {
                    this.items.forEach((_, i) => this.recompute(i));
                },

                formatMoney(amount) {
                    amount = parseFloat(amount || 0);
                    return '₦' + amount.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        }
    </script>
@endsection
