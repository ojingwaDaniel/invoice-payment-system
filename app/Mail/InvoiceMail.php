<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;
    public string $pdfData;
    public bool $canPayOnline;

    /**
     * Create a new message instance.
     */
    public function __construct(
        Invoice $invoice,
        string $pdfData,
        bool $canPayOnline = false
    ) {
        $this->invoice = $invoice;
        $this->pdfData = $pdfData;
        $this->canPayOnline = $canPayOnline;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Invoice #' . $this->invoice->invoice_number)
            ->markdown('emails.invoices.send')
            ->attachData(
                $this->pdfData,
                'invoice-' . $this->invoice->invoice_number . '.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
