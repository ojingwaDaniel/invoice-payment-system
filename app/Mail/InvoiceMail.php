<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, $pdfData)
    {
        $this->invoice = $invoice;
        $this->pdfData = $pdfData;
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
