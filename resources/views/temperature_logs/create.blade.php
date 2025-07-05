@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0"><i class="fas fa-temperature-low me-2"></i>Saisie de Température - Vérification</h2>
        </div>

        <div class="card-body px-4 py-4">

            {{-- Notification Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {!! session('warning') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('temperature_log.store') }}" id="temperatureForm">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="date" class="form-label fw-medium">Date :</label>
                        <input type="date" name="date" class="form-control date-picker" required
                               value="{{ old('date', now()->format('Y-m-d')) }}">
                    </div>
                </div>

                @php
                    $locations = [
                        'Zone Réception', 'Zone Manipulation 1', 'Zone Manipulation 2', 'Zone Expédition',
                        'Tunnel 1', 'Tunnel 2', 'Tunnel 3', 'Tunnel 4', 'Tunnel 6', 'Tunnel 7', 'Tunnel 8', 'Tunnel 9', 'Tunnel 10',
                        'Couloir des tunnels', 'Couloir des chambres',
                        'Chambre froide 1', 'Chambre froide 2', 'Chambre froide 3', 'Chambre froide 4', 'Chambre froide 5',
                        'Chambre froide 6', 'Chambre froide 7', 'Chambre froide 8',
                    ];

                    $timeSlots = ['08h', '12h', '16h', '20h', '00h', '04h'];
                @endphp

                <div class="row g-2 mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-medium">Zones :</label>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <div class="locations-grid">
                                    @foreach ($locations as $index => $location)
                                        <div class="location-item">
                                            <input class="location-checkbox" type="checkbox" value="{{ $index }}" id="loc{{ $index }}">
                                            <label class="location-label" for="loc{{ $index }}">
                                                <span class="checkbox-icon"></span>
                                                <span class="location-text">{{ $location }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endauth
                    </div>

             @auth
    @if(auth()->user()->role === 'admin')
        <div class="col-md-2">
            <label for="timeFrom" class="form-label fw-medium">De :</label>
            <select id="timeFrom" class="form-select">
                @foreach ($timeSlots as $index => $slot)
                    <option value="{{ $index }}">{{ $slot }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="timeTo" class="form-label fw-medium">À :</label>
            <select id="timeTo" class="form-select">
                @foreach ($timeSlots as $index => $slot)
                    <option value="{{ $index }}">{{ $slot }}</option>
                @endforeach
            </select>
        </div>
    @endif
@endauth


                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" onclick="autoFillSelectedZones()" class="btn btn-warning w-100 auto-fill-btn">
                                    <i class="fas fa-magic me-1"></i>Auto Remplir
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover mb-0" id="temperatureTable">
                        <thead class="table-light">
                            <tr>
                                <th class="bg-light text-nowrap">Zone</th>
                                @foreach ($timeSlots as $slot)
                                    <th colspan="2" class="text-center bg-light">{{ $slot }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th class="bg-light"></th>
                                @foreach ($timeSlots as $slot)
                                    <th class="text-center bg-light">VL</th>
                                    <th class="text-center bg-light">VM</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $index => $location)
                                <tr class="align-middle">
                                    <td class="fw-medium text-nowrap">{{ $location }}</td>
                                    @foreach ($timeSlots as $slot)
                                        <td class="p-1">
                                            <input type="number" step="0.01"
                                                   name="data[{{ $index }}][{{ $slot }}][vl]"
                                                   class="form-control temp-input vl-input"
                                                   placeholder="−"
                                                   data-row="{{ $index }}"
                                                   data-slot="{{ $loop->index }}"
                                                   data-type="vl">
                                        </td>
                                        <td class="p-1">
                                            <input type="number" step="0.01"
                                                   name="data[{{ $index }}][{{ $slot }}][vm]"
                                                   class="form-control temp-input vm-input"
                                                   placeholder="−"
                                                   data-row="{{ $index }}"
                                                   data-slot="{{ $loop->index }}"
                                                   data-type="vm">
                                        </td>
                                    @endforeach
                                    <input type="hidden" name="data[{{ $index }}][location]" value="{{ $location }}" />
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top gap-2">
                    <button type="button" onclick="generatePDF()" class="btn btn-success px-4 py-2 shadow-sm">
                        <i class="fas fa-file-pdf me-2"></i>Télécharger PDF
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #212529;
    }

    /* Card Styling */
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }

    .card-header {
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    }

    /* Custom Checkbox Styling */
    .locations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .location-item {
        position: relative;
    }

    .location-checkbox {
        position: absolute;
        opacity: 0;
    }

    .location-label {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        cursor: pointer;
        transition: all 0.2s;
    }

    .location-label:hover {
        background-color: #e9ecef;
        border-color: #ced4da;
    }

    .location-checkbox:checked + .location-label {
        background-color: #e7f1ff;
        border-color: #86b7fe;
    }

    .checkbox-icon {
        display: inline-block;
        width: 1.1em;
        height: 1.1em;
        margin-right: 0.5rem;
        border: 1px solid #adb5bd;
        border-radius: 0.25rem;
        background-color: white;
        position: relative;
        transition: all 0.2s;
    }

    .location-checkbox:checked + .location-label .checkbox-icon {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .location-checkbox:checked + .location-label .checkbox-icon::after {
        content: "";
        position: absolute;
        left: 0.35em;
        top: 0.1em;
        width: 0.35em;
        height: 0.7em;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .location-text {
        font-size: 0.9rem;
    }

    /* Form Elements */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        height: calc(2.25rem + 2px);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        vertical-align: middle;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background-color: #f8f9fa !important;
        position: sticky;
        top: 0;
    }

    .table th, .table td {
        border: 1px solid #dee2e6;
    }

    .table td {
        vertical-align: middle;
        padding: 0.5rem;
    }

    .temp-input {
        text-align: center;
        min-width: 60px;
        padding: 0.375rem 0.5rem;
        height: calc(1.5em + 0.75rem + 2px);
        background-color: white;
    }

    /* Buttons */
    .btn {
        font-weight: 500;
        border-radius: 0.375rem;
        padding: 0.5rem 1.25rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #ffca2c;
        border-color: #ffc720;
    }

    .btn-success {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-success:hover {
        background-color: #157347;
        border-color: #146c43;
    }

    .auto-fill-btn {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .locations-grid {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            border: none;
        }

        .table thead {
            display: none;
        }

        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid #dee2e6;
        }

        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: calc(50% - 1rem);
            padding-right: 1rem;
            text-align: left;
            font-weight: 600;
            color: #495057;
        }

        .temp-input {
            width: 100%;
        }
    }

    /* Hover effects */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    /* Input placeholder styling */
    .temp-input::placeholder {
        color: #adb5bd;
        opacity: 1;
        font-style: italic;
    }

    /* Header icon */
    .card-header i {
        font-size: 1.2rem;
    }

    /* Footer buttons container */
    .border-top {
        border-top: 1px solid #e9ecef !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.temp-input');

    // Default: 9 to 12
    function generateRandomTempDefault() {
        return Math.floor(Math.random() * 4) + 9;
    }

    // For Chambre froide 6 à 8: 2 to 7
    function generateRandomTempColdRooms() {
        return Math.floor(Math.random() * 6) + 2;
    }

    inputs.forEach(input => {
        input.removeAttribute('step');

        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 2) {
                this.value = this.value.slice(0, 2);
            }
        });
    });

    window.generatePDF = function() {
        const form = document.getElementById('temperatureForm');
        form.action = "{{ route('temperature_log.download-pdf') }}";
        form.submit();

        setTimeout(() => {
            form.action = "{{ route('temperature_log.store') }}";
        }, 100);
    };

    window.autoFillSelectedZones = function () {
        const from = parseInt(document.getElementById('timeFrom').value);
        const to = parseInt(document.getElementById('timeTo').value);
        const checkboxes = document.querySelectorAll('.location-checkbox:checked');

        checkboxes.forEach(checkbox => {
            const rowIndex = parseInt(checkbox.value);

            for (let i = from; i <= to; i++) {
                const temp = (rowIndex >= 20 && rowIndex <= 22)
                    ? generateRandomTempColdRooms()
                    : generateRandomTempDefault();

                const vl = document.querySelector(`input[data-row="${rowIndex}"][data-slot="${i}"][data-type="vl"]`);
                const vm = document.querySelector(`input[data-row="${rowIndex}"][data-slot="${i}"][data-type="vm"]`);

                if (vl) vl.value = temp;
                if (vm) vm.value = temp;
            }
        });
    };
});
</script>
@endsection
