@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary">
            <i class="fas fa-edit me-2"></i>Modifier Piège Raticide #{{ $record->trap_number }}
        </h4>
        <a href="{{ route('trap-checks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times me-1"></i> Annuler
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('trap-checks.raticide.update', $record->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Appât touché</label>
                    <select name="bait_touched" class="form-select form-select-lg border-primary" required>
                        <option value="Oui" {{ $record->bait_touched == 'Oui' ? 'selected' : '' }}>Oui</option>
                        <option value="Non" {{ $record->bait_touched == 'Non' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Cadavre présent</label>
                    <select name="corpse_present" class="form-select form-select-lg border-primary" required>
                        <option value="Oui" {{ $record->corpse_present == 'Oui' ? 'selected' : '' }}>Oui</option>
                        <option value="Non" {{ $record->corpse_present == 'Non' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Action prise</label>
                    <input type="text" name="action_taken" class="form-control form-control-lg border-primary"
                           value="{{ $record->action_taken }}" placeholder="Décrire l'action prise...">
                </div>

                <div class="d-flex justify-content-end border-top pt-4">
                    <button type="submit" class="btn btn-primary px-4 me-3">
                        <i class="fas fa-save me-2"></i> Mettre à jour
                    </button>
                    <a href="{{ route('trap-checks.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-select-lg, .form-control-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    .border-primary {
        border: 2px solid #0d6efd !important;
    }
    .card {
        border-radius: 0.5rem;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
