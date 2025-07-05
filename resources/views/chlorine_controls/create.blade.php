@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Enregistrement du Contrôle de Chlore</h2>
                <div class="badge bg-white text-primary">F-01/POM-02</div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('chlorine-controls.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row g-3">
                    <!-- Date Field -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="date" class="form-control" id="dateInput" required>
                            <label for="dateInput" class="form-label">Date de contrôle</label>
                            <div class="invalid-feedback">
                                Veuillez sélectionner une date valide
                            </div>
                        </div>
                    </div>

                    <!-- Conformity Field -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="conforme" class="form-select" id="conformitySelect" required>
                                <option value="" selected disabled>Sélectionner...</option>
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                            <label for="conformitySelect">Statut de conformité</label>
                            <div class="invalid-feedback">
                                Veuillez sélectionner un statut
                            </div>
                        </div>
                    </div>

                    <!-- Chlorine Levels -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.01" name="chlorine_ppm_min" class="form-control"
                                   id="chlorineMin" required min="0.27" max="0.41"
                                   oninput="validateChlorineLevel(this)">
                            <label for="chlorineMin">Niveau de chlore libre (Ppm) - Minimum</label>
                            <div class="form-text">Matin (09:00) - Valeur entre 0.27 et 0.41 ppm</div>
                            <div class="invalid-feedback">
                                La valeur doit être entre 0.27 et 0.41 ppm
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number"  name="chlorine_ppm_max" class="form-control"
                                   id="chlorineMax" required min="0.27" max="0.41" step="0.01""
                                   oninput="validateChlorineLevel(this)">
                            <label for="chlorineMax">Niveau de chlore libre (Ppm) - Maximum</label>
                            <div class="form-text">Soir (16:00) - Valeur entre 0.27 et 0.41 ppm</div>
                            <div class="invalid-feedback">
                                La valeur doit être entre 0.27 et 0.41 ppm
                            </div>
                        </div>
                    </div>

                    <!-- Corrective Measures -->
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="mesures_correctives" class="form-control" id="correctiveMeasures"
                                      style="height: 100px" placeholder="Décrire les mesures correctives si nécessaire"
                                      required></textarea>
                            <label for="correctiveMeasures">Mesures correctives</label>
                            <div class="form-text">À compléter uniquement en cas de non-conformité</div>
                            <div class="invalid-feedback">
                                Veuillez décrire les mesures correctives
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('chlorine-controls.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>Enregistrer les mesures
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Bootstrap validation script -->
@section('scripts')
<script>
(function () {
  'use strict'

  // Form validation
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

  // Custom chlorine level validation
  function validateChlorineLevel(input) {
    const value = parseFloat(input.value);
    const min = parseFloat(input.min);
    const max = parseFloat(input.max);

    if (isNaN(value) || value < min || value > max) {
      input.setCustomValidity(`La valeur doit être entre ${min} et ${max} ppm`);
    } else {
      input.setCustomValidity('');
    }
  }

  // Initialize validation for existing values
  document.querySelectorAll('[min][max]').forEach(input => {
    input.addEventListener('change', function() {
      validateChlorineLevel(this);
    });
  });
})()
</script>
@endsection
@endsection
