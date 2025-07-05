@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Historique – Suivi des Pièges Raticide</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('rat-traps.index') }}" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="date" class="form-label">Filtrer par Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="{{ route('rat-traps.index') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </div>
    </form>

    @forelse($grouped as $date => $records)
        <h5 class="mt-4">Date: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h5>

        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>N° de Piège</th>
                    <th>Appâts touché</th>
                    <th>Présence de cadavre</th>
                    <th>Mesure prise</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->trap_number }}</td>
                        <td>{{ $record->bait_touched }}</td>
                        <td>{{ $record->corpse_present }}</td>
                        <td>{{ $record->action_taken }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p class="text-muted">Aucune donnée trouvée pour cette date.</p>
    @endforelse
</div>
@endsection
