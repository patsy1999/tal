@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 overflow-hidden">
        <!-- Card Header with Gradient Background -->
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <i class="fas fa-temperature-low fs-3 me-3"></i>
                    <div>
                        <h2 class="h4 mb-0 fw-bold">Journal des Températures</h2>
                        <p class="mb-0 opacity-75">Données enregistrées pour le {{ $date }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Date Picker Form -->
                    <form method="GET" action="{{ route('temperature_log.show') }}" class="date-picker-form">
                        <div class="input-group">
                            <input type="date" name="date" value="{{ $date }}" class="form-control date-input" required>
                            <button type="submit" class="btn btn-light btn-date-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('temperature_log.create') }}" class="btn btn-light btn-sm d-flex align-items-center">
                        <i class="fas fa-plus me-1"></i> Nouvelle entrée
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            @if ($logs->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-thermometer-empty"></i>
                    </div>
                    <h3 class="empty-state-title">Aucune donnée disponible</h3>
                    <p class="empty-state-text mb-0">
                        Aucune température n'a été enregistrée pour le {{ $date }}
                    </p>
                </div>
            @else
                <!-- PDF Download Button -->
                <form method="POST" action="{{ route('temperature_log.download-pdf') }}" class="mb-4">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    @php
                        $timeSlots = ['08h', '12h', '16h', '20h', '00h', '04h'];
                    @endphp

                    @foreach ($logs as $location => $entries)
                        @php
                            $dataBySlot = $entries->keyBy('time_slot');
                        @endphp
                        <input type="hidden" name="data[{{ $loop->index }}][location]" value="{{ $location }}">
                        @foreach ($timeSlots as $slot)
                            @php
                                $entry = $dataBySlot[$slot] ?? null;
                            @endphp
                            <input type="hidden" name="data[{{ $loop->parent->index }}][{{ $slot }}][vl]" value="{{ $entry->vl ?? '' }}">
                            <input type="hidden" name="data[{{ $loop->parent->index }}][{{ $slot }}][vm]" value="{{ $entry->vm ?? '' }}">
                        @endforeach
                    @endforeach

                    <div class="text-end">
                        <button type="submit" class="btn btn-pdf-download">
                            <i class="fas fa-file-pdf me-2"></i>Exporter en PDF
                        </button>
                    </div>
                </form>

                <!-- Temperature Data Table -->
                <div class="table-container">
                    <table class="temperature-table">
                        <thead>
                            <tr class="table-header-row">
                                <th class="location-col">Zone</th>
                                @foreach ($timeSlots as $slot)
                                    <th class="time-slot-col" colspan="2">
                                        <span class="time-slot">{{ $slot }}</span>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="subheader-row">
                                <th></th>
                                @foreach ($timeSlots as $slot)
                                    <th class="value-type">VL</th>
                                    <th class="value-type">VM</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $location => $entries)
                                @php
                                    $dataBySlot = $entries->keyBy('time_slot');
                                @endphp
                                <tr class="data-row">
                                    <td class="location-name">{{ $location }}</td>
                                    @foreach ($timeSlots as $slot)
                                        @php
                                            $entry = $dataBySlot[$slot] ?? null;
                                            $vl = $entry->vl ?? '−';
                                            $vm = $entry->vm ?? '−';
                                        @endphp
                                        <td class="temperature-value @if($vl !== '−') has-value @endif">
                                            {{ $vl }}
                                        </td>
                                        <td class="temperature-value @if($vm !== '−') has-value @endif">
                                            {{ $vm }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if (!empty($latestLogs) && count($latestLogs))
    <div class="mt-5 pt-4 border-top">
        <h4 class="mb-3">
            <i class="fas fa-clock me-2 text-secondary"></i>
            Derniers enregistrements disponibles ({{ $latestDate }})
        </h4>

        <div class="table-container">
            <table class="temperature-table">
                <thead>
                    <tr class="table-header-row">
                        <th class="location-col">Zone</th>
                        @foreach ($timeSlots as $slot)
                            <th class="time-slot-col" colspan="2">
                                <span class="time-slot">{{ $slot }}</span>
                            </th>
                        @endforeach
                    </tr>
                    <tr class="subheader-row">
                        <th></th>
                        @foreach ($timeSlots as $slot)
                            <th class="value-type">VL</th>
                            <th class="value-type">VM</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestLogs as $location => $entries)
                        @php
                            $dataBySlot = $entries->keyBy('time_slot');
                        @endphp
                        <tr class="data-row">
                            <td class="location-name">{{ $location }}</td>
                            @foreach ($timeSlots as $slot)
                                @php
                                    $entry = $dataBySlot[$slot] ?? null;
                                    $vl = $entry->vl ?? '−';
                                    $vm = $entry->vm ?? '−';
                                @endphp
                                <td class="temperature-value @if($vl !== '−') has-value @endif">
                                    {{ $vl }}
                                </td>
                                <td class="temperature-value @if($vm !== '−') has-value @endif">
                                    {{ $vm }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

        </div>

    </div>
</div>

<style>
    /* Color Variables */
    :root {
        --primary-color: #4361ee;
        --primary-light: #eef2ff;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --danger-color: #f72585;
        --warning-color: #f8961e;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --border-color: #e9ecef;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    /* Date Picker Form */
    .date-picker-form {
        max-width: 220px;
    }

    .date-input {
        border-radius: 6px 0 0 6px !important;
        border-right: none;
        height: 38px;
    }

    .btn-date-search {
        border-radius: 0 6px 6px 0;
        height: 36px;
        width: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-date-search:hover {
        background-color: var(--primary-light);
        color: var(--primary-color);
    }

    /* Empty State Styling */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #6c757d;
        max-width: 400px;
        margin: 0 auto;
    }

    /* PDF Download Button */
    .btn-pdf-download {
        background-color: var(--danger-color);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-pdf-download:hover {
        background-color: #d91a6d;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .btn-pdf-download:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Temperature Table Styling */
    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .temperature-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .temperature-table th,
    .temperature-table td {
        padding: 12px 8px;
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .table-header-row {
        background-color: var(--primary-light);
        color: var(--primary-color);
    }

    .table-header-row th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .subheader-row {
        background-color: #f8f9fa;
    }

    .subheader-row th {
        font-weight: 500;
        font-size: 0.75rem;
        color: #495057;
    }

    .time-slot-col {
        min-width: 80px;
    }

    .time-slot {
        display: inline-block;
        padding: 4px 8px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 12px;
        font-size: 0.75rem;
    }

    .location-col {
        min-width: 120px;
        text-align: left !important;
        padding-left: 16px !important;
        font-weight: 500;
    }

    .location-name {
        font-weight: 500;
        color: var(--dark-color);
    }

    .data-row:hover {
        background-color: rgba(67, 97, 238, 0.03);
    }

    .temperature-value {
        color: #6c757d;
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }

    .temperature-value.has-value {
        color: var(--dark-color);
        font-weight: 600;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-header {
            padding: 1rem;
        }

        .date-picker-form {
            max-width: 100%;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-date-search {
            width: 100%;
            border-radius: 6px;
            margin-top: 0.5rem;
        }
    }
</style>
@endsection
