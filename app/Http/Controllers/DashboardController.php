<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\TookenItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyWithdrawalsReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function sendWeeklyWithdrawalReport(Request $request)
    {
                    // Validate email input
                    $request->validate([
                        'email' => 'required|email',
                    ]);

                    $email = $request->input('email');

                    // Set date range (last 7 days)
                    $startDate = now()->subDays(7);
                    $endDate = now();

                    // Get withdrawal data with related user and product
                    $data = TookenItem::with(['user', 'product'])
                        ->whereBetween('taken_at', [$startDate, $endDate])
                        ->get();

                    // Generate the PDF from Blade view
                    $pdf = PDF::loadView('pdf.weekly-withdrawals', ['data' => $data]);

                    // Send email with attached PDF
                    Mail::to($email)->send(new WeeklyWithdrawalsReport($pdf->output()));

                    // Redirect back with success message
                    return back()->with('success', 'Rapport PDF envoyé avec succès à ' . $email . '.');
    }


public function sendReportEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->email;

    // Generate PDF
    $data = TookenItem::with(['user', 'product'])
        ->where('taken_at', '>=', now()->subDays(7))
        ->get();

    $pdf = PDF::loadView('pdf.weekly-report', ['data' => $data]);

    // Send email
    Mail::to($email)->send(new WeeklyWithdrawalsReport($pdf->output()));

    return back()->with('success', 'Rapport envoyé avec succès à ' . $email);
}

}
