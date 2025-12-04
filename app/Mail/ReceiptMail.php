<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {

        $pdf = Pdf::loadView('invoices.receipt-pdf', [
            'invoice' => $this->invoice,
        ]);

        return $this->subject('Your Payment Receipt - ' . $this->invoice->invoice_number)
            ->view('emails.invoices.receipt')
            ->attachData(
                $pdf->output(),
                'receipt-' . $this->invoice->invoice_number . '.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
