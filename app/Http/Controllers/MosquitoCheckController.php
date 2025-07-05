<?php

namespace App\Http\Controllers;

use App\Models\MosquitoCheck;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MosquitoCheckController extends Controller
{
    public function index(Request $request)
    {
        $monthInput = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($monthInput . '-01')->startOfMonth();
        $endDate = (clone $startDate)->endOfMonth();

        $records = MosquitoCheck::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        return view('mosquito.index', ['records' => $records, 'month' => $monthInput]);
    }

    public function create()
    {
        return view('mosquito.create');
    }

    public function store(Request $request)
    {
        // Validate input - note month_label removed here, will be set programmatically
        $validated = $request->validate([
            'date' => 'required|date|unique:mosquito_checks,date',
            'D01' => 'nullable|string',
            'D02' => 'nullable|string',
            'D03' => 'nullable|string',
            'D04' => 'nullable|string',
            'D05' => 'nullable|string',
            'D06' => 'nullable|string',
            'D07' => 'nullable|string',
            'D08' => 'nullable|string',
            'D09' => 'nullable|string',
            'D10' => 'nullable|string',
            'D11' => 'nullable|string',
            'D12' => 'nullable|string',
            'D13' => 'nullable|string',
            'D14' => 'nullable|string',
            'D15' => 'nullable|string',
            'moustiquaire' => 'nullable|string',
            'etat_nettoyage' => 'nullable|string',
            'action_corrective' => 'nullable|string',
        ]);

        // Set month_label automatically based on the date field
        $validated['month_label'] = Carbon::parse($validated['date'])->format('M-y');

        MosquitoCheck::create($validated);

        return redirect()->route('mosquito.index')->with('success', 'Enregistrement du jour ajouté.');
    }

    public function exportPDF(Request $request)
    {
        $monthInput = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($monthInput . '-01')->startOfMonth();
        $endDate = (clone $startDate)->endOfMonth();

        $records = MosquitoCheck::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        // Pass $month (as the formatted string, or just monthInput)
        return Pdf::loadView('mosquito.pdf', [
            'records' => $records,
            'month' => $monthInput,  // this variable is available in blade as $month
        ])->download('mosquito_check_' . $monthInput . '.pdf');
    }



    public function generate(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        // Limit max days to prevent huge inserts (optional)
        $maxDays = 31;
        if ($start->diffInDays($end) + 1 > $maxDays) {
            return redirect()->back()->withErrors("La plage de dates ne peut pas dépasser $maxDays jours.");
        }

        DB::beginTransaction();

        try {
            for ($date = $start; $date->lte($end); $date->addDay()) {

                // Check if record for this date already exists, skip if yes
                $exists = MosquitoCheck::where('date', $date->toDateString())->exists();
                if ($exists) {
                    continue;
                }

                $monthLabel = $date->format('M-y');  // or use locale if you want

                MosquitoCheck::create([
                    'date' => $date->toDateString(),
                    'month_label' => $monthLabel,
                    // Fill D01-D15 with "C"
                    'D01' => 'C', 'D02' => 'C', 'D03' => 'C', 'D04' => 'C', 'D05' => 'C',
                    'D06' => 'C', 'D07' => 'C', 'D08' => 'C', 'D09' => 'C', 'D10' => 'C',
                    'D11' => 'C', 'D12' => 'C', 'D13' => 'C', 'D14' => 'C', 'D15' => 'C',
                    'moustiquaire' => 'C','etat_nettoyage' => 'C',
                    // Set action_corrective as "R.A.S"
                    'action_corrective' => 'R.A.S',
                    // You can fill other nullable fields with null or defaults
                ]);
            }

            DB::commit();

            return redirect()->route('mosquito.index')->with('success', 'Enregistrements générés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Erreur lors de la génération des enregistrements : ' . $e->getMessage());
        }
    }

    public function destroy($id)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
    $record = MosquitoCheck::findOrFail($id);
    $record->delete();

    return redirect()->route('mosquito.index')->with('success', 'Ligne supprimée avec succès.');
}
    public function clear()
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        \App\Models\MosquitoCheck::truncate(); // 💥 Deletes all records from the table instantly
        return redirect()->route('mosquito.index')->with('success', 'Toutes les données ont été supprimées.');
    }



}
