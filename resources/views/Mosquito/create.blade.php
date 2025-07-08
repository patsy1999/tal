@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-primary">Nouvelle Saisie – Conformité Appareils à Moustiquaires</h4>
        <a href="{{ route('mosquito.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour au Tableau
        </a>
    </div>

    {{-- Show errors if any --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('mosquito.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="row mb-4">
            <div class="col-md-4">
                <label for="date" class="form-label fw-bold">Date du jour <span class="text-danger">*</span></label>
                <input type="date" name="date" class="form-control border-primary" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="text-primary mb-3">Conformité des Appareils</h5>
            <div class="row row-cols-2 row-cols-md-5 g-3">
                @for ($i = 1; $i <= 15; $i++)
                    <div class="col">
                        <label class="form-label">D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</label>
                        <input name="D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                               class="form-control text-center border-success"
                               value="{{ old('D' . str_pad($i, 2, '0', STR_PAD_LEFT), 'C') }}"
                               placeholder="C ou NC">
                    </div>
                @endfor
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Moustiquaire</label>
                <input name="moustiquaire" class="form-control border-primary" value="{{ old('moustiquaire', 'C') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">État/Nettoyage</label>
                <input name="etat_nettoyage" class="form-control border-primary" value="{{ old('etat_nettoyage', 'C') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Action Corrective</label>
                <input name="action_corrective" class="form-control border-secondary" value="{{ old('action_corrective', 'R.A.S') }}">
            </div>
        </div>

        <div class="text-end mt-4 pt-3 border-top">
            <button class="btn btn-primary px-4">
                <i class="fas fa-save"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<style>
    .form-control {
        padding: 0.5rem 0.75rem;
    }
    .border-primary {
        border-color: #0d6efd !important;
    }
    .border-success {
        border-color: #198754 !important;
    }
    .border-secondary {
        border-color: #6c757d !important;
    }
    .form-label {
        font-weight: 500;
    }
</style>
@endsection
