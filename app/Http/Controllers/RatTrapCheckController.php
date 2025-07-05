<?php

namespace App\Http\Controllers;

use App\Models\RatTrapCheck;
use Illuminate\Http\Request;

class RatTrapCheckController extends Controller
{

    public function index(Request $request)
{
    $query = \App\Models\RatTrapCheck::query();

    if ($request->filled('date')) {
        $query->where('check_date', $request->date);
    }

    $records = $query->orderBy('check_date', 'desc')->get();
    $grouped = $records->groupBy('check_date');

    return view('rat_traps.index', compact('grouped'));
}


    public function create()
    {
        return view('rat_traps.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_date' => 'required|date',
            'traps' => 'required|array',
            'traps.*.bait_touched' => 'required|in:Oui,Non',
            'traps.*.corpse_present' => 'required|in:Oui,Non',
            'traps.*.action_taken' => 'required|string|max:255',
        ]);

        foreach ($validated['traps'] as $trap_number => $data) {
            RatTrapCheck::updateOrCreate(
                ['check_date' => $validated['check_date'], 'trap_number' => $trap_number],
                [
                    'bait_touched' => $data['bait_touched'],
                    'corpse_present' => $data['corpse_present'],
                    'action_taken' => $data['action_taken'],
                ]
            );
        }

        return redirect()->route('mechanical-traps.create')->with('success', 'Données enregistrées avec succès.');

    }
        public function destroy($id)
    {
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
        public function clearDate($date)
        {
            \App\Models\RatTrapCheck::where('check_date', $date)->delete();
            \App\Models\MechanicalTrapCheck::where('check_date', $date)->delete();

            return redirect()->route('trap-checks.index')->with('success', "Toutes les données du $date ont été supprimées.");
        }

}
