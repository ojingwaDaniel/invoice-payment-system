<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, sans-serif; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f6f8; padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Outer container -->
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:linear-gradient(90deg,#2563eb,#1e40af); padding:40px 20px;">
                            <h1 style="color:#ffffff; font-size:28px; margin:0;">Invoice Notification</h1>
                            <p style="color:#dbeafe; font-size:16px; margin:5px 0 0;">Invoice #{{ $invoice->invoice_number }}</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 30px;">
                            <p style="font-size:16px; color:#111;">Dear <strong>{{ $invoice->customer->name }}</strong>,</p>

                            <p style="font-size:15px; line-height:1.6;">
                                Thank you for your business! Please find your invoice details below.
                                We appreciate your prompt attention to this matter.
                            </p>

                            <!-- Invoice Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:25px 0; border:1px solid #e5e7eb; border-radius:6px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <h3 style="font-size:14px; color:#6b7280; text-transform:uppercase; margin:0 0 12px;">Invoice Summary</h3>

                                        <table width="100%" cellpadding="4" cellspacing="0" border="0" style="font-size:15px;">
                                            <tr>
                                                <td>Invoice Number:</td>
                                                <td align="right"><strong>{{ $invoice->invoice_number }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Issue Date:</td>
                                                <td align="right">{{ $invoice->issue_date->format('M d, Y') }}</td>
                                            </tr>
                                            @if($invoice->due_date)
                                            <tr>
                                                <td>Due Date:</td>
                                                <td align="right"><strong>{{ $invoice->due_date->format('M d, Y') }}</strong></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>Status:</td>
                                                <td align="right">
                                                    @if($invoice->status === 'paid')
                                                        <span style="background:#dcfce7; color:#166534; padding:3px 10px; border-radius:9999px; font-weight:bold;">Paid</span>
                                                    @elseif($invoice->status === 'partial')
                                                        <span style="background:#fef9c3; color:#854d0e; padding:3px 10px; border-radius:9999px; font-weight:bold;">Partially Paid</span>
                                                    @else
                                                        <span style="background:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:9999px; font-weight:bold;">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Items -->
                            @if($invoice->items->count() > 0)
                            <h3 style="font-size:14px; color:#6b7280; text-transform:uppercase; margin-bottom:8px;">Invoice Items</h3>
                            <table width="100%" cellpadding="8" cellspacing="0" border="0" style="border-collapse:collapse; border:1px solid #e5e7eb; border-radius:6px;">
                                @foreach($invoice->items->take(5) as $item)
                                <tr style="border-bottom:1px solid #f3f4f6;">
                                    <td>{{ $item->product->name ?? 'Item' }} ({{ $item->quantity }}x)</td>
                                    <td align="right"><strong>{{ $invoice->currency }} {{ number_format($item->amount, 2) }}</strong></td>
                                </tr>
                                @endforeach
                                @if($invoice->items->count() > 5)
                                <tr>
                                    <td colspan="2" style="font-size:13px; color:#6b7280; font-style:italic; padding:8px;">And {{ $invoice->items->count() - 5 }} more item(s)...</td>
                                </tr>
                                @endif
                            </table>
                            @endif

                            <!-- Invoice Breakdown -->
                            @php
                                $subtotal = $invoice->items->sum('amount');
                                $afterDiscount = $subtotal - ($invoice->discount ?? 0);
                                $taxRate = $invoice->tax_rate ?? 0;
                                $vatAmount = ($afterDiscount * $taxRate) / 100;
                            @endphp

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:25px 0; border:1px solid #e5e7eb; border-radius:6px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <h3 style="font-size:14px; color:#6b7280; text-transform:uppercase; margin:0 0 12px;">Payment Breakdown</h3>

                                        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="font-size:15px;">
                                            <tr>
                                                <td>Subtotal:</td>
                                                <td align="right"><strong>{{ $invoice->currency }} {{ number_format($subtotal, 2) }}</strong></td>
                                            </tr>
                                            @if($invoice->discount > 0)
                                            <tr>
                                                <td style="color:#dc2626;">Discount:</td>
                                                <td align="right" style="color:#dc2626;"><strong>-{{ $invoice->currency }} {{ number_format($invoice->discount, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>After Discount:</td>
                                                <td align="right"><strong>{{ $invoice->currency }} {{ number_format($afterDiscount, 2) }}</strong></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="color:#16a34a;"><strong>VAT ({{ number_format($taxRate, 2) }}%):</strong></td>
                                                <td align="right" style="color:#16a34a;"><strong>{{ $invoice->currency }} {{ number_format($vatAmount, 2) }}</strong></td>
                                            </tr>
                                            <tr style="background:#eff6ff; border-top:2px solid #e5e7eb;">
                                                <td style="font-size:17px; padding-top:12px;"><strong>Total Amount:</strong></td>
                                                <td align="right" style="color:#1d4ed8; font-size:18px; font-weight:bold; padding-top:12px;">
                                                    {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                                                </td>
                                            </tr>
                                            @if($invoice->paid > 0)
                                            <tr>
                                                <td style="color:#16a34a;">Amount Paid:</td>
                                                <td align="right" style="color:#16a34a;">
                                                    <strong>{{ $invoice->currency }} {{ number_format($invoice->paid, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($invoice->total_amount - $invoice->paid > 0)
                                            <tr style="background:#fef2f2; border-top:2px solid #e5e7eb;">
                                                <td style="padding-top:12px;"><strong>Amount Due:</strong></td>
                                                <td align="right" style="color:#dc2626; font-weight:bold; font-size:17px; padding-top:12px;">
                                                    {{ $invoice->currency }} {{ number_format($invoice->total_amount - $invoice->paid, 2) }}
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Notes -->
                            @if($invoice->notes)
                            <div style="margin-top:20px; background:#fef9c3; padding:15px; border-left:4px solid #facc15; border-radius:4px;">
                                <strong style="display:block; margin-bottom:5px;">Notes:</strong>
                                <span>{{ $invoice->notes }}</span>
                            </div>
                            @endif

                            <!-- Payment Method -->
                            @if($invoice->payment_method)
                            <div style="margin-top:20px; background:#eff6ff; padding:15px; border-left:4px solid #3b82f6; border-radius:4px;">
                                <strong>Payment Method:</strong> {{ $invoice->payment_method }}
                            </div>
                            @endif

                            <!-- Call to Action -->
                            @if($invoice->status !== 'paid')
                            <div style="text-align:center; margin:40px 0;">
                                <a href="{{ route('invoice.show', $invoice->id) }}"
                                   style="background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 28px; border-radius:6px; font-weight:bold; display:inline-block;">
                                    View Invoice Online
                                </a>
                            </div>
                            @endif

                            <!-- Footer Message -->
                            <p style="font-size:15px; line-height:1.6; margin:0 0 15px;">
                                If you have any questions about this invoice, please contact us.
                            </p>
                            <p style="font-size:15px; margin-bottom:25px;">Thank you for your business!</p>

                            <p style="font-weight:bold; color:#111;">
                                Best regards,<br>
                                <span style="color:#2563eb;">{{ config('app.name') }}</span>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color:#111827; color:#9ca3af; padding:20px; font-size:13px;">
                            <p style="margin:0 0 5px;">This is an automated message — please do not reply.</p>
                            <p style="margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>