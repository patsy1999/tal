@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détail du contrôle de chlore</h2>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th rowspan="2">Date</th>
                <th rowspan="2">Heure</th>
                <th rowspan="2">Point de prélèvement D’eau1</th>
                <th rowspan="2">Chlore libre (Ppm)</th>
                <th rowspan="2">Conforme Oui / Non</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $record->date }}</td>
                <td>{{ $record->heure }}</td>
                <td>{{ $record->sampling_point }}</td>
                <td>{{ $record->chlorine_ppm }}</td>
                <td>{{ $record->conforme ? 'Oui' : 'Non' }}</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('chlorine-controls.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
