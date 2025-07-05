@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Historique – Pièges Mécaniques</h3>

    <form method="GET" class="mb-4" action="{{ route('mechanical-traps.index') }}">
        <label for="date">Filtrer par date :</label>
        <input type="date" name="date" value="{{ request('date') }}" class="form-control w-auto d-inline-block mx-2">
        <button class="btn btn-primary btn-sm">Filtrer</button>
        <a href="{{ route('mechanical-traps.index') }}" class="btn btn-secondary btn-sm">Réinitialiser</a>
    </form>

    @forelse($grouped as $date => $records)
        <h5>Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h5>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Piège mécanique</th>
                    @foreach($records->pluck('trap_code') as $trapCode)
                        <th>{{ $trapCode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Nombre de capture</th>
                    @foreach($records as $record)
                        <td>{{ $record->captures }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Mesure prise</th>
                    @foreach($records as $record)
                        <td>{{ $record->action_taken }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @empty
        <p class="text-muted">Aucune donnée enregistrée.</p>
    @endforelse
</div>
@endsection
