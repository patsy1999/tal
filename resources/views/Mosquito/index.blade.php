@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container py-4">
    <div class="col-md-2">
    @auth
    @if(auth()->user()->role === 'admin')
        <form method="POST" action="{{ route('mosquito.clear') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir tout supprimer ?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">Vider la Table</button>
        </form>
    @endif
@endauth

</div>

    @auth
    @if(auth()->user()->role === 'admin')
        <form id="generateForm" method="POST" action="{{ route('mosquito.generate') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="start_date">Date début</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">Date fin</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Générer Automatiquement</button>
                </div>
            </div>
        </form>
    @endif
@endauth


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Saisie Journalière - Conformité Appareils à Moustiquaires</h4>
        <a href="{{ route('mosquito.create') }}" class="btn btn-primary">+ Nouvelle Journée</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('mosquito.index') }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-4">
        <label>Mois</label>
        <input type="month" name="month" value="{{ request('month', \Carbon\Carbon::parse($month)->format('Y-m')) }}" class="form-control" placeholder="Select month">
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-primary w-100">Filtrer</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('mosquito.export', ['month' => request('month', \Carbon\Carbon::parse($month)->format('Y-m'))]) }}" class="btn btn-danger w-100">PDF</a>
    </div>
</form>


            <p class="small text-muted">
                Marquer une <strong>C</strong> (conforme) si l’appareil fonctionne correctement et <strong>NC</strong> s’il ne fonctionne pas.
                Pour moustiquaires non nettoyées, marquer le numéro + NC.
            </p>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Jour</th>
                            @for ($i = 1; $i <= 15; $i++)
                                <th>D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                            @endfor
                            <th>Moustiquaire</th>
                            <th>État/Nettoyage</th>
                            <th>Action Corrective</th>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <th>Actions</th>
                                    @endif
                                @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->date)->day }}</td>
                                @for ($i = 1; $i <= 15; $i++)
                                    <td>{{ $record['D' . str_pad($i, 2, '0', STR_PAD_LEFT)] }}</td>
                                @endfor
                                <td>{{ $record->moustiquaire }}</td>
                                <td>{{ $record->etat_nettoyage }}</td>
                                <td>{{ $record->action_corrective }}</td>
                               @auth
    @if(auth()->user()->role === 'admin')
        <td>
                                    <form method="POST" action="{{ route('mosquito.destroy', $record->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-action="{{ route('mosquito.destroy', $record->id) }}">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            @endif
                        @endauth

                            </tr>
                        @empty
                            <tr>
                                <td colspan="20" class="text-center">Aucune donnée pour ce mois.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Voulez-vous vraiment supprimer cette ligne ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Supprimer</button>
      </div>
    </div>
  </div>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    let deleteFormAction = null;

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            deleteFormAction = this.dataset.action;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        });
    });

    const confirmBtn = document.getElementById('confirmDeleteBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function () {
            if (deleteFormAction) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteFormAction;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
});
</script>
