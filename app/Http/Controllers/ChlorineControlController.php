<?php
// app/Http/Controllers/ChlorineControlController.php

namespace App\Http\Controllers;

use App\Models\ChlorineControl;
use Illuminate\Http\Request;
use PDF; // alias for DomPDF
use Carbon\Carbon;

class ChlorineControlController extends Controller
{
   public function index()
{
    $records = \App\Models\ChlorineControl::orderBy('date')->orderBy('heure')->get();
    return view('chlorine_controls.index', compact('records'));
}



public function showRandomMonthForm()
{
    return view('chlorine_controls.random_month_form');
}

public function generateRandomMonth(Request $request)
{
     if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $request->validate([
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2000|max:' . date('Y'),
    ]);

    $month = $request->input('month');
    $year = $request->input('year');

    // Get the number of days in the selected month
    $daysInMonth = Carbon::create($year, $month)->daysInMonth;

    $heures = ['09:00', '14:00'];
    $points = ['Réfectoire', 'Lave-mains'];

    $createdCount = 0;
    $skippedCount = 0;

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = Carbon::create($year, $month, $day)->format('Y-m-d');

        // Skip if date already has records
        if (ChlorineControl::where('date', $date)->exists()) {
            $skippedCount++;
            continue;
        }

        // Generate random chlorine ppm between 0.27 and 0.41 (two decimals)
        $ppm_min = round(mt_rand(27, 41) / 100, 2);
        $ppm_max = round(mt_rand(27, 41) / 100, 2);

        foreach ($heures as $index => $heure) {
            ChlorineControl::create([
                'date' => $date,
                'heure' => $heure,
                'sampling_point' => $points[$index],
                'chlorine_ppm_min' => $ppm_min,
                'chlorine_ppm_max' => $ppm_max,
                'conforme' => true,
                'mesures_correctives' => 'R.A.S',
            ]);
        }

        $createdCount++;
    }

    return redirect()->route('chlorine-controls.index')->with('success', "Données générées pour $createdCount jours. $skippedCount jours déjà existants ont été ignorés.");
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

    public function create()
    {
        
        return view('chlorine_controls.create');
    }

   public function store(Request $request)
{

    $validated = $request->validate([
        'date' => 'required|date',
        'chlorine_ppm_min' => 'required|numeric',
        'chlorine_ppm_max' => 'required|numeric',
        'conforme' => 'required|boolean',
        'mesures_correctives' => 'nullable|string',
    ]);

    $heures = ['09:00', '14:00'];
    $points = ['Réfectoire', 'Lave-mains'];

    foreach ($heures as $index => $heure) {
        \App\Models\ChlorineControl::create([
            'date' => $validated['date'],
            'heure' => $heure,
            'sampling_point' => $points[$index],
            'chlorine_ppm_min' => $validated['chlorine_ppm_min'],
            'chlorine_ppm_max' => $validated['chlorine_ppm_max'],
            'conforme' => $validated['conforme'],
            'mesures_correctives' => $validated['mesures_correctives'],
        ]);
    }

    return redirect()->route('chlorine-controls.index')->with('success', 'Deux mesures enregistrées avec succès.');
}

protected static function booted()
{
    static::creating(function ($model) {
        if (is_null($model->chlorine_ppm_min)) {
            $model->chlorine_ppm_min = 0.27;
        }
        if (is_null($model->chlorine_ppm_max)) {
            $model->chlorine_ppm_max = 0.47;
        }
        if (is_null($model->mesures_correctives)) {
            $model->mesures_correctives = 'RAS';
        }
    });
}

// Step 1: Check if today already exists
public function checkToday()
{
     if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $today = now()->toDateString();

    $alreadyExists = \App\Models\ChlorineControl::where('date', $today)->exists();

    if (!$alreadyExists) {
        return $this->generateRandomWithDate($today);
    }

    // Otherwise, show a view with date picker
    return view('chlorine_controls.choose_date');
}

// Step 2: Handle user-submitted date
public function generateRandom(Request $request)
{
     if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $request->validate([
        'date' => 'required|date|before_or_equal:today',
    ]);

    $date = $request->input('date');

    $alreadyExists = \App\Models\ChlorineControl::where('date', $date)->exists();

    if ($alreadyExists) {
        return redirect()->back()->with('error', 'Cette date a déjà des données. Veuillez en choisir une autre.');
    }

    return $this->generateRandomWithDate($date);
}

// Core logic for inserting random values
private function generateRandomWithDate($date)
{
     if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $heures = ['09:00', '14:00'];
    $points = ['Réfectoire', 'Lave-mains'];

    foreach ($heures as $index => $heure) {
        $randomPpm = round(mt_rand(27, 43) / 100, 2);

        \App\Models\ChlorineControl::create([
            'date' => $date,
            'heure' => $heure,
            'sampling_point' => $points[$index],
            'chlorine_ppm_min' => $randomPpm,
            'chlorine_ppm_max' => $randomPpm,
            'conforme' => true,  // <---- Always "Oui"
            'mesures_correctives' => 'R.A.S',
        ]);
    }

    return redirect()->route('chlorine-controls.index')->with('success', "Données générées pour la date $date.");
}




// Show the form to select month and year
public function showPdfForm()
{
    return view('chlorine_controls.pdf_form');
}

// Generate and download PDF or show error if no data
public function exportPdf(Request $request)
{

    $request->validate([
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2000|max:' . date('Y'),
    ]);

    $month = $request->input('month');
    $year = $request->input('year');

    $records = \App\Models\ChlorineControl::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->orderBy('date')
        ->orderBy('heure')
        ->get();

    if ($records->isEmpty()) {
        return redirect()->back()->with('error', "Aucune donnée pour $month/$year. Veuillez choisir un autre mois.");
    }

    $grouped = $records->groupBy('date');

    $logoBase64 = $this->getLogoForPdf();

    $pdf = PDF::loadView('chlorine_controls.pdf_report', compact('grouped', 'month', 'year', 'logoBase64'));

    $filename = "controle_chlore_{$year}_{$month}.pdf";

    return $pdf->download($filename);
}



public function addRandomOnce()
{
     if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $today = now()->toDateString();

    // Check if a record already exists for today
    $alreadyExists = \App\Models\ChlorineControl::where('date', $today)->exists();

    if ($alreadyExists) {
        return redirect()->route('chlorine-controls.index')
            ->with('error', 'Un enregistrement existe déjà pour aujourd\'hui.');
    }

    // Random float between 0.27 and 0.43 with 2 decimals
    $randomPpm = round(mt_rand(27, 43) / 100, 2);

    \App\Models\ChlorineControl::create([
        'date' => $today,
        'heure' => '09:00',
        'sampling_point' => 'Réfectoire',
        'chlorine_ppm_min' => $randomPpm,
        'chlorine_ppm_max' => $randomPpm,
        'conforme' => ($randomPpm >= 0.3), // Example logic: >= 0.3 = Oui
        'mesures_correctives' => 'R.A.S',
    ]);

    return redirect()->route('chlorine-controls.index')
        ->with('success', 'Valeur aléatoire ajoutée avec succès.');
}


    public function show($id)
{

    $record = \App\Models\ChlorineControl::findOrFail($id);
    return view('chlorine_controls.show', compact('record'));
}

}
