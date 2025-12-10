@extends('layouts.app')

@section('content')
    <h2>Pay with Paystack</h2>

    <form method="POST" action="#" id="paymentForm">
        @csrf

        <button type="button" onclick="payWithPaystack()">Pay ₦{{ number_format($invoice->total_amount, 2) }}</button>
    </form>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        function payWithPaystack() {
            let handler = PaystackPop.setup({
                key: "{{ $paystackPublic }}",
                email: "{{ $invoice->customer->email }}",
                amount: {{ intval($invoice->total_amount * 100) }},
                ref: "{{ 'INV-' . $invoice->id . '-' . uniqid() }}"
            });

            handler.openIframe();
        }
    </script>
@endsection
