<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceIntervention;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class MaintenanceInterventionController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        $query = MaintenanceIntervention::query();

        // Date range filter
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        // Additional filters
        if ($request->filled('zone')) {
            $query->where('zone', $request->zone);
        }

        if ($request->filled('technician')) {
            $query->where('intervenant', $request->technician);
        }

        $records = $query->orderBy('date', 'desc')->paginate(10);

        // Get unique values for filter dropdowns
        $zones = MaintenanceIntervention::distinct()->pluck('zone')->sort();
        $technicians = MaintenanceIntervention::distinct()->pluck('intervenant')->sort();

        return view('maintenance.index', compact('records', 'zones', 'technicians'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        return view('maintenance.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        $validated = $this->validateRequest($request);
        MaintenanceIntervention::create($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Fiche enregistrée avec succès.');
    }

    public function edit($id)
    {
        $record = MaintenanceIntervention::findOrFail($id);
        return view('maintenance.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateRequest($request);
        $record = MaintenanceIntervention::findOrFail($id);
        $record->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Fiche mise à jour avec succès.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }
        $record = MaintenanceIntervention::findOrFail($id);
        $record->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Fiche supprimée avec succès.');
    }

    public function downloadPDF(Request $request)
    {
        $query = MaintenanceIntervention::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $records = $query->orderBy('date', 'desc')->get();
        $logo = $this->getLogoForPdf();

        $pdf = Pdf::loadView('maintenance.pdf', compact('records', 'logo'));
        $filename = 'interventions_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadSinglePDF($id)
    {
        $record = MaintenanceIntervention::findOrFail($id);
        $pdf = Pdf::loadView('maintenance.single_pdf', compact('record'));
        $filename = 'intervention_' . $record->date . '_' . $record->id . '.pdf';

        return $pdf->download($filename);
    }

    public function export()
    {
        $format = request('format', 'csv');
        $query = MaintenanceIntervention::query();

        // Apply filters
        if (request('from')) {
            $query->where('date', '>=', request('from'));
        }
        if (request('to')) {
            $query->where('date', '<=', request('to'));
        }
        if (request('zone')) {
            $query->where('zone', request('zone'));
        }
        if (request('technician')) {
            $query->where('intervenant', request('technician'));
        }

        $records = $query->get();

        switch ($format) {
            case 'csv':
                return $this->exportToCSV($records);
            case 'excel':
                return $this->exportToExcel($records);
            default:
                return back()->with('error', 'Invalid export format');
        }
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

    protected function exportToCSV($records)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="maintenance_export_'.date('Y-m-d').'.csv"',
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, [
                'Date', 'Zone', 'Company', 'Technician',
                'Work Details', 'Status', 'Created At'
            ]);

            foreach ($records as $record) {
                fputcsv($file, [
                    $record->date,
                    $record->zone,
                    $record->company,
                    $record->intervenant,
                    $record->work_details,
                    $record->status,
                    $record->created_at
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    protected function exportToExcel($records)
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="maintenance_export_'.date('Y-m-d').'.xls"',
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fwrite($file, "<table><tr>");
            fwrite($file, "<th>Date</th><th>Zone</th><th>Company</th>");
            fwrite($file, "<th>Technician</th><th>Work Details</th><th>Status</th><th>Created At</th></tr>");

            foreach ($records as $record) {
                fwrite($file, "<tr>");
                fwrite($file, "<td>{$record->date}</td><td>{$record->zone}</td><td>{$record->company}</td>");
                fwrite($file, "<td>{$record->intervenant}</td><td>{$record->work_details}</td>");
                fwrite($file, "<td>{$record->status}</td><td>{$record->created_at}</td>");
                fwrite($file, "</tr>");
            }
            fwrite($file, "</table>");
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'zone' => 'required',
            'company' => 'required',
            'intervenant' => 'required',
            'work_details' => 'nullable',
            'materials_used' => 'nullable',
            'site_clean' => 'nullable',
            'production_ongoing' => 'nullable',
            'cleaning_end_time' => 'nullable',
            'risk_level' => 'nullable',
            'product_safety_risk' => 'nullable',
            'risk_description' => 'nullable',
            'location_signed' => 'nullable',
            'date_signed' => 'nullable|date',
        ]);
    }
}
