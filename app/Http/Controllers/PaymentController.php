<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;

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

        // Get the company that owns this invoice
        $company = $invoice->user; // assumes Invoice belongsTo User
        $secretKey = $company->paystack_secret_key ?? config('services.paystack.secret');

        if (!$secretKey) {
            return redirect()->route('dashboard')->with('error', 'Company has no Paystack key connected.');
        }

        // Verify payment with the company’s Paystack key
        $response = Http::withToken($secretKey)
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->ok()) {
            return redirect()->route('dashboard')->with('error', 'Failed to verify payment.');
        }

        $data = $response->json();

        // Check Paystack response
        if (isset($data['data']['status']) && $data['data']['status'] === 'success') {
            // ✅ Update invoice as paid
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'paystack',
                'paid' => $invoice->total_amount,
            ]);

            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', '✅ Payment verified successfully!');
        }

        return redirect()
            ->route('invoices.show', $invoice->id)
            ->with('error', 'Payment not completed or verification failed.');
    }

    /**
     * Handle Paystack Webhook notifications (server to server).
     */
    public function handleWebhook(Request $request)
    {
        $event = $request->event ?? null;
        $data = $request->data ?? [];

        if ($event === 'charge.success' && isset($data['reference'])) {
            $reference = $data['reference'];
            $invoice = Invoice::where('invoice_number', $reference)->first();

            if ($invoice) {
                $company = $invoice->user;
                $secret = $company->paystack_secret_key ?? config('services.paystack.secret');
                $signature = $request->header('x-paystack-signature');

                // Verify signature
                if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $secret)) {
                    Log::warning("Invalid Paystack webhook signature for invoice {$invoice->id}");
                    return response('Invalid signature', 401);
                }

                // ✅ Update invoice as paid
                $invoice->update([
                    'status' => 'paid',
                    'payment_method' => 'paystack',
                    'paid' => $invoice->total_amount,
                ]);

                Log::info("Invoice {$invoice->id} marked as paid via webhook.");
            }
        }

        return response('Webhook handled', 200);
    }
}
