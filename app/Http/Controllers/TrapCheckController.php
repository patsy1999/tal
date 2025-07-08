<?php

namespace App\Http\Controllers;

use App\Models\RatTrapCheck;
use App\Models\MechanicalTrapCheck;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TrapCheckController extends Controller
{
 // Edit a single raticide record by ID
public function editRaticide($id)
{
    $record = RatTrapCheck::findOrFail($id);
    return view('trap_checks.edit_raticide', compact('record'));
}

// Update a single raticide record by ID
public function updateRaticide(Request $request, $id)
{
    $record = RatTrapCheck::findOrFail($id);

    $validated = $request->validate([
        'bait_touched' => 'required|string',
        'corpse_present' => 'required|string',
        'action_taken' => 'nullable|string',
    ]);

    $record->update($validated);

    return redirect()->route('trap-checks.index')->with('success', 'Enregistrement Raticide mis à jour.');
}


    public function create()
    {


        return view('trap_checks.create');
    }

    public function store(Request $request)
    {
            $date = $request->input('check_date'); // or however your date input is named

        // Check if any records exist for that date in either table
            $existsRaticide = RatTrapCheck::where('check_date', $date)->exists();
            $existsMecanique = MechanicalTrapCheck::where('check_date', $date)->exists();

            if ($existsRaticide || $existsMecanique) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['check_date' => 'Désolé, les données pour ce jour existent déjà. Vous ne pouvez pas créer une nouvelle entrée pour cette date.']);
            }
            $request->validate([
                'check_date' => 'required|date',
                'raticide' => 'required|array',
                'mecanique.captures' => 'required|array',
                'mecanique.actions' => 'required|array',
            ]);

            $date = $request->check_date;

            // Save raticide data
            foreach ($request->raticide as $trapNumber => $data) {
                RatTrapCheck::updateOrCreate(
                    ['check_date' => $date, 'trap_number' => $trapNumber],
                    [
                        'bait_touched' => $data['bait_touched'],
                        'corpse_present' => $data['corpse_present'],
                        'action_taken' => $data['action_taken'] ?? 'RAS',
                    ]
                );
            }

            // Save mécanique data
            foreach ($request->mecanique['captures'] as $trapCode => $count) {
                MechanicalTrapCheck::updateOrCreate(
                    ['check_date' => $date, 'trap_code' => $trapCode],
                    [
                        'captures' => $count,
                        'action_taken' => $request->mecanique['actions'][$trapCode] ?? 'RAS',
                    ]
                );
            }

            return redirect()->route('trap-checks.index')->with('success', 'Toutes les données ont été enregistrées.');

    }

    public function index(Request $request)
    {
        $date = $request->date;

        $raticideRecords = RatTrapCheck::when($date, fn($q) => $q->where('check_date', $date))
            ->orderBy('trap_number')->get()->groupBy('check_date');

        $mecaniqueRecords = MechanicalTrapCheck::when($date, fn($q) => $q->where('check_date', $date))
            ->orderBy('trap_code')->get()->groupBy('check_date');

        return view('trap_checks.index', compact('raticideRecords', 'mecaniqueRecords'));
    }


    public function exportPdf($date)
    {
        $raticideRecords = RatTrapCheck::where('check_date', $date)
            ->orderBy('trap_number')->get();

        $mecaniqueRecords = MechanicalTrapCheck::where('check_date', $date)
            ->orderBy('trap_code')->get();

        $pdf = Pdf::loadView('trap_checks.pdf', [
            'date' => $date,
            'raticideRecords' => $raticideRecords,
            'mecaniqueRecords' => $mecaniqueRecords
        ]);

        return $pdf->download("Suivi-Traps-{$date}.pdf");
    }


    public function clearDate($date)
        {
            if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }
            RatTrapCheck::where('check_date', $date)->delete();
            MechanicalTrapCheck::where('check_date', $date)->delete();

            return redirect()->route('trap-checks.index')->with('success', "Toutes les données du $date ont été supprimées.");
        }
            public function destroy($id)
        {
            if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied');
        }
            // First, try deleting from both tables just in case
            $raticide = \App\Models\RatTrapCheck::find($id);
            if ($raticide) {
                $raticide->delete();
                return back()->with('success', 'Enregistrement Raticide supprimé.');
            }

            $mecanique = \App\Models\MechanicalTrapCheck::find($id);
            if ($mecanique) {
                $mecanique->delete();
                return back()->with('success', 'Enregistrement Mécanique supprimé.');
            }

            return back()->with('error', 'Enregistrement introuvable.');
        }

}
