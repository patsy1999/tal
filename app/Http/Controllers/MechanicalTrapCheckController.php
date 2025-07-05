<?php

namespace App\Http\Controllers;

use App\Models\MechanicalTrapCheck;
use Illuminate\Http\Request;

class MechanicalTrapCheckController extends Controller
{
    public function create()
    {
        $traps = collect(range(1, 14))->map(function ($i) {
            return 'TR' . str_pad($i, 2, '0', STR_PAD_LEFT);
        });

        return view('mechanical_traps.create', compact('traps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'check_date' => 'required|date',
            'captures' => 'required|array',
            'actions' => 'required|array',
        ]);

        foreach ($request->captures as $code => $count) {
            MechanicalTrapCheck::updateOrCreate(
                ['check_date' => $request->check_date, 'trap_code' => $code],
                [
                    'captures' => $count,
                    'action_taken' => $request->actions[$code] ?? 'RAS',
                ]
            );
        }

        return redirect()->route('rat-traps.index')->with('success', 'Données enregistrées avec succès.');
    }

    public function index(Request $request)
    {
        $query = MechanicalTrapCheck::query();

        if ($request->filled('date')) {
            $query->where('check_date', $request->date);
        }

        $grouped = $query->orderBy('check_date', 'desc')->get()->groupBy('check_date');

        return view('mechanical_traps.index', compact('grouped'));
    }
}
