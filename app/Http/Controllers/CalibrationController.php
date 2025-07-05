<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instrument;
use App\Models\Calibration;
use Carbon\Carbon;
use PDF;  // at the top of the controller


class CalibrationController extends Controller
{


public function index(Request $request)
{
    $date = $request->date ? Carbon::parse($request->date)->toDateString() : null;

    $query = Calibration::with('instrument')->orderBy('calibration_date', 'desc');

    if ($date) {
        $query->whereDate('calibration_date', $date);
    }

    $calibrations = $query->get();

    // Group all by date
    $calibrationsByDate = $calibrations->groupBy(function ($item) {
        return Carbon::parse($item->calibration_date)->toDateString();
    });

    return view('calibrations.index', compact('calibrationsByDate', 'date'));
}





    public function create()
    {
        $instruments = Instrument::all();
        return view('calibrations.create', compact('instruments'));
    }

public function store(Request $request)
{
    $date = $request->calibration_date;

    // Check if ANY calibration already exists for this date
    $alreadyChecked = Calibration::whereDate('calibration_date', $date)->exists();

    if ($alreadyChecked) {
        return redirect()->back()->with('error', "❌ L'étalonnage pour la date $date a déjà été effectué.");
    }

    // Save all calibrations
    foreach ($request->calibrations as $instrumentId => $data) {
        Calibration::create([
            'instrument_id' => $instrumentId,
            'calibration_date' => $date,
            'verified' => $data['verified'],
            'conform' => $data['conform'],
            'comment' => $data['comment'],
            'signature' => $data['signature'],
        ]);
    }

    // Redirect to the calibrations index page instead of back
    return redirect()->route('calibrations.index')->with('success', '✅ Étalonnage enregistré avec succès pour la date ' . $date);
}


public function downloadPdf(Request $request)
{
    $date = $request->date ? Carbon::parse($request->date)->toDateString() : Carbon::today()->toDateString();

    $calibrations = Calibration::with('instrument')
        ->whereDate('calibration_date', $date)
        ->orderBy('calibration_date', 'desc')
        ->get();

    $calibrationsByDate = $calibrations->groupBy('calibration_date');

    $logo = $this->getLogoForPdf();

    $pdf = PDF::loadView('calibrations.pdf', compact('calibrationsByDate', 'date', 'logo'));

    return $pdf->download('etallonage_' . $date . '.pdf');
}


protected function getLogoForPdf()
{
    $logoPath = public_path('images/sweet.png');

    if (file_exists($logoPath)) {
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        $data = file_get_contents($logoPath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    return null;
}


}
