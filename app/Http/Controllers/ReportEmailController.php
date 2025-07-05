<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF; // barryvdh/laravel-dompdf required
use App\Mail\ReportPDF;
use App\Models\TookenItem;
use App\Mail\WeeklyWithdrawalsReport;

class ReportEmailController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Generate PDF (you can customize this view and data)
        $data = ['title' => 'Rapport Température'];
        $pdf = PDF::loadView('pdf.temperature-report', $data);

        // Send Email
        Mail::to($request->email)->send(new ReportPDF($pdf));

        return back()->with('success', 'Le rapport PDF a été envoyé avec succès.');
    }




public function sendWeeklyWithdrawalReport(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $startDate = now()->subDays(7);
    $endDate = now();

    $data = TookenItem::with(['user', 'product'])
        ->whereBetween('taken_at', [$startDate, $endDate])
        ->get();

    $pdf = PDF::loadView('pdf.weekly-withdrawals', ['data' => $data]);

    Mail::to($request->email)->send(new WeeklyWithdrawalsReport($pdf->output()));

    return back()->with('success', 'Rapport envoyé à ' . $request->email);
}


}
