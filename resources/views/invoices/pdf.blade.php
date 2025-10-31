<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:11px; color:#333; line-height:1.5; padding:20px; }

        /* Header */
        .header { background:linear-gradient(90deg,#2563eb,#1e40af); color:#fff; padding:30px 20px; border-radius:0 0 15px 15px; text-align:center; }
        .header h1 { font-size:28px; font-weight:bold; margin-bottom:5px; }
        .header p { font-size:14px; color:black; margin:0; }

        /* Status & Dates */
        .meta { margin-top:20px; display:flex; justify-content:space-between; }
        .status { padding:5px 15px; border-radius:999px; font-weight:bold; text-transform:uppercase; font-size:11px; display:inline-block; }
        .status-paid { background:#dcfce7; color:#166534; }
        .status-partial { background:#fef9c3; color:#854d0e; }
        .status-unpaid { background:#fee2e2; color:#991b1b; }
        .dates { font-size:11px; line-height:1.6; text-align:right; }

        /* Parties Section */
        .parties { display:flex; justify-content:space-between; margin:30px 0; }
        .party { width:48%; background:#f8f9fa; padding:15px; border-radius:10px; }
        .party h6 { font-size:10px; color:#667eea; text-transform:uppercase; font-weight:bold; margin-bottom:5px; }
        .party strong { display:block; font-size:14px; margin-bottom:5px; }

        /* Items Table */
        .items { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .items th, .items td { border:1px solid #e5e7eb; padding:8px; font-size:11px; }
        .items th { background:#f3f4f6; text-transform:uppercase; font-weight:bold; }
        .text-right { text-align:right; }
        .text-center { text-align:center; }

        /* Totals */
        .totals { width:45%; float:right; background:#f8f9fa; padding:15px; border-radius:10px; font-size:11px; }
        .totals-row { display:flex; justify-content:space-between; margin-bottom:5px; }
        .totals-row strong { font-weight:bold; }
        .totals-vat { background:#e8f5e9; padding:5px; border-radius:5px; color:#2e7d32; }
        .totals-total { background:linear-gradient(90deg,#2563eb,#1e40af); padding:10px; border-radius:8px; font-weight:bold; margin-top:10px; }

        /* Notes & Payment */
        .notes { background:#fef9c3; padding:10px; border-left:4px solid #facc15; border-radius:5px; margin-top:20px; font-size:10px; }
        .payment { background:#eff6ff; padding:10px; border-left:4px solid #3b82f6; border-radius:5px; margin-top:10px; font-size:10px; }
        .clearfix { clear:both; }
        .footer { text-align:center; font-size:9px; color:#666; margin-top:30px; border-top:1px solid #ddd; padding-top:10px; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>INVOICE</h1>
        <p>#{{ $invoice->invoice_number }}</p>
        <div class="meta">
            <span class="status
                @if($invoice->status === 'paid') status-paid
                @elseif($invoice->status === 'partial') status-partial
                @else status-unpaid
                @endif">
                {{ strtoupper($invoice->status) }}
            </span>
            <div class="dates">
                <div><strong>Issue Date:</strong> {{ $invoice->issue_date->format('M d, Y') }}</div>
                @if($invoice->due_date)
                <div><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Parties --}}
    <div class="parties">
        <div class="party">
            <h6>From</h6>
            <strong>{{ $invoice->user->company_name ?? 'Your Company' }}</strong>
            {{ $invoice->user->email ?? '' }}<br>
            {{ $invoice->user->phone ?? '' }}<br>
            {{ $invoice->user->address ?? '' }}
        </div>
        <div class="party">
            <h6>Bill To</h6>
            <strong>{{ $invoice->customer->name }}</strong>
            {{ $invoice->customer->email ?? '' }}<br>
            {{ $invoice->customer->phone ?? '' }}<br>
            {{ $invoice->customer->address ?? '' }}
        </div>
    </div>

    {{-- Items --}}
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
                <td>{{ $item->product->name ?? 'N/A' }} @if($item->unit)<br><small>Unit: {{ $item->unit }}</small>@endif</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->rate,2) }}</td>
                <td class="text-right">@if($item->discount>0){{ $invoice->currency }} {{ number_format($item->discount,2) }}@else - @endif</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->amount,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    @php
        $subtotal = $invoice->items->sum('amount');
        $afterDiscount = max(0, $subtotal - ($invoice->discount ?? 0));
        $vatAmount = $invoice->vat_amount ?? (($afterDiscount * ($invoice->tax_rate ?? 7.5))/100);
        $totalAmount = $afterDiscount + $vatAmount;
    @endphp
    <div class="totals">
        <div class="totals-row"><span>Subtotal:</span> <span>{{ $invoice->currency }} {{ number_format($subtotal,2) }}</span></div>
        @if($invoice->discount > 0)
        <div class="totals-row"><span>Discount:</span> <span>-{{ $invoice->currency }} {{ number_format($invoice->discount,2) }}</span></div>
        <div class="totals-row"><span>After Discount:</span> <span>{{ $invoice->currency }} {{ number_format($afterDiscount,2) }}</span></div>
        @endif
        <div class="totals-row totals-vat"><span>VAT ({{ $invoice->tax_rate ?? 7.5 }}%):</span> <span>{{ $invoice->currency }} {{ number_format($vatAmount,2) }}</span></div>
        <div class="totals-total"><span>Total Due:</span> <span>{{ $invoice->currency }} {{ number_format($totalAmount,2) }}</span></div>
        @if($invoice->paid > 0)
        <div class="totals-row" style="background:#d4edda; padding:5px; border-radius:5px; margin-top:5px;"><span>Paid:</span> <span>{{ $invoice->currency }} {{ number_format($invoice->paid,2) }}</span></div>
        <div class="totals-row" style="background:#fff3cd; padding:5px; border-radius:5px; margin-top:5px;"><span>Amount Due:</span> <span>{{ $invoice->currency }} {{ number_format($totalAmount - $invoice->paid,2) }}</span></div>
        @endif
    </div>
    <div class="clearfix"></div>

    {{-- Notes --}}
    @if($invoice->notes)
    <div class="notes"><strong>Notes:</strong><br>{{ $invoice->notes }}</div>
    @endif

    {{-- Payment Info --}}
    {{-- <div class="payment">
        <strong>Payment Method:</strong> {{ $invoice->payment_method ?? 'N/A' }}
        <p>Scan to pay:</p
{!! QrCode::size(200)->generate($paymentLink) !!}
    </div> --}}

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice.</p>
    </div>
</body>
</html>
