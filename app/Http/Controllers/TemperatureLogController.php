<?php

namespace App\Http\Controllers;

use App\Models\TemperatureLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TemperatureLogController extends Controller
{
    public function downloadPDF(Request $request)
    {
        
        $validated = $request->validate([
            'date' => 'required|date',
            'data' => 'required|array',
        ]);

        // Prepare data for PDF
        $data = [
            'date' => $validated['date'],
            'locations' => [
                'Zone Réception', 'Tunnel 1', 'Tunnel 2', 'Tunnel 3', 'Tunnel 4',
                'Tunnel 6', 'Tunnel 7', 'Couloir des tunnels', 'Couloir des chambres',
                'Chambre froide 1', 'Chambre froide 2', 'Chambre froide 3',
                'Chambre froide 4', 'Chambre froide 5', 'Zone Manipulation 1',
                'Zone Manipulation 2', 'Tunnel 8', 'Tunnel 9', 'Tunnel 10',
                'Zone Expédition', 'Chambre froide 6', 'Chambre froide 7',
                'Chambre froide 8'
            ],
            'timeSlots' => ['08h', '12h', '16h', '20h', '00h', '04h'],
            'values' => $validated['data'],
            'logo' => $this->getLogoForPdf(),
            'Sin' => $this->getSinForPdf()
        ];

        // Generate PDF
        $pdf = PDF::loadView('temperature_logs.pdf', $data)
                  ->setPaper('a4', 'landscape')
                  ->setOption('defaultFont', 'Helvetica')
                  ->setOption('isRemoteEnabled', true); // Enable external resources

        return $pdf->download('temperature-verification-'.$validated['date'].'.pdf');
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


    public function showByDate(Request $request)
{
    $date = $request->query('date') ?? now()->format('Y-m-d');

    $logs = TemperatureLog::where('date', $date)
        ->orderBy('location')
        ->orderByRaw("FIELD(time_slot, '08h', '12h', '16h', '20h', '00h', '04h')")
        ->get()
        ->groupBy('location');

    return view('temperature_logs.show', compact('logs', 'date'));
}


    protected function getSinForPdf()
    {
        $logoPath = public_path('images/african.png');

        // Check if logo exists, return base64 encoded version
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return null;
    }
    public function create()
    {
        return view('temperature_logs.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'data' => 'required|array',
        ]);

        $userId = Auth::id();
        $date = $validated['date'];

        // Check if the user already submitted data for this date
        $alreadyExists = TemperatureLog::where('user_id', $userId)
                            ->whereDate('date', $date)
                            ->exists();

        if ($alreadyExists) {
            return redirect()->route('temperature_log.create')
                ->with('error', "Les températures pour la date du <strong>{$date}</strong> ont déjà été enregistrées.");
        }

        $hasAtLeastOneValue = false;

        foreach ($validated['data'] as $entry) {
            $location = $entry['location'] ?? 'Unknown';

            foreach ($entry as $time => $values) {
                if ($time === 'location') continue;

                $vl = $values['vl'] ?? null;
                $vm = $values['vm'] ?? null;

                if (!is_null($vl) || !is_null($vm)) {
                    $hasAtLeastOneValue = true;

                    TemperatureLog::create([
                        'user_id'   => $userId,
                        'date'      => $date,
                        'location'  => $location,
                        'time_slot' => $time,
                        'vl'        => $vl,
                        'vm'        => $vm,
                    ]);
                }
            }
        }

        if (!$hasAtLeastOneValue) {
            return redirect()->route('temperature_log.create')
                ->with('warning', 'Aucune température saisie, mais formulaire enregistré.');
        }

        return redirect()->route('temperature_log.create')
            ->with('success', "Les températures du <strong>{$date}</strong> ont été enregistrées avec succès.");
    }


}
