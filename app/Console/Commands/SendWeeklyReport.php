<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TookenItem;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class SendWeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Generate weekly report and email it';

    public function handle()
    {
        $data = TookenItem::with(['user', 'product'])
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        $pdf = Pdf::loadView('reports.weekly', compact('data'));

        $filename = 'weekly_report_' . now()->format('Ymd_His') . '.pdf';

        Mail::raw('Attached is the weekly product withdrawal report.', function ($message) use ($pdf, $filename) {
            $message->to([
                'zaidalq4@gmail.com',
                'zaidaliqui035@gmail.com',
            ])
            ->subject('Weekly Stock Report')
            ->attachData($pdf->output(), $filename);
        });

        $this->info('Weekly report email sent!');
    }
}
