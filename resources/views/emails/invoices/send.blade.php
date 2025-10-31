<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            padding: 30px;
            text-align: center;
            color: #fff;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #dbeafe;
        }

        .section {
            padding: 30px;
        }

        .section h3 {
            font-size: 14px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
        }

        .table th {
            background-color: #f3f4f6;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 9999px;
            font-weight: bold;
            font-size: 13px;
        }

        .badge-paid {
            background: #dcfce7;
            color: #166534;
        }

        .badge-partial {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }

        .totals {
            width: 100%;
            margin-top: 15px;
        }

        .totals td {
            padding: 8px 0;
        }

        .totals .label {
            text-align: left;
        }

        .totals .value {
            text-align: right;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            color: #fff;
            background: #2563eb;
        }

        .notes {
            background: #fef9c3;
            padding: 15px;
            border-left: 4px solid #facc15;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .payment-method {
            background: #eff6ff;
            padding: 15px;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Invoice</h1>
            <p>#{{ $invoice->invoice_number }}</p>
        </div>

        <!-- Body -->
        <div class="section">
            <p>Dear <strong>{{ $invoice->customer->name }}</strong>,</p>
            <p>Thank you for your business! Here are the details of your invoice:</p>

            <!-- Status and Dates -->
            <table class="table">
                <tr>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>{{ $invoice->issue_date->format('M d, Y') }}</td>
                    <td>
                        @if ($invoice->due_date)
                            {{ $invoice->due_date->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($invoice->status === 'paid')
                            <span class="badge badge-paid">Paid</span>
                        @elseif($invoice->status === 'partial')
                            <span class="badge badge-partial">Partially Paid</span>
                        @else
                            <span class="badge badge-unpaid">Unpaid</span>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Bill To & From -->
            <table class="table">
                <tr>
                    <th>Bill To</th>
                    <th>From</th>
                </tr>
                <tr>
                    <td>
                        {{ $invoice->customer->name }}<br>
                        {{ $invoice->customer->email }}<br>
                        @if ($invoice->customer->phone)
                            {{ $invoice->customer->phone }}<br>
                        @endif
                        @if ($invoice->customer->address)
                            {{ $invoice->customer->address }}
                        @endif
                    </td>
                    <td>
                        {{ $invoice->user->company_name ?? config('app.name') }}<br>
                        {{ $invoice->user->email ?? '' }}
                    </td>
                </tr>
            </table>

            <!-- Items Table -->
            <h3>Invoice Items</h3>
            <table class="table">
                <tr>
                    <th>Product/Service</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Amount</th>
                </tr>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'N/A' }} @if ($item->unit)
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
                        <td>{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </table>

            <!-- Totals -->
            @php
                $subtotal = $invoice->items->sum('amount');
                $afterDiscount = $subtotal - ($invoice->discount ?? 0);
                $taxRate = $invoice->tax_rate ?? 0;
                $vatAmount = ($afterDiscount * $taxRate) / 100;
            @endphp
            <table class="totals">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value">{{ $invoice->currency }} {{ number_format($subtotal, 2) }}</td>
                </tr>
                @if ($invoice->discount > 0)
                    <tr>
                        <td class="label">Discount:</td>
                        <td class="value">-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</td>
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
                <tr>
                    <td class="label"><strong>Total Amount:</strong></td>
                    <td class="value"><strong>{{ $invoice->currency }}
                            {{ number_format($invoice->total_amount, 2) }}</strong></td>
                </tr>
                @if ($invoice->paid > 0)
                    <tr>
                        <td class="label">Paid:</td>
                        <td class="value">{{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}</td>
                    </tr>
                @endif
                @if ($invoice->total_amount - $invoice->paid > 0)
                    <tr>
                        <td class="label"><strong>Amount Due:</strong></td>
                        <td class="value" style="color:#dc2626; font-weight:bold;">{{ $invoice->currency }}
                            {{ number_format($invoice->total_amount - $invoice->paid, 2) }}</td>
                    </tr>
                @endif
            </table>

            <!-- Notes -->
            @if ($invoice->notes)
                <div class="notes">
                    <strong>Notes:</strong><br>
                    {{ $invoice->notes }}
                </div>
            @endif

            <!-- Payment Method -->
            @if ($invoice->payment_method)
                <div class="payment-method">
                    <strong>Payment Method:</strong> {{ $invoice->payment_method }}
                </div>
            @endif

            <!-- Call to Action -->
            @if ($invoice->status !== 'paid')
                <div style="text-align:center; margin:30px 0;">
                    <a href="{{ route('invoice.show', $invoice->id) }}" class="btn">View Invoice Online</a>
                </div>
            @endif

            <p>Thank you for your business!</p>
            <p>Best regards,<br><strong style="color:#2563eb;">{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>

</html>
