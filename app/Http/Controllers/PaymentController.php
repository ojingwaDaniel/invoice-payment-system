<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;
use App\Mail\ReceiptMail;

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
        $company = $invoice->company;
        $secretKey = $company->paystack_secret_key ?? config('services.paystack.secret');

        if (!$secretKey) {
            return redirect()->route('dashboard')->with('error', 'Company has no Paystack key connected.');
        }

        // Verify payment
        $response = Http::withToken($secretKey)
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->ok()) {
            return redirect()->route('dashboard')->with('error', 'Failed to verify payment.');
        }

        $data = $response->json();

        // Check Paystack success
        if (isset($data['data']['status']) && $data['data']['status'] === 'success') {

            // MARK AS PAID
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'paystack',
                'paid' => $invoice->total_amount,
                'paid_at' => now(),
            ]);

            // GENERATE PDF RECEIPT
            $pdf = Pdf::loadView('invoices.receipt-download', [
                'invoice' => $invoice
            ])->output();

            // SEND RECEIPT EMAIL
            Mail::to($invoice->customer->email)->send(new ReceiptMail($invoice, $pdf));

            return redirect()
                ->route('invoices.show', $invoice->id)
                ->with('success', 'Payment verified and receipt emailed to customer!');
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

                $company = $invoice->company;
                $secret = $company->paystack_secret_key ?? config('services.paystack.secret');
                $signature = $request->header('x-paystack-signature');

                // Validate signature
                if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $secret)) {
                    Log::warning("Invalid Paystack webhook signature for invoice {$invoice->id}");
                    return response('Invalid signature', 401);
                }

                // UPDATE INVOICE
                $invoice->update([
                    'status' => 'paid',
                    'payment_method' => 'paystack',
                    'paid' => $invoice->total_amount,
                    'paid_at' => now(),
                ]);

                // CREATE PDF FOR EMAIL
                $pdf = Pdf::loadView('invoices.receipt-download', [
                    'invoice' => $invoice
                ])->output();

                // SEND EMAIL
                Mail::to($invoice->customer->email)->send(new ReceiptMail($invoice, $pdf));

                Log::info("Invoice {$invoice->id} marked as paid AND receipt emailed via webhook.");
            }
        }

        return response('Webhook handled', 200);
    }
}
