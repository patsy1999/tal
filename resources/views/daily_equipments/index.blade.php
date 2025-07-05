@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-4 p-md-5">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                </div>
            @endif

            {{-- Header Section --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h2 class="text-primary mb-1 fw-bold">
                        <i class="bi bi-search me-2"></i>
                    </h2>
                    <p class="text-muted mb-0">Consultez et générez des rapports d'équipements</p>
                </div>

                <a href="{{ route('daily_equipments.create') }}" class="btn btn-primary rounded-3 d-flex align-items-center gap-2 px-4 py-2">
                    <i class="bi bi-plus-circle fs-5"></i> Créer un enregistrement
                </a>
            </div>

            {{-- Forms Section --}}
            <div class="forms-container">
                {{-- Generate Month Form - Only for Admin --}}
@auth
    @if(auth()->user()->role === 'admin')
        <div class="form-card bg-light-blue">
            <h5 class="form-title">
                <i class="bi bi-magic me-2"></i>Génération automatique
            </h5>
            <form method="POST" action="{{ route('daily_equipments.generate_month') }}" class="mt-3">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="generate_month" class="form-label fw-medium">Sélectionnez un mois :</label>
                        <input type="month" id="generate_month" name="month" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-teal w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2">
                            <i class="bi bi-stars"></i> Générer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endauth


                {{-- Date Search Form --}}
                <div class="form-card bg-light-green">
                    <h5 class="form-title">
                        <i class="bi bi-calendar-day me-2"></i>
                    </h5>
                    <form method="GET" action="{{ route('daily_equipments.index') }}" class="mt-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="date" class="form-label fw-medium">Sélectionnez une date :</label>
                                <input type="date" id="date" name="date" class="form-control rounded-3" value="{{ request('date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- PDF Download Form --}}
                <div class="form-card bg-light-purple">
                    <h5 class="form-title">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                    </h5>
                    <form method="GET" action="{{ route('daily_equipments.pdf') }}" class="mt-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="pdf_date" class="form-label fw-medium">Sélectionnez une date :</label>
                                <input type="date" id="pdf_date" name="date" class="form-control rounded-3" value="{{ request('date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-purple w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2">
                                    <i class="bi bi-download"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Month Search Form --}}
                <div class="form-card bg-light-orange">
                    <h5 class="form-title">
                        <i class="bi bi-calendar-month me-2"></i>Recherche par mois
                    </h5>
                    <form method="GET" action="{{ route('daily_equipments.month') }}" class="mt-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label for="month" class="form-label fw-medium">Sélectionnez un mois :</label>
                                <input type="month" id="month" name="month" class="form-control rounded-3" value="{{ request('month') }}" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-orange w-100 rounded-3 d-flex align-items-center justify-content-center gap-2 py-2">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- No records found alert --}}
            @if($date && $records->isEmpty())
                <div class="alert alert-warning rounded-3 mt-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Aucun enregistrement trouvé</strong> pour la date <strong>{{ $date }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Results Table --}}
            @if($records->isNotEmpty())
                <div class="results-section mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">
                            <i class="bi bi-table me-2 text-primary"></i>
                            <span class="text-dark">Résultats pour : <span class="text-primary">{{ $date }}</span></span>
                        </h4>
                        <div class="text-muted">{{ $records->count() }} enregistrements trouvés</div>
                    </div>

                    <div class="table-responsive rounded-4 shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th scope="col" class="text-start ps-4">Équipement</th>
                                    <th scope="col" style="width: 120px;">État</th>
                                    <th scope="col" style="width: 180px;">Observation</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($records as $record)
                                    <tr>
                                        <td class="text-start ps-4">{{ $record->equipment_name }}</td>
                                        <td>
                                            @if($record->is_good)
                                                <span class="badge bg-success-bright text-success px-3 py-2 fs-6">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Bon état
                                                </span>
                                            @else
                                                <span class="badge bg-danger-bright text-danger px-3 py-2 fs-6">
                                                    <i class="bi bi-exclamation-circle-fill me-1"></i> Problème
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-wrap" style="max-width: 400px;">
                                            @if($record->observation)
                                                {{ $record->observation }}
                                            @else
                                                <span class="text-muted">Aucune observation</span>
                                            @endif
                                        </td>
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
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --success-color: #2ecc71;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --info-color: #3498db;
        --light-blue: #f0f8ff;
        --light-green: #f0fff4;
        --light-purple: #f8f0ff;
        --light-orange: #fff8f0;
        --teal: #1abc9c;
        --purple: #9b59b6;
        --orange: #e67e22;
    }

    body {
        background-color: #f5f7fa;
    }

    .card {
        border: none;
        overflow: hidden;
    }

    .forms-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .form-card {
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .bg-light-blue {
        background-color: var(--light-blue);
        border-left: 4px solid var(--info-color);
    }

    .bg-light-green {
        background-color: var(--light-green);
        border-left: 4px solid var(--success-color);
    }

    .bg-light-purple {
        background-color: var(--light-purple);
        border-left: 4px solid var(--purple);
    }

    .bg-light-orange {
        background-color: var(--light-orange);
        border-left: 4px solid var(--orange);
    }

    .btn-teal {
        background-color: var(--teal);
        border-color: var(--teal);
        color: white;
    }

    .btn-teal:hover {
        background-color: #16a085;
        border-color: #16a085;
    }

    .btn-purple {
        background-color: var(--purple);
        border-color: var(--purple);
        color: white;
    }

    .btn-purple:hover {
        background-color: #8e44ad;
        border-color: #8e44ad;
    }

    .btn-orange {
        background-color: var(--orange);
        border-color: var(--orange);
        color: white;
    }

    .btn-orange:hover {
        background-color: #d35400;
        border-color: #d35400;
    }

    .bg-success-bright {
        background-color: rgba(46, 204, 113, 0.1);
    }

    .bg-danger-bright {
        background-color: rgba(231, 76, 60, 0.1);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        border-bottom: none;
        padding: 12px 16px;
        font-weight: 600;
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
    }

    .table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
    }

    .results-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .forms-container {
            grid-template-columns: 1fr;
        }

        .d-flex.flex-md-row {
            flex-direction: column !important;
        }
    }
</style>
@endsection
