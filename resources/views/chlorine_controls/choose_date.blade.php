@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-dark py-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                <h4 class="mb-0">Opération existante détectée</h4>
            </div>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                Une opération pour aujourd'hui existe déjà. Veuillez choisir une autre date pour générer des données aléatoires.
            </div>

            <form method="POST" action="{{ route('chlorine-controls.generate-random') }}" class="needs-validation" novalidate>
                @csrf

                <div class="mb-4">
                    <div class="form-floating">
                        <input type="date" name="date" id="dateInput"
                               class="form-control"
                               max="{{ date('Y-m-d') }}"
                               required
                               onchange="validateFutureDate(this)">
                        <label for="dateInput">Nouvelle date</label>
                        <div class="invalid-feedback">
                            Veuillez sélectionner une date valide (non future)
                        </div>
                    </div>
                    <div class="form-text mt-1">
                        La date ne peut pas être dans le futur
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-md-2">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-magic me-2"></i>Générer automatiquement
                    </button>
                </div>
            </form>
        </div>

        <div class="card-footer bg-light">
            <small class="text-muted">
                <i class="bi bi-shield-lock me-1"></i> Données générées selon les normes de qualité
            </small>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Validate date is not in future
function validateFutureDate(input) {
    const selectedDate = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate > today) {
        input.setCustomValidity('La date ne peut pas être dans le futur');
    } else {
        input.setCustomValidity('');
    }
}

// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endsection
@endsection
