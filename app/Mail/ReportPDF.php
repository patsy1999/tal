<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportPDF extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;

    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Rapport PDF Température')
            ->markdown('emails.report')
            ->attachData($this->pdf->output(), 'rapport-temperature.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
