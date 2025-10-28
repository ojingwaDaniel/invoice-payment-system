<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .table th { background: #f5f5f5; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice #{{ $invoice->invoice_number }}</h2>
        <p>Issue Date: {{ $invoice->issue_date->format('M d, Y') }}</p>
        @if($invoice->due_date)
            <p>Due Date: {{ $invoice->due_date->format('M d, Y') }}</p>
        @endif
    </div>

    <h4>Bill To:</h4>
    <p>
        {{ $invoice->customer->name }}<br>
        {{ $invoice->customer->email }}<br>
        {{ $invoice->customer->phone ?? '' }}<br>
        {{ $invoice->customer->address ?? '' }}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>Product/Service</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Rate</th>
                <th class="text-center">Tax %</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->rate, 2) }}</td>
                <td class="text-center">{{ $item->tax_percent }}%</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="margin-top:20px;">Totals</h4>
    @php
        $subtotal = $invoice->items->sum('amount');
        $taxTotal = $invoice->items->sum(fn($i) => ($i->quantity * $i->rate * $i->tax_percent) / 100);
        $discount = $invoice->discount ?? 0;
    @endphp

    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td class="text-right">{{ $invoice->currency }} {{ number_format($subtotal - $taxTotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Tax:</strong></td>
            <td class="text-right">{{ $invoice->currency }} {{ number_format($taxTotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Discount:</strong></td>
            <td class="text-right">-{{ $invoice->currency }} {{ number_format($discount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total:</strong></td>
            <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</td>
        </tr>
    </table>

    @if($invoice->notes)
        <p style="margin-top:20px;"><strong>Notes:</strong> {{ $invoice->notes }}</p>
    @endif
</body>
</html>
