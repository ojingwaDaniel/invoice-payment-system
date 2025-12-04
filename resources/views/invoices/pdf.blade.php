<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            background: #ffffff;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px 40px;
            background: white;
        }

        /* Header Section */
        .header {
            margin-bottom: 50px;
            border-bottom: 3px solid #0066ff;
            padding-bottom: 30px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-info h1 {
            font-size: 42px;
            font-weight: 700;
            color: #0066ff;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .invoice-number {
            font-size: 18px;
            color: #666;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .invoice-meta {
            display: flex;
            gap: 30px;
            align-items: center;
            margin-top: 15px;
        }

        .status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-partial {
            background: #fff3cd;
            color: #856404;
        }

        .status-unpaid {
            background: #f8d7da;
            color: #721c24;
        }

        .dates {
            font-size: 13px;
            line-height: 1.8;
        }

        .dates strong {
            color: #333;
            font-weight: 600;
        }

        /* Logo Section */
        .logo-container {
            text-align: right;
        }

        .company-logo {
            max-width: 160px;
            max-height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .logo-placeholder span {
            color: white;
            font-size: 28px;
            font-weight: 700;
        }

        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 8px;
        }

        /* Parties Section */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 45px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .party h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0066ff;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .party strong {
            font-size: 16px;
            color: #1a1a1a;
            display: block;
            margin-bottom: 8px;
        }

        .party p {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin: 3px 0;
        }

        /* Table Section */
        .table-container {
            margin-bottom: 40px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .items thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .items thead th {
            padding: 16px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .items tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .items tbody tr:hover {
            background: #f9fafb;
        }

        .items tbody tr:last-child {
            border-bottom: none;
        }

        .items tbody td {
            padding: 18px 15px;
            font-size: 14px;
            color: #374151;
        }

        .items tbody td strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .items tbody td small {
            color: #6b7280;
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Totals Section */
        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .totals {
            min-width: 400px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-row span:first-child {
            color: #666;
        }

        .totals-row span:last-child {
            color: #1a1a1a;
            font-weight: 600;
        }

        .totals-vat {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #e5e7eb;
        }

        .totals-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 15px -25px 0 -25px;
            padding: 20px 25px;
            border-radius: 0 0 12px 12px;
        }

        .totals-total .totals-row {
            border: none;
        }

        .totals-total .totals-row span {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        .paid-amount {
            background: #d4edda;
            margin: 15px -25px 0 -25px;
            padding: 15px 25px;
        }

        .paid-amount .totals-row span {
            color: #155724;
            font-weight: 600;
        }

        .due-amount {
            background: #fff3cd;
            margin: 0 -25px -25px -25px;
            padding: 15px 25px;
            border-radius: 0 0 12px 12px;
        }

        .due-amount .totals-row span {
            color: #856404;
            font-weight: 700;
            font-size: 16px;
        }

        /* Notes Section */
        .notes-container {
            margin-bottom: 40px;
        }

        .notes {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
        }

        .notes strong {
            color: #92400e;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }

        .notes p {
            color: #78350f;
            font-size: 13px;
            line-height: 1.7;
        }

        /* Footer Section */
        .footer {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-text {
            flex: 1;
        }

        .footer-text p {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.7;
            margin: 4px 0;
        }

        .footer-text p:first-child {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .footer-logo-container {
            margin-left: 30px;
        }

        .footer-logo {
            max-width: 100px;
            max-height: 50px;
            object-fit: contain;
            opacity: 0.6;
        }

        .footer-logo-placeholder {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
        }

        .footer-logo-placeholder span {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        /* Print Optimization */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                padding: 30px;
                max-width: 100%;
            }

            .totals-total {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .items thead {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .logo-placeholder {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* PDF Rendering Optimization */
        @page {
            margin: 15mm;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="header-content">
                <div class="header-info">
                    <h1>INVOICE</h1>
                    <div class="invoice-number">#{{ $invoice->invoice_number }}</div>

                    <div class="invoice-meta">
                        <span
                            class="status @if ($invoice->status === 'paid') status-paid
                            @elseif($invoice->status === 'partial') status-partial
                            @else status-unpaid @endif">
                            {{ strtoupper($invoice->status) }}
                        </span>
                        <div class="dates">
                            <div><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</div>
                            <div><strong>Due Date:</strong>
                                @if ($invoice->due_date)
                                    {{ $invoice->due_date->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="logo-container">
                    @if ($invoice->user && $invoice->user->logo_path)
                        <img src="{{ public_path('storage/' . $invoice->user->logo_path) }}"
                            alt="{{ $invoice->user->company_name ?? 'Company Logo' }}" class="company-logo">
                    @else
                        <div class="logo-placeholder">
                            <span>{{ substr($invoice->user->company_name ?? 'CO', 0, 2) }}</span>
                        </div>
                    @endif
                    @if ($invoice->user && $invoice->user->company_name)
                        <div class="company-name">{{ $invoice->user->company_name }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Parties -->
        <div class="parties">
            <div class="party">
                <h3>Bill To</h3>
                <strong>{{ $invoice->customer->name }}</strong>
                @if ($invoice->customer->email)
                    <p>{{ $invoice->customer->email }}</p>
                @endif
                @if ($invoice->customer->phone)
                    <p>{{ $invoice->customer->phone }}</p>
                @endif
                @if ($invoice->customer->address)
                    <p>{{ $invoice->customer->address }}</p>
                @endif
                @if ($invoice->customer->gst)
                    <p>GST: {{ $invoice->customer->gst }}</p>
                @endif
            </div>
            <div class="party">
                <h3>From</h3>
                <strong>{{ $invoice->user->company->name ?? $invoice->user->company_name ?? 'Your Company' }}</strong>
                @if ($invoice->user->company->email ?? $invoice->user->email)
                    <p>{{ $invoice->user->company->email ?? $invoice->user->email }}</p>
                @endif
                @if ($invoice->user->company->phone ?? $invoice->user->phone)
                    <p>{{ $invoice->user->company->phone ?? $invoice->user->phone }}</p>
                @endif
                @if ($invoice->user->company->address ?? $invoice->user->address)
                    <p>{{ $invoice->user->company->address ?? $invoice->user->address }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-container">
            <table class="items">
                <thead>
                    <tr>
                        <th>Product/Service</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                                @if ($item->unit)
                                    <small>Unit: {{ $item->unit }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ $invoice->currency }} {{ number_format($item->rate, 2) }}</td>
                            <td class="text-right">
                                @if ($item->discount > 0)
                                    {{ $invoice->currency }} {{ number_format($item->discount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                <strong>{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        @php
            $subtotal = $invoice->items->sum('amount');
            $afterDiscount = max(0, $subtotal - ($invoice->discount ?? 0));
            $vatAmount = $invoice->vat_amount ?? ($afterDiscount * ($invoice->tax_rate ?? 7.5)) / 100;
            $totalAmount = $afterDiscount + $vatAmount;
        @endphp

        <div class="totals-container">
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span><strong>{{ $invoice->currency }} {{ number_format($subtotal, 2) }}</strong></span>
                </div>

                @if ($invoice->discount > 0)
                    <div class="totals-row">
                        <span>Discount:</span>
                        <span>-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    <div class="totals-row">
                        <span>After Discount:</span>
                        <span><strong>{{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}</strong></span>
                    </div>
                @endif

                <div class="totals-vat">
                    <div class="totals-row" style="border-bottom: none;">
                        <span>VAT ({{ $invoice->tax_rate ?? 7.5 }}%):</span>
                        <span><strong>{{ $invoice->currency }} {{ number_format($vatAmount, 2) }}</strong></span>
                    </div>
                </div>

                <div class="totals-total">
                    <div class="totals-row" style="border-bottom: none;">
                        <span>Total Amount:</span>
                        <span>{{ $invoice->currency }} {{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>

                @if ($invoice->paid > 0)
                    <div class="paid-amount">
                        <div class="totals-row" style="border-bottom: none;">
                            <span>Amount Paid:</span>
                            <span><strong>{{ $invoice->currency }}
                                    {{ number_format($invoice->paid, 2) }}</strong></span>
                        </div>
                    </div>

                    @if ($totalAmount - $invoice->paid > 0)
                        <div class="due-amount">
                            <div class="totals-row" style="border-bottom: none;">
                                <span>Balance Due:</span>
                                <span>{{ $invoice->currency }}
                                    {{ number_format($totalAmount - $invoice->paid, 2) }}</span>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Notes -->
        @if ($invoice->notes)
            <div class="notes-container">
                <div class="notes">
                    <strong>Notes:</strong>
                    <p>{{ $invoice->notes }}</p>
                </div>
            </div>
        @endif

        @if ($invoice->payment_method)
            <div class="notes-container">
                <div class="notes">
                    <strong>Payment Method:</strong>
                    <p>{{ $invoice->payment_method }}</p>
                </div>
            </div>
        @endif

        <!-- Footer with Logo -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-text">
                    <p>Thank you for your business!</p>
                    <p>This is a computer-generated invoice. No signature is required.</p>
                    <p>If you have any questions, please contact us at
                        {{ $invoice->user->company->email ?? $invoice->user->email ?? 'our support email' }}</p>
                </div>

                <div class="footer-logo-container">
                    @if ($invoice->user && $invoice->user->logo_path)
                        <img src="{{ asset('storage/' . $invoice->user->logo_path) }}"
                            alt="{{ $invoice->user->company_name ?? 'Company Logo' }}" class="footer-logo">
                    @else
                        <div class="footer-logo-placeholder">
                            <span>{{ substr($invoice->user->company_name ?? 'CO', 0, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
