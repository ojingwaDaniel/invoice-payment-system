@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-10 flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-8 text-center">

        <div class="flex justify-center mb-6">
            <div class="h-20 w-20 bg-red-100 text-red-600 flex items-center justify-center rounded-full shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-red-700 mb-2">Payment Failed</h1>
        <p class="text-gray-600 mb-6">
            Unfortunately, we couldn’t process your payment for Invoice #{{ $invoice->id }}.
        </p>

        <a href="{{ route('invoice.public.pay', $invoice->id) }}"
           class="px-6 py-3 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
            Try Again
        </a>
    </div>
</div>
@endsection
