<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt - Invoice #{{ $invoice->invoice_number }}</title>
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

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px 40px;
            background: white;
        }

        /* Success Header */
        .receipt-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 40px;
            color: white;
            position: relative;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 20px solid #059669;
        }

        .success-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .success-icon {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            font-weight: bold;
        }

        .receipt-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .receipt-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .receipt-number {
            text-align: right;
            position: absolute;
            top: 40px;
            right: 40px;
        }

        .receipt-number-label {
            font-size: 11px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .receipt-number-value {
            font-size: 20px;
            font-weight: 700;
        }

        /* Parties Section */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
        }

        .party h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #10b981;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .party-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .party p {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin: 3px 0;
        }

        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #10b981;
        }

        .info-card-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #10b981;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .info-card-value {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 40px;
        }

        .items-section h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .items-table thead {
            background: #f8f9fa;
        }

        .items-table thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            border-bottom: 2px solid #e5e7eb;
        }

        .items-table tbody td {
            padding: 16px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: #1a1a1a;
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
            min-width: 380px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
            color: #666;
        }

        .totals-row span:last-child {
            color: #1a1a1a;
            font-weight: 600;
        }

        .totals-divider {
            border-top: 2px solid #e5e7eb;
            margin: 15px 0;
        }

        .totals-final {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            font-size: 18px;
        }

        .totals-final span:first-child {
            font-weight: 700;
            color: #1a1a1a;
        }

        .totals-final span:last-child {
            font-weight: 700;
            color: #10b981;
            font-size: 24px;
        }

        /* Payment Reference */
        .payment-reference {
            background: linear-gradient(135deg, #f8f9fa 0%, #e5e7eb 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reference-info {
            flex: 1;
        }

        .reference-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .reference-value {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .verified-badge {
            background: #d4edda;
            color: #155724;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Footer */
        .receipt-footer {
            text-align: center;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }

        .footer-text {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }

        .footer-timestamp {
            font-size: 11px;
            color: #9ca3af;
        }

        /* Watermark */
        .watermark {
            position: relative;
            margin: 40px 0;
            text-align: center;
        }

        .watermark::before {
            content: '✓ PAID';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(16, 185, 129, 0.05);
            z-index: -1;
            letter-spacing: 10px;
        }

        /* Print Optimization */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .receipt-container {
                padding: 30px;
                max-width: 100%;
            }

            .receipt-header {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @page {
            margin: 15mm;
        }
    </style>
</head>

<body>
    <div class="receipt-container">

        <!-- Success Header -->
        <div class="receipt-header">
            <div class="success-badge">
                <span class="success-icon">✓</span>
                PAID
            </div>
            <div class="receipt-title">Payment Receipt</div>
            <div class="receipt-subtitle">Thank you for your payment!</div>

            <div class="receipt-number">
                <div class="receipt-number-label">Receipt Number</div>
                <div class="receipt-number-value">#{{ $invoice->invoice_number }}</div>
            </div>
        </div>

        <div class="watermark"></div>

        <!-- Parties -->
        <div class="parties">
            <div class="party">
                <h3>From</h3>
                <div class="party-name">{{ $user->company->name ?? ($user->company_name ?? 'Your Company') }}</div>
                @if (isset($user->company->address) || isset($user->address))
                    <p>{{ $user->company->address ?? $user->address }}</p>
                @endif
                @if (isset($user->company->email) || isset($user->email))
                    <p>{{ $user->company->email ?? $user->email }}</p>
                @endif
                @if (isset($user->company->phone) || isset($user->phone))
                    <p>{{ $user->company->phone ?? $user->phone }}</p>
                @endif
            </div>

            <div class="party">
                <h3>Bill To</h3>
                <div class="party-name">{{ $invoice->customer->name }}</div>
                @if ($invoice->customer->email)
                    <p>{{ $invoice->customer->email }}</p>
                @endif
                @if ($invoice->customer->phone)
                    <p>{{ $invoice->customer->phone }}</p>
                @endif
                @if ($invoice->customer->address)
                    <p>{{ $invoice->customer->address }}</p>
                @endif
            </div>
        </div>

        <!-- Info Cards -->
        <div class="info-cards">
            <div class="info-card">
                <div class="info-card-label">Invoice Date</div>
                <div class="info-card-value">
                    {{ $invoice->issue_date ? $invoice->issue_date->format('d M Y') : $invoice->created_at->format('d M Y') }}
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-label">Payment Date</div>
                <div class="info-card-value">
                    {{ $invoice->paid_at ? $invoice->paid_at->format('d M Y') : now()->format('d M Y') }}</div>
            </div>

            <div class="info-card">
                <div class="info-card-label">Payment Method</div>
                <div class="info-card-value">{{ $invoice->payment_method ?? 'Online Payment' }}</div>
            </div>
        </div>

        <!-- Items Table -->
        @if ($invoice->items && $invoice->items->count() > 0)
            <div class="items-section">
                <h3>Items</h3>
                <div class="table-container">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $item)
                                <tr>
                                    <td>
                                        <div class="item-name">{{ $item->product->name ?? 'N/A' }}</div>
                                        @if ($item->unit)
                                            <small style="color: #6b7280; font-size: 12px;">Unit:
                                                {{ $item->unit }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ $invoice->currency }}
                                        {{ number_format($item->rate, 2) }}</td>
                                    <td class="text-right"><strong>{{ $invoice->currency }}
                                            {{ number_format($item->amount, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

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
                    <span>{{ $invoice->currency }} {{ number_format($subtotal, 2) }}</span>
                </div>

                @if (isset($invoice->discount) && $invoice->discount > 0)
                    <div class="totals-row" style="color: #10b981;">
                        <span>Discount:</span>
                        <span>-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</span>
                    </div>
                @endif

                @if ($vatAmount > 0)
                    <div class="totals-row">
                        <span>VAT ({{ $invoice->tax_rate ?? 7.5 }}%):</span>
                        <span>{{ $invoice->currency }} {{ number_format($vatAmount, 2) }}</span>
                    </div>
                @endif

                <div class="totals-divider"></div>

                <div class="totals-final">
                    <span>Total Amount:</span>
                    <span>{{ $invoice->currency }} {{ number_format($totalAmount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Reference -->
        <div class="payment-reference">
            <div class="reference-info">
                <div class="reference-label">Payment Reference</div>
                <div class="reference-value">{{ $invoice->payment_reference ?? $invoice->invoice_number }}</div>
            </div>
            <div class="verified-badge">VERIFIED</div>
        </div>
        <div style="text-align: right; margin-bottom: 20px;">
            <a href="{{ route('invoice.show.receipt', ['invoice' => $invoice->id, 'download' => true]) }}"
                style="
            background: #059669;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            font-weight: 600;
       ">
                Download PDF
            </a>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <p class="footer-text">
                This is an official payment receipt. For any queries, please contact our support team.
            </p>
            <p class="footer-text">
                {{ $user->company->email ?? ($user->email ?? 'support@company.com') }}
            </p>
            <p class="footer-timestamp">
                Generated on {{ now()->format('d M Y, h:i A') }}
            </p>
        </div>

    </div>
</body>

</html>
