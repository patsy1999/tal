@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Saisie Journalière - Conformité Appareils à Moustiquaires</h4>
        <a href="{{ route('mosquito.index') }}" class="btn btn-secondary">← Retour au Tableau</a>
    </div>

    <form action="{{ route('mosquito.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="date">Date du jour</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="month_label">Mois</label>
                <input type="month" name="month_label" class="form-control" required>
                <small class="text-muted">Le mois sera automatiquement formaté</small>
            </div>
        </div>

        <div class="row row-cols-5">
            @for ($i = 1; $i <= 15; $i++)
                <div class="col mb-2">
                    <label>D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</label>
                    <input name="D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" class="form-control" placeholder="C ou NC">
                </div>
            @endfor
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label>Moustiquaire</label>
                <input name="moustiquaire" class="form-control">
            </div>
            <div class="col-md-4">
                <label>État/Nettoyage</label>
                <input name="etat_nettoyage" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Action Corrective</label>
                <input name="action_corrective" class="form-control">
            </div>
        </div>

        <div class="text-end mt-4">
            <button class="btn btn-success">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
