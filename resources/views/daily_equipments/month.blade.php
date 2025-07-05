@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📅 Enregistrements pour le mois : {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h2>

    @if($records->isEmpty())
        <div class="alert alert-warning rounded-3">
            Aucun enregistrement trouvé pour ce mois.
        </div>
    @else
        <div class="table-responsive rounded-3 shadow-sm border">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>Date</th>
                        <th class="text-start">Équipement</th>
                        <th style="width: 120px;">État</th>
                        <th style="width: 180px;">Observation</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($records as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                            <td class="text-start">{{ $record->equipment_name }}</td>
                            <td>
                                @if($record->is_good)
                                    <span class="badge bg-success px-3 py-2 fs-6">✅ Oui</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 fs-6">❌ Non</span>
                                @endif
                            </td>
                            <td class="text-wrap" style="max-width: 400px;">{{ $record->observation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
