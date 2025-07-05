@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-vial"></i> Contrôles de chlore</h2>
    <div class="btn-group" role="group" aria-label="Actions" style="gap: 0.75rem; display: flex; flex-wrap: nowrap;">
    <a href="{{ route('chlorine-controls.create') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
        <i class="fas fa-plus-circle"></i> Nouveau contrôle
    </a>
   @auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('chlorine-controls.random-add') }}" class="btn btn-outline-success d-flex align-items-center gap-2">
            <i class="fas fa-random"></i> Générer automatiquement
        </a>
    @endif
@endauth

    <a href="{{ route('chlorine-controls.pdf-form') }}" class="btn btn-info text-white d-flex align-items-center gap-2">
        <i class="fas fa-file-pdf"></i> Exporter PDF par mois
    </a>
    @auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('chlorine-controls.random-month-form') }}" class="btn btn-warning text-white d-flex align-items-center gap-2">
            <i class="fas fa-calendar-alt"></i> Générer données aléatoires pour un mois
        </a>
    @endif
@endauth

</div>

<style>
    .btn-group .btn {
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        font-size: 0.95rem;
        white-space: nowrap;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-group .btn i {
        font-size: 1.2rem;
    }

    /* Friendly color hovers */
    .btn-outline-primary:hover {
        background-color: #5a7bd8;
        color: #fff;
        border-color: #5a7bd8;
        box-shadow: 0 4px 10px rgba(90,123,216,0.6);
    }
    .btn-outline-success:hover {
        background-color: #3cc04a;
        color: #fff;
        border-color: #3cc04a;
        box-shadow: 0 4px 10px rgba(60,192,74,0.6);
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        box-shadow: 0 4px 10px rgba(19,132,150,0.6);
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        box-shadow: 0 4px 10px rgba(224,168,0,0.6);
    }

    /* Remove button margin (if any) */
    .btn-group .btn:not(:last-child) {
        margin-right: 0;
    }

    /* Prevent wrapping and keep buttons nicely spaced */
    .btn-group {
        gap: 0.75rem;
        display: flex;
        flex-wrap: nowrap;
    }
</style>


    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th rowspan="2" class="align-middle">📅 Date</th>
                            <th>🕒 Heure</th>
                            <th>📍 Point de prélèvement</th>
                            <th>💧 Chlore libre (Ppm)</th>
                            <th>✅ Conforme</th>
                            <th>🛠️ Mesures correctives</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grouped = $records->groupBy('date');
                        @endphp

                        @forelse ($grouped as $date => $entries)
                            @foreach ($entries as $i => $entry)
                                <tr class="{{ $entry->conforme ? '' : 'table-warning' }}">
                                    @if ($i === 0)
                                        <td rowspan="{{ $entries->count() }}" class="align-middle text-center fw-bold">{{ $date }}</td>
                                    @endif
                                    <td class="text-center">{{ $entry->heure }}</td>
                                    <td class="text-center">{{ $entry->sampling_point }}</td>
                                    <td class="text-center font-weight-bold">
                                        @if ($entry->heure === '09:00')
                                            {{ $entry->chlorine_ppm_min }}
                                        @elseif ($entry->heure === '14:00')
                                            {{ $entry->chlorine_ppm_max }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $entry->conforme ? 'success' : 'danger' }}">
                                            {{ $entry->conforme ? 'Oui' : 'Non' }}
                                        </span>
                                    </td>
                                    <td class="text-left">
                                        {{ $entry->mesures_correctives ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucun contrôle enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Optional CSS --}}
<style>
    .table {
        font-size: 0.95rem;
    }
    .thead-light th {
        background-color: #f1f1f1;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
    .btn-outline-primary, .btn-outline-success {
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>
@endsection
