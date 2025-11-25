<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            color: #1f2937;
            line-height: 1.5;
            padding: 30px;
            background: white;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        /* Clean Header with Logo */
        .header {
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: flex-start;
        }

        .header-info h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #111827;
        }

        .invoice-number {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 15px;
        }

        .invoice-meta {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-partial {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .dates {
            font-size: 13px;
            color: #6b7280;
        }

        .dates div {
            margin-bottom: 4px;
        }

        /* Logo Container */
        .logo-container {
            text-align: right;
        }

        .company-logo {
            max-width: 150px;
            max-height: 80px;
            margin-bottom: 8px;
            border: 1px solid #f3f4f6;
            padding: 8px;
            background: white;
        }

        .logo-placeholder {
            width: 150px;
            height: 80px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin-bottom: 8px;
            border: 1px solid #e5e7eb;
        }

        .logo-placeholder span {
            font-size: 18px;
            font-weight: 700;
            color: #6b7280;
        }

        .company-name {
            font-weight: 600;
            color: #374151;
            font-size: 16px;
        }

        /* Parties Section */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .party h3 {
            font-size: 14px;
            color: #374151;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .party strong {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #111827;
        }

        .party p {
            margin-bottom: 4px;
            color: #6b7280;
        }

        /* Items Table */
        .table-container {
            padding: 0 30px;
            margin: 20px 0;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
        }

        .items th {
            text-align: left;
            padding: 12px 8px;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
        }

        .items td {
            padding: 12px 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        .items tbody tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Totals Section */
        .totals-container {
            padding: 0 30px;
            margin-bottom: 30px;
        }

        .totals {
            width: 300px;
            margin-left: auto;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-vat {
            background: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
        }

        .totals-total {
            background: #1f2937;
            color: white;
            padding: 16px;
            border-radius: 6px;
            margin-top: 15px;
            font-weight: 700;
        }

        .paid-amount {
            background: #f0fdf4;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
            border-left: 3px solid #10b981;
        }

        .due-amount {
            background: #fef2f2;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
            border-left: 3px solid #ef4444;
            font-weight: 600;
        }

        /* Notes Section */
        .notes-container {
            padding: 0 30px;
            margin-bottom: 30px;
        }

        .notes {
            background: #f8fafc;
            padding: 16px;
            border-radius: 6px;
            border-left: 3px solid #3b82f6;
        }

        .notes strong {
            display: block;
            margin-bottom: 8px;
            color: #374151;
        }

        /* Footer with Logo */
        .footer {
            padding: 25px 30px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
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
            margin-bottom: 5px;
            color: #6b7280;
            font-size: 13px;
        }

        .footer-logo {
            max-width: 100px;
            max-height: 50px;
            border: 1px solid #e5e7eb;
            padding: 4px;
            background: white;
        }

        .footer-logo-placeholder {
            width: 100px;
            height: 50px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }

        .footer-logo-placeholder span {
            font-size: 14px;
            font-weight: 700;
            color: #6b7280;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .logo-container {
                text-align: left;
            }

            .parties {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .totals {
                width: 100%;
            }

            .footer-content {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }

        /* Print Optimization */
        @media print {
            body {
                padding: 0;
                background: white;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                border-radius: 0;
            }

            .totals-total {
                background: #1f2937 !important;
                -webkit-print-color-adjust: exact;
            }
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
                <p>{{ $invoice->customer->email ?? '' }}</p>
                <p>{{ $invoice->customer->phone ?? '' }}</p>
                <p>{{ $invoice->customer->address ?? '' }}</p>
            </div>
            <div class="party">
                <h3>From</h3>
                <strong>{{ $invoice->user->company_name ?? 'Your Company' }}</strong>
                <p>{{ $invoice->user->email ?? '' }}</p>
                <p>{{ $invoice->user->phone ?? '' }}</p>
                <p>{{ $invoice->user->address ?? '' }}</p>
                
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
                                    <br><small style="color: #6b7280; font-size: 12px;">Unit:
                                        {{ $item->unit }}</small>
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
                    <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                        <span>VAT ({{ $invoice->tax_rate ?? 7.5 }}%):</span>
                        <span><strong>{{ $invoice->currency }} {{ number_format($vatAmount, 2) }}</strong></span>
                    </div>
                </div>

                <div class="totals-total">
                    <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                        <span>Total Amount:</span>
                        <span>{{ $invoice->currency }} {{ number_format($totalAmount, 2) }}</span>
                    </div>
                </div>

                @if ($invoice->paid > 0)
                    <div class="paid-amount">
                        <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                            <span>Amount Paid:</span>
                            <span><strong>{{ $invoice->currency }}
                                    {{ number_format($invoice->paid, 2) }}</strong></span>
                        </div>
                    </div>

                    @if ($totalAmount - $invoice->paid > 0)
                        <div class="due-amount">
                            <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
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

        <!-- Footer with Logo -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-text">
                    <p>Thank you for your business!</p>
                    <p>This is a computer-generated invoice. No signature is required.</p>
                    <p>If you have any questions, please contact us at
                        {{ $invoice->user->email ?? 'our support email' }}</p>
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
