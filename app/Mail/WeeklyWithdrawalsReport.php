<?php

namespace App\Mail;
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyWithdrawalsReport extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Rapport Hebdomadaire des Retraits')
            ->view('emails.weekly-summary') // Optional: you can create a simple email template
            ->attachData($this->pdfContent, 'rapport-retraits.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}

