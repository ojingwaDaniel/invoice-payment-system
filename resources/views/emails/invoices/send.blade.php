<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #1a56db;
            --primary-dark: #1e3a8a;
            --success: #047857;
            --warning: #b45309;
            --danger: #b91c1c;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f8fafc;
            font-family: 'Inter', Arial, sans-serif;
            color: var(--gray-800);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 40px 40px 30px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .invoice-title h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .invoice-title p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #dbeafe;
            opacity: 0.9;
        }

        .invoice-logo {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 12px 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .invoice-logo h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 8px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .status-badge i {
            margin-right: 6px;
            font-size: 12px;
        }

        .status-paid {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .status-partial {
            background: rgba(245, 158, 11, 0.9);
            color: white;
        }

        .status-unpaid {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .section {
            padding: 40px;
        }

        .section h3 {
            font-size: 14px;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .info-card {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid var(--primary);
        }

        .info-card h4 {
            margin: 0 0 12px;
            font-size: 14px;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-card p {
            margin: 6px 0;
            font-size: 15px;
            color: var(--gray-800);
        }

        .table-container {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--gray-50);
        }

        .table th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--gray-200);
        }

        .table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 14px;
            color: var(--gray-800);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        .totals-container {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 24px;
            margin-top: 30px;
        }

        .totals {
            width: 100%;
        }

        .totals tr:not(:last-child) td {
            padding-bottom: 12px;
        }

        .totals td {
            border: none;
            padding: 8px 0;
        }

        .totals .label {
            text-align: left;
            color: var(--gray-700);
            font-size: 14px;
        }

        .totals .value {
            text-align: right;
            font-weight: 500;
            font-size: 14px;
            color: var(--gray-800);
        }

        .totals .total-row {
            border-top: 1px solid var(--gray-300);
            padding-top: 12px;
        }

        .totals .total-row .label {
            font-weight: 700;
            font-size: 16px;
            color: var(--gray-900);
        }

        .totals .total-row .value {
            font-weight: 700;
            font-size: 16px;
            color: var(--gray-900);
        }

        .totals .due-row .value {
            color: var(--danger);
            font-weight: 700;
        }

        .notes-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .notes,
        .payment-method {
            background: var(--gray-50);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--warning);
        }

        .payment-method {
            border-left-color: var(--primary);
        }

        .notes h4,
        .payment-method h4 {
            margin: 0 0 10px;
            font-size: 14px;
            color: var(--gray-700);
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 40px 0 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            padding: 30px 40px;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
        }

        .footer p {
            margin: 5px 0;
            color: var(--gray-700);
            font-size: 14px;
        }

        .footer .brand {
            color: var(--primary);
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                border-radius: 12px;
            }

            .header {
                padding: 30px 25px 20px;
            }

            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .section {
                padding: 25px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .table-container {
                overflow-x: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="invoice-title">
                    <h1>Invoice</h1>
                    <p>#{{ $invoice->invoice_number }}</p>
                    <div
                        class="status-badge @if ($invoice->status === 'paid') status-paid
                        @elseif($invoice->status === 'partial') status-partial
                        @else status-unpaid @endif">
                        <i
                            class="fas @if ($invoice->status === 'paid') fa-check-circle
                            @elseif($invoice->status === 'partial') fa-clock
                            @else fa-exclamation-circle @endif"></i>
                        @if ($invoice->status === 'paid')
                            Paid
                        @elseif($invoice->status === 'partial')
                            Partially Paid
                        @else
                            Unpaid
                        @endif
                    </div>
                </div>
                <div class="invoice-logo">
                    <h2>{{ config('app.name') }}</h2>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="section">
            <p>Dear <strong>{{ $invoice->customer->name }}</strong>,</p>
            <p>Thank you for your business! Here are the details of your invoice:</p>

            <!-- Status and Dates -->
            <div class="info-grid">
                <div class="info-card">
                    <h4>Invoice Details</h4>
                    <p><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</p>
                    <p><strong>Due Date:</strong>
                        @if ($invoice->due_date)
                            {{ $invoice->due_date->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>Currency:</strong> {{ $invoice->currency }}</p>
                </div>

                <div class="info-card">
                    <h4>From</h4>
                    <p><strong>{{ $invoice->user->company_name ?? config('app.name') }}</strong></p>
                    <p>{{ $invoice->user->email ?? '' }}</p>
                </div>
            </div>

            <div class="info-card">
                <h4>Bill To</h4>
                <p><strong>{{ $invoice->customer->name }}</strong></p>
                <p>{{ $invoice->customer->email }}</p>
                @if ($invoice->customer->phone)
                    <p>{{ $invoice->customer->phone }}</p>
                @endif
                @if ($invoice->customer->address)
                    <p>{{ $invoice->customer->address }}</p>
                @endif
            </div>

            <!-- Items Table -->
            <h3>Invoice Items</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product/Service</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                                    @if ($item->unit)
                                        <br><small>Unit: {{ $item->unit }}</small>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $invoice->currency }} {{ number_format($item->rate, 2) }}</td>
                                <td>
                                    @if ($item->discount > 0)
                                        {{ $invoice->currency }} {{ number_format($item->discount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><strong>{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            @php
                $subtotal = $invoice->items->sum('amount');
                $afterDiscount = $subtotal - ($invoice->discount ?? 0);
                $taxRate = $invoice->tax_rate ?? 7.5;
                $vatAmount = ($afterDiscount * $taxRate) / 100;
            @endphp
            <div class="totals-container">
                <table class="totals">
                    <tr>
                        <td class="label">Subtotal:</td>
                        <td class="value">{{ $invoice->currency }} {{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @if ($invoice->discount > 0)
                        <tr>
                            <td class="label">Discount:</td>
                            <td class="value">-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">After Discount:</td>
                            <td class="value">{{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="label">VAT ({{ number_format($taxRate, 2) }}%):</td>
                        <td class="value">{{ $invoice->currency }} {{ number_format($invoice->vat_amount, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="label">Total Amount:</td>
                        <td class="value">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                        </td>
                    </tr>
                    @if ($invoice->paid > 0)
                        <tr>
                            <td class="label">Paid:</td>
                            <td class="value">{{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}</td>
                        </tr>
                    @endif
                    @if ($invoice->total_amount - $invoice->paid > 0)
                        <tr class="due-row">
                            <td class="label">Amount Due:</td>
                            <td class="value">{{ $invoice->currency }}
                                {{ number_format($invoice->total_amount - $invoice->paid, 2) }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Notes & Payment Info -->
            <div class="notes-container">
                @if ($invoice->notes)
                    <div class="notes">
                        <h4><i class="fas fa-sticky-note"></i> Notes</h4>
                        <p>{{ $invoice->notes }}</p>
                    </div>
                @endif

                @if ($invoice->status !== 'paid')
                    <div class="payment-method">
                        <h4><i class="fas fa-credit-card"></i> Payment Method</h4>
                        <p>We accept bank transfers, credit cards, and online payments.</p>
                    </div>
                @endif
            </div>

            <div class="action-buttons">
                <a href="{{ route('invoice.pay', $invoice->id) }}"
                    style="background:#1a56db;color:#ffffff;padding:14px 28px;
          text-decoration:none;border-radius:8px;font-weight:600;
          display:inline-block;font-size:15px;">
                    Pay Now
                </a>

                <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> View Invoice Online
                </a>
            </div>

            <p style="text-align: center; margin-top: 30px;">Thank you for your business!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions about this invoice, please contact us.</p>
            <p>Best regards,<br><span class="brand">{{ config('app.name') }}</span></p>
        </div>
    </div>
</body>

</html>
