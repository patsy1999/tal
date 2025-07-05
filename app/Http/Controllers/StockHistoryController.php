<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockUsage; // create this model next if needed
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;



class StockHistoryController extends Controller
{
    public function index(Request $request)
{
    $query = StockUsage::query();

    if ($request->filled('month')) {
        $month = $request->input('month');
        $query->whereMonth('date', Carbon::parse($month)->month)
              ->whereYear('date', Carbon::parse($month)->year);
    }

    $usages = $query->orderBy('date')->get();

    return view('stock.history', compact('usages'));
}


    public function add()
{
    $last = StockUsage::orderByDesc('date')->first();

    if (!$last) {
        return back()->with('error', 'No data to add from.');
    }

    $newDate = Carbon::parse($last->date)->addDay();
    $newStock = max($last->stock_quantity - 2, 0); // avoid negative
    $newUsage = 2;

    StockUsage::create([
        'date' => $newDate,
        'used_quantity' => $newUsage,
        'stock_quantity' => $newStock,
    ]);

    return redirect()->route('stock.history')->with('success', 'New day added!');
}


public function downloadPDF(Request $request)
{
    if (!$request->filled('month')) {
        return back()->with('error', 'Veuillez sélectionner un mois avant de télécharger.');
    }

    $month = Carbon::parse($request->month);
    $usages = StockUsage::whereYear('date', $month->year)
                        ->whereMonth('date', $month->month)
                        ->orderBy('date')
                        ->get();
    $logo = $this->getLogoForPdf(); // ✅ Get logo
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('stock.pdf', compact('usages', 'month','logo'));

    $filename = 'historique_stock_' . $month->format('Y_m') . '.pdf';

    return $pdf->download($filename);
}

       protected function getLogoForPdf()
    {
        $logoPath = public_path('images/sweet.png');

        // Check if logo exists, return base64 encoded version
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return null;
    }


}
