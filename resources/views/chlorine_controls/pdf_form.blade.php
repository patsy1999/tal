@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF - Contrôles de Chlore
                </h2>
                <div class="badge bg-white text-primary">F-01/POM-02</div>
            </div>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('chlorine-controls.export-pdf') }}" class="needs-validation" novalidate>
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="month" id="month" class="form-select" required>
                                <option value="" selected disabled>Sélectionner un mois</option>
                                @for ($m=1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                            <label for="month">Mois</label>
                            <div class="invalid-feedback">
                                Veuillez sélectionner un mois
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="year" id="year" class="form-select" required>
                                <option value="" selected disabled>Sélectionner une année</option>
                                @php
                                    $startYear = 2020;
                                    $currentYear = date('Y');
                                @endphp
                                @for ($y = $currentYear; $y >= $startYear; $y--)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            <label for="year">Année</label>
                            <div class="invalid-feedback">
                                Veuillez sélectionner une année
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-download me-2"></i>Générer le PDF
                            </button>
                        </div>
                        <a href="{{ route('chlorine-controls.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer bg-light">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i> Le rapport inclura tous les contrôles du mois sélectionné
            </small>
        </div>
    </div>
</div>

<!-- Add Bootstrap validation script -->
@section('scripts')
<script>
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
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
