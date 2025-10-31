<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle Paystack redirect callback after payment.
     */
    public function handleCallback(Request $request, Invoice $invoice)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('dashboard')->with('error', 'Missing payment reference.');
        }

        // Verify the transaction with Paystack
        $response = Http::withToken(config('services.paystack.secret'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->ok()) {
            return redirect()->route('dashboard')->with('error', 'Failed to verify payment.');
        }

        $data = $response->json();

        if (isset($data['data']['status']) && $data['data']['status'] === 'success') {
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'paystack',
                'paid' => $invoice->total_amount,
            ]);

            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Payment successful!');
        }

        return redirect()->route('invoices.show', $invoice->id)->with('error', 'Payment not completed.');
    }

    /**
     * Handle Paystack Webhook notifications (server to server).
     */
    public function handleWebhook(Request $request)
    {
        // Verify the webhook signature
        $secret = config('services.paystack.secret');
        $signature = $request->header('x-paystack-signature');

        if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $secret)) {
            Log::warning('Invalid Paystack webhook signature');
            return response('Invalid signature', 401);
        }

        $event = $request->event;
        $data = $request->data;

        if ($event === 'charge.success' && isset($data['reference'])) {
            $reference = $data['reference'];

            // Retrieve the invoice using the reference (store this reference when initializing)
            $invoice = Invoice::where('invoice_number', $reference)->first();

            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'payment_method' => 'paystack',
                    'paid' => $invoice->total_amount,
                ]);
            }
        }

        return response('Webhook handled', 200);
    }
}
