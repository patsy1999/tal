<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF;

class WeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;

    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->view('emails.dummy')
            ->subject('Weekly Report')
            ->attachData($this->pdf->output(), 'weekly_report.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
