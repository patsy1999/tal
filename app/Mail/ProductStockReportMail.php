<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductStockReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('État actuel du stock')
                    ->view('emails.product-stock-summary')
                    ->attachData($this->pdfContent, 'stock-report.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
