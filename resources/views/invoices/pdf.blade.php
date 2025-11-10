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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #2d3748;
            line-height: 1.6;
            padding: 25px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 35px 30px 25px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        /* Invoice Meta */
        .invoice-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .status {
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.5px;
        }

        .status::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-paid {
            background: rgba(220, 252, 231, 0.2);
            color: #dcfce7;
            border: 1px solid rgba(220, 252, 231, 0.3);
        }

        .status-paid::before {
            background: #10b981;
        }

        .status-partial {
            background: rgba(254, 249, 195, 0.2);
            color: #fef9c3;
            border: 1px solid rgba(254, 249, 195, 0.3);
        }

        .status-partial::before {
            background: #f59e0b;
        }

        .status-unpaid {
            background: rgba(254, 226, 226, 0.2);
            color: #fee2e2;
            border: 1px solid rgba(254, 226, 226, 0.3);
        }

        .status-unpaid::before {
            background: #ef4444;
        }

        .dates {
            font-size: 12px;
            line-height: 1.6;
            text-align: right;
            color: rgba(255, 255, 255, 0.9);
        }

        .dates div {
            margin-bottom: 4px;
        }

        /* Parties Section */
        .parties {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            padding: 0 30px;
            gap: 20px;
        }

        .party {
            flex: 1;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #2563eb;
        }

        .party h6 {
            font-size: 11px;
            color: #2563eb;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .party strong {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .party p {
            margin-bottom: 4px;
            color: #64748b;
        }

        /* Items Table */
        .table-container {
            padding: 0 30px;
            margin-bottom: 25px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .items th, .items td {
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            font-size: 12px;
        }

        .items th {
            background: #f1f5f9;
            text-transform: uppercase;
            font-weight: 700;
            color: #475569;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .items tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .items tbody tr:hover {
            background: #f1f5f9;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Enhanced Totals Section */
        .totals-container {
            padding: 0 30px;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 25px;
        }

        .totals {
            width: 70%;
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-row strong {
            font-weight: 700;
        }

        .totals-vat {
            background: #f0fdf4;
            padding: 12px 18px;
            border-radius: 8px;
            color: #166534;
            margin: 12px 0;
            border-left: 4px solid #22c55e;
            font-weight: 600;
        }

        /* FIXED: Total Amount with Proper Contrast */
        .totals-total {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            padding: 20px;
            border-radius: 12px;
            font-weight: 800;
            margin-top: 20px;
            color: white; /* White text on dark blue background */
            font-size: 18px;
            text-align: center;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .totals-total::before {
            content: "";
            position: absolute;
            top: -10px;
            right: -10px;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
        }

        .totals-total .totals-row {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
            font-size: 20px;
            justify-content: center;
            gap: 15px;
            color: white; /* Ensure text is white */
        }

        .totals-total .label {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: white; /* Ensure label is white */
        }

        .totals-total .value {
            font-size: 22px;
            font-weight: 900;
            color: white; /* Ensure value is white */
        }

        .paid-amount {
            background: #f0fdf4;
            padding: 12px 18px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #10b981;
            font-weight: 600;
        }

        .due-amount {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 15px 18px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #dc2626;
            font-weight: 700;
            color: white;
            text-align: center;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }

        .due-amount .totals-row {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
            font-size: 16px;
            justify-content: center;
            gap: 10px;
            color: white;
        }

        .due-amount .label {
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .due-amount .value {
            font-size: 18px;
            font-weight: 800;
            color: white;
        }

        /* Notes & Payment */
        .notes-container {
            padding: 0 30px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .notes {
            background: #fefce8;
            padding: 18px;
            border-left: 4px solid #eab308;
            border-radius: 10px;
            font-size: 12px;
        }

        .payment {
            background: #eff6ff;
            padding: 18px;
            border-left: 4px solid #3b82f6;
            border-radius: 10px;
            font-size: 12px;
        }

        .notes strong, .payment strong {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #64748b;
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            background: #f8fafc;
        }

        .footer p {
            margin-bottom: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .parties {
                flex-direction: column;
                padding: 0 20px;
            }

            .table-container {
                padding: 0 20px;
                overflow-x: auto;
            }

            .totals-container {
                padding: 0 20px;
            }

            .totals {
                width: 100%;
            }

            .invoice-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .dates {
                text-align: left;
            }

            .header {
                padding: 25px 20px 20px;
            }

            .header h1 {
                font-size: 26px;
            }

            .totals-total .totals-row {
                flex-direction: column;
                gap: 5px;
                text-align: center;
            }

            .totals-total .label {
                font-size: 14px;
            }

            .totals-total .value {
                font-size: 20px;
            }
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }

            .totals-total {
                background: #1e40af !important;
                -webkit-print-color-adjust: exact;
                color: white !important;
            }

            .due-amount {
                background: #dc2626 !important;
                -webkit-print-color-adjust: exact;
                color: white !important;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        {{-- Header --}}
        <div class="header">
            <div class="header-content">
                <h1>INVOICE</h1>
                <p>#{{ $invoice->invoice_number }}</p>

                <div class="invoice-meta">
                    <span class="status
                        @if($invoice->status === 'paid') status-paid
                        @elseif($invoice->status === 'partial') status-partial
                        @else status-unpaid
                        @endif">
                        {{ strtoupper($invoice->status) }}
                    </span>
                    <div class="dates">
                        <div><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</div>
                        <div><strong>Due Date:</strong>
                            @if($invoice->due_date)
                                {{ $invoice->due_date->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Parties --}}
        <div class="parties">
            <div class="party">
                <h6>From</h6>
                <strong>{{ $invoice->user->company_name ?? 'Your Company' }}</strong>
                <p>{{ $invoice->user->email ?? '' }}</p>
                <p>{{ $invoice->user->phone ?? '' }}</p>
                <p>{{ $invoice->user->address ?? '' }}</p>
            </div>
            <div class="party">
                <h6>Bill To</h6>
                <strong>{{ $invoice->customer->name }}</strong>
                <p>{{ $invoice->customer->email ?? '' }}</p>
                <p>{{ $invoice->customer->phone ?? '' }}</p>
                <p>{{ $invoice->customer->address ?? '' }}</p>
            </div>
        </div>

        {{-- Items --}}
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
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                            @if($item->unit)
                            <br><small>Unit: {{ $item->unit }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ $invoice->currency }} {{ number_format($item->rate,2) }}</td>
                        <td class="text-right">
                            @if($item->discount>0)
                                {{ $invoice->currency }} {{ number_format($item->discount,2) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            <strong>{{ $invoice->currency }} {{ number_format($item->amount,2) }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Enhanced Totals --}}
        @php
            $subtotal = $invoice->items->sum('amount');
            $afterDiscount = max(0, $subtotal - ($invoice->discount ?? 0));
            $vatAmount = $invoice->vat_amount ?? (($afterDiscount * ($invoice->tax_rate ?? 7.5))/100);
            $totalAmount = $afterDiscount + $vatAmount;
        @endphp

        <div class="totals-container">
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span><strong>{{ $invoice->currency }} {{ number_format($subtotal,2) }}</strong></span>
                </div>

                @if($invoice->discount > 0)
                <div class="totals-row">
                    <span>Discount:</span>
                    <span>-{{ $invoice->currency }} {{ number_format($invoice->discount,2) }}</span>
                </div>
                <div class="totals-row">
                    <span>After Discount:</span>
                    <span><strong>{{ $invoice->currency }} {{ number_format($afterDiscount,2) }}</strong></span>
                </div>
                @endif

                <div class="totals-vat">
                    <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                        <span>VAT ({{ $invoice->tax_rate ?? 7.5 }}%):</span>
                        <span><strong>{{ $invoice->currency }} {{ number_format($vatAmount,2) }}</strong></span>
                    </div>
                </div>

                <!-- FIXED: Total Amount with Proper Contrast -->
                <div class="totals-total">
                    <div class="totals-row">
                        <span class="label">Total Amount:</span>
                        <span class="value">{{ $invoice->currency }} {{ number_format($totalAmount,2) }}</span>
                    </div>
                </div>

                @if($invoice->paid > 0)
                <div class="paid-amount">
                    <div class="totals-row" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                        <span>Amount Paid:</span>
                        <span><strong>{{ $invoice->currency }} {{ number_format($invoice->paid,2) }}</strong></span>
                    </div>
                </div>

                @if($totalAmount - $invoice->paid > 0)
                <div class="due-amount">
                    <div class="totals-row">
                        <span class="label">Balance Due:</span>
                        <span class="value">{{ $invoice->currency }} {{ number_format($totalAmount - $invoice->paid,2) }}</span>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>

        {{-- Notes --}}
        @if($invoice->notes)
        <div class="notes-container">
            <div class="notes">
                <strong>Notes:</strong>
                <p>{{ $invoice->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice. No signature is required.</p>
            <p>If you have any questions, please contact us.</p>
        </div>
    </div>
</body>
</html>
