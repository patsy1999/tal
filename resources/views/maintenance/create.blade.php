@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h2 class="mb-0"><i class="fas fa-tools me-2"></i>Fiche d'intervention de maintenance</h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('maintenance.store') }}" class="needs-validation" novalidate>
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control border-primary" required>
                        <div class="invalid-feedback">Veuillez saisir la date</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Heure Début</label>
                        <input type="time" name="start_time" class="form-control border-primary">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Heure Fin</label>
                        <input type="time" name="end_time" class="form-control border-primary">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Zone <span class="text-danger">*</span></label>
                        <input type="text" name="zone" class="form-control border-primary" required>
                        <div class="invalid-feedback">Veuillez spécifier la zone</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Société <span class="text-danger">*</span></label>
                        <input type="text" name="company" class="form-control border-primary" required>
                        <div class="invalid-feedback">Veuillez indiquer la société</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Intervenant(s) <span class="text-danger">*</span></label>
                        <input type="text" name="intervenant" class="form-control border-primary" required>
                        <div class="invalid-feedback">Veuillez préciser l'intervenant</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Détail des travaux réalisés</label>
                    <textarea name="work_details" class="form-control border-primary" rows="3"></textarea>
                </div>

                <div class="mb-4">
    <label class="form-label fw-bold">Engagement : </label>
    <div class="border border-primary rounded p-3 bg-light">
        Après chaque intervention au niveau des équipements, tout le matériel utilisé doit être ramassé, le matériel réparé et la zone ou l'intervention a eu lieu doit être bien examiné et bien nettoyé pour assurer qu'aucunes parties n'ont été dégagées et que la zone a laissé propre
    </div>
    <!-- Hidden input to still submit the value with the form -->
    <input type="hidden" name="materials_used" value="Après chaque intervention au niveau des équipements, tout le matériel utilisé doit être ramassé, le matériel réparé et la zone ou l'intervention a eu lieu doit être bien examiné et bien nettoyé pour assurer qu'aucunes parties n'ont été dégagées et que la zone a laissé propre">
</div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Vérification de la propreté du site après intervention</label>
                        <select name="site_clean" class="form-select border-primary">
                            <option value="">Sélectionner</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Non conforme">Non conforme</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Production en cours</label>
                        <select name="production_ongoing" class="form-select border-primary">
                            <option value="">Sélectionner</option>
                            <option value="Oui">Oui</option>
                            <option value="Non">Non</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Heure de fin de nettoyage</label>
                        <input type="time" name="cleaning_end_time" class="form-control border-primary">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Évaluation de risque de l'intervention</label>
                        <select name="risk_level" class="form-select border-primary">
                            <option value="">Sélectionner</option>
                            <option value="Élevé">Élevé</option>
                            <option value="Moyen">Moyen</option>
                            <option value="Faible">Faible</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Risque sur la sécurité du produit ?</label>
                        <select name="product_safety_risk" id="product_safety_risk" class="form-select border-primary">
                            <option value="">Sélectionner</option>
                            <option value="Oui">Oui</option>
                            <option value="Non">Non</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Si oui, préciser le risque</label>
                    <input type="text" name="risk_description" id="risk_description" class="form-control border-primary" disabled>
                </div>

                <hr class="my-4 border-primary">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fait à</label>
                        <input type="text" name="location_signed" class="form-control border-primary">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Le</label>
                        <input type="date" name="date_signed" class="form-control border-primary">
                    </div>
                </div>

                <hr class="my-4 border-primary">

<h5 class="mb-3 text-primary"><i class="fas fa-signature me-2"></i>Signatures</h5>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="signature-box">
            <label class="form-label fw-bold">Signature l'intervenant</label>
            <div class="signature-line"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="signature-box">
            <label class="form-label fw-bold">Signature Responsable Maintenance</label>
            <div class="signature-line"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="signature-box">
            <label class="form-label fw-bold">Signature du chargé de nettoyage</label>
            <div class="signature-line"></div>
        </div>
    </div>
</div>


                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary px-4 py-2">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 0 !important;
    }
    .form-label {
        font-size: 0.9rem;
    }
    .border-primary {
        border-width: 1.5px !important;
    }
    .btn-primary {
        background-color: #2c3e50;
        border-color: #2c3e50;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .invalid-feedback {
        font-size: 0.8rem;
    }
    hr {
        opacity: 1;
    }
    .signature-box {
        text-align: center;
        margin-bottom: 20px;
    }
    .signature-line {
        border-top: 1px solid #333;
        margin-top: 40px;
        padding-top: 5px;
        height: 1px;
        width: 100%;
        .required-field label::after {
    content: ' *';
    color: #dc3545;
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875em;
}

.was-validated .form-control:invalid ~ .invalid-feedback,
.was-validated .form-control:invalid ~ .invalid-feedback {
    display: block;
}
</style>

<script>
    // Enable risk description when product safety risk is "Oui"
document.getElementById('product_safety_risk').addEventListener('change', function() {
    const riskDescriptionField = document.getElementById('risk_description');
    if (this.value === 'Oui') {
        riskDescriptionField.disabled = false;
        riskDescriptionField.required = true;
        riskDescriptionField.closest('.mb-4').classList.add('required-field');
    } else {
        riskDescriptionField.disabled = true;
        riskDescriptionField.required = false;
        riskDescriptionField.value = '';
        riskDescriptionField.closest('.mb-4').classList.remove('required-field');
    }
});

// Add red asterisk for required fields
document.querySelectorAll('[required]').forEach(element => {
    const label = element.closest('.form-group')?.querySelector('label') ||
                 element.closest('.col-md-3, .col-md-6')?.querySelector('label') ||
                 element.closest('.mb-4')?.querySelector('label');
    if (label && !label.innerHTML.includes('*')) {
        label.innerHTML += ' <span class="text-danger">*</span>';
    }
});
</script>
@endsection
