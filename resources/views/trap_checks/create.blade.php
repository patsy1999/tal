@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('trap-checks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
        <h3 class="mb-0 text-primary">Saisie Journalière – Pièges</h3>
        <div style="width: 120px;"></div> {{-- Spacer for alignment --}}
    </div>

    @if ($errors->has('check_date'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ $errors->first('check_date') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('trap-checks.store') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="date" name="check_date" id="check_date" class="form-control" required>
                            <label for="check_date" class="fw-medium">Date de contrôle</label>
                        </div>
                    </div>
                </div>

                {{-- Raticide Section --}}
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-pest-control me-2"></i>Pièges Raticide
                        </h4>
                        <span class="badge bg-primary rounded-pill">46 pièges</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th width="15%" class="text-center">N° de Piège</th>
                                    <th width="25%">Appâts touché</th>
                                    <th width="25%">Présence de cadavre</th>
                                    <th width="35%">Mesure prise</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 46; $i++)
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $i }}</td>
                                        <td>
                                            <select name="raticide[{{ $i }}][bait_touched]" class="form-select form-select-sm" required>
                                                <option value="Non" selected>Non</option>
                                                <option value="Oui">Oui</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="raticide[{{ $i }}][corpse_present]" class="form-select form-select-sm" required>
                                                <option value="Non" selected>Non</option>
                                                <option value="Oui">Oui</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="raticide[{{ $i }}][action_taken]" class="form-control form-control-sm" value="RAS" required>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mechanical Section --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-mouse me-2"></i>Pièges Mécaniques
                        </h4>
                        <span class="badge bg-primary rounded-pill">14 pièges</span>
                    </div>

                    @php
                        $traps = collect(range(1, 14))->map(fn($i) => 'TR' . str_pad($i, 2, '0', STR_PAD_LEFT));
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th width="20%">Piège mécanique</th>
                                    @foreach($traps as $trap)
                                        <th class="text-center">{{ $trap }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="fw-semibold">Nombre de capture</th>
                                    @foreach($traps as $trap)
                                        <td>
                                            <input type="number" name="mecanique[captures][{{ $trap }}]"
                                                   class="form-control form-control-sm text-center"
                                                   value="0" min="0" required>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="fw-semibold">Mesure prise</th>
                                    @foreach($traps as $trap)
                                        <td>
                                            <input type="text" name="mecanique[actions][{{ $trap }}]"
                                                   class="form-control form-control-sm"
                                                   value="RAS" required>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('trap-checks.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .table {
        font-size: 0.875rem;
    }

    .table th {
        white-space: nowrap;
        vertical-align: middle;
        font-weight: 600;
    }

    .table-primary {
        --bs-table-bg: #f8f9fa;
        --bs-table-striped-bg: #f8f9fa;
    }

    .form-floating label {
        font-weight: 500;
    }

    h4 {
        font-weight: 600;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
</style>
@endsection
