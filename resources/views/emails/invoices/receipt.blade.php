<p>Hello {{ $invoice->customer->name }},</p>

<p>Your payment has been successfully received. Attached is your official receipt.</p>

<p>Invoice Number: <strong>{{ $invoice->invoice_number }}</strong></p>
<p>Total Paid: <strong>{{ number_format($invoice->total_amount, 2) }}</strong></p>

<p>Thank you for doing business with us.</p>

<p>Regards,<br>
{{ $invoice->user->company->name }}</p>
