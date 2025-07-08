<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\DailyEquipment;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;   // Important!


class DailyEquipmentController extends Controller
{
        public function index(Request $request)
{
        $date = $request->query('date');
        $records = collect();

        if ($date) {
            $records = DailyEquipment::whereDate('date', $date)->get();
        }

        // 👉 Get records for the previous month
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthRecords = DailyEquipment::whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->orderBy('date')
            ->orderBy('equipment_name')
            ->get();

        $lastMonthName = $lastMonthStart->format('F Y'); // e.g., "June 2025"

        return view('daily_equipments.index', compact('records', 'date', 'lastMonthRecords', 'lastMonthName'));
}




        public function create()
        {
            $equipments = Equipment::orderBy('name')->get();
            return view('daily_equipments.create', compact('equipments'));
        }

        public function store(Request $request)
        {
            $date = $request->input('date');
            $statuses = $request->input('equipment_status');
            $observations = $request->input('observations');

            // ✅ Check if records for this date already exist
            $alreadyExists = \App\Models\DailyEquipment::whereDate('date', $date)->exists();

            if ($alreadyExists) {
                return redirect()->route('daily_equipments.index')->with('error', "Les enregistrements pour la date $date existent déjà.");
            }

            // ✅ Save new records
            foreach ($statuses as $name => $isGood) {
                \App\Models\DailyEquipment::create([
                    'date' => $date,
                    'equipment_name' => $name,
                    'is_good' => $isGood,
                    'observation' => $observations[$name] ?? 'RAS',
                ]);
            }

            // ✅ Redirect to list page with success
            return redirect()->route('daily_equipments.index')->with('success', 'Contrôle enregistré avec succès.');
        }

       public function exportMonthlyPdf(Request $request)
{
    $month = $request->query('month'); // Format: YYYY-MM

    if (!$month) {
        return redirect()->route('daily_equipments.index')->with('error', 'Veuillez sélectionner un mois.');
    }

    [$year, $monthNum] = explode('-', $month);

    $records = DailyEquipment::whereYear('date', $year)
        ->whereMonth('date', $monthNum)
        ->orderBy('date')
        ->orderBy('equipment_name')
        ->get();

    if ($records->isEmpty()) {
        return redirect()->route('daily_equipments.index')->with('error', 'Aucun enregistrement pour ce mois.');
    }

    $pdf = Pdf::loadView('daily_equipments.pdf_month', compact('records', 'month'));

    return $pdf->download("controle_equipements_$month.pdf");
}


        public function generateRange(Request $request)
        {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Access denied');
            }

            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $start = Carbon::parse($request->input('start_date'));
            $end = Carbon::parse($request->input('end_date'));
            $equipments = Equipment::orderBy('name')->get();

            if ($equipments->isEmpty()) {
                return back()->with('error', 'Aucun équipement disponible.');
            }

            // Check if any data already exists in that range
            $alreadyExists = DailyEquipment::whereBetween('date', [$start, $end])->exists();

            if ($alreadyExists) {
                return redirect()->route('daily_equipments.index')->with('error', "Des enregistrements existent déjà dans cette plage de dates.");
            }

            foreach ($start->daysUntil($end->copy()->addDay()) as $day) {
                foreach ($equipments as $equipment) {
                    DailyEquipment::create([
                        'date' => $day->format('Y-m-d'),
                        'equipment_name' => $equipment->name,
                        'is_good' => true,
                        'observation' => 'RAS',
                    ]);
                }
            }

            return redirect()->route('daily_equipments.index')->with('success', "Les données entre {$start->format('d/m/Y')} et {$end->format('d/m/Y')} ont été générées avec succès.");
        }





        public function generateMonth(Request $request)
        {
             if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }
            $month = $request->input('month'); // Format: YYYY-MM

            if (!$month) {
                return back()->with('error', 'Veuillez sélectionner un mois.');
            }

            [$year, $monthNum] = explode('-', $month);

            // ✅ Check if any data exists for this month
            $alreadyExists = DailyEquipment::whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->exists();

            if ($alreadyExists) {
                return redirect()->route('daily_equipments.index')->with('error', "Les enregistrements pour le mois $month existent déjà.");
            }

            $start = Carbon::createFromDate($year, $monthNum, 1);
            $end = $start->copy()->endOfMonth();
            $equipments = Equipment::orderBy('name')->get();

            if ($equipments->isEmpty()) {
                return back()->with('error', 'Aucun équipement disponible.');
            }

            // ✅ Generate data only if month is empty
            foreach ($start->daysUntil($end->addDay()) as $day) {
                foreach ($equipments as $equipment) {
                    DailyEquipment::create([
                        'date' => $day->format('Y-m-d'),
                        'equipment_name' => $equipment->name,
                        'is_good' => true,
                        'observation' => 'RAS',
                    ]);
                }
            }

            return redirect()->route('daily_equipments.index')->with('success', "Les données du mois $month ont été générées avec succès.");
        }
        public function showMonth(Request $request)
        {
            $month = $request->input('month'); // format: YYYY-MM

            if (!$month) {
                return redirect()->route('daily_equipments.index')->with('error', 'Veuillez sélectionner un mois.');
            }

            // Get start and end dates of month
            $startDate = $month . '-01';
            $endDate = date('Y-m-t', strtotime($startDate)); // last day of month

            // Fetch records for that month
            $records = DailyEquipment::whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->orderBy('equipment_name', 'asc')
                ->get();

            return view('daily_equipments.month', compact('records', 'month'));
        }


      public function exportPdf(Request $request)
{
    $date = $request->query('date'); // e.g. "2025-07-02"

    if (!$date) {
        return redirect()->route('daily_equipments.index')->with('error', 'Veuillez sélectionner une date.');
    }

    $records = \App\Models\DailyEquipment::whereDate('date', $date)
        ->orderBy('equipment_name')
        ->get();

    if ($records->isEmpty()) {
        return redirect()->route('daily_equipments.index')->with('error', "Aucun enregistrement trouvé pour la date $date.");
    }

    $logo = $this->getLogoForPdf(); // ✅ Get logo
    $pdf = Pdf::loadView('daily_equipments.pdf_day', compact('records', 'date', 'logo')); // ✅ Pass logo

    return $pdf->download("controle_equipements_$date.pdf");
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
