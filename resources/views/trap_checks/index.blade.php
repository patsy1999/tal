@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>🪤 Historique – Pièges Raticide & Mécanique</h3>
        <a href="{{ route('trap-checks.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Ajouter une nouvelle saisie
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('trap-checks.index') }}" class="bg-white p-3 rounded shadow-sm mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="date" class="form-label fw-medium text-muted mb-1">Filtrer par date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-control form-control-sm border-secondary">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-primary btn-sm px-3 py-2">
                <i class="bi bi-search me-1"></i> Appliquer
            </button>
            <a href="{{ route('trap-checks.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Réinitialiser
            </a>
        </div>
    </div>
</form>

    @forelse($raticideRecords as $date => $ratiGroup)
        <div class="border rounded p-3 mb-4 bg-light shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">📅 Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('trap-checks.pdf', $date) }}" class="btn btn-outline-danger btn-sm" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                    <button class="btn btn-outline-warning btn-sm" onclick="confirmClear('{{ $date }}')">
                        <i class="bi bi-trash3"></i> Vider ce jour
                    </button>
                </div>
            </div>

            {{-- Raticide --}}
            <h6 class="mt-2">🧪 Pièges Raticide</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>N°</th>
                            <th>Appâts touché</th>
                            <th>Présence de cadavre</th>
                            <th>Mesure prise</th>
                              @auth
                              @if(auth()->user()->role === 'admin')
                            <th>Action</th>
                               @endif
                              @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ratiGroup as $record)
                            <tr>
                                <td>{{ $record->trap_number }}</td>
                                <td>{{ $record->bait_touched }}</td>
                                <td>{{ $record->corpse_present }}</td>
                                <td>{{ $record->action_taken }}</td>
                                  @auth
                                 @if(auth()->user()->role === 'admin')
                                <td>
                                                <a href="{{ route('trap-checks.raticide.edit', $record->id) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                </td>
                                   @endif
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mécanique --}}
            @php $mecaGroup = $mecaniqueRecords[$date] ?? collect(); @endphp
            @if($mecaGroup->count())
                <h6 class="mt-4">⚙️ Pièges Mécaniques</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>Piège mécanique</th>
                                @foreach($mecaGroup as $m)
                                    <th>{{ $m->trap_code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Nombre de capture</th>
                                @foreach($mecaGroup as $m)
                                    <td>{{ $m->captures }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>Mesure prise</th>
                                @foreach($mecaGroup as $m)
                                    <td>{{ $m->action_taken }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Aucune donnée mécanique pour cette date.</p>
            @endif
        </div>
    @empty
        <div class="alert alert-info">Aucune donnée trouvée.</div>
    @endforelse
</div>

{{-- Custom Modal for Delete + Clear --}}
<div id="confirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <p id="confirmText">⚠️ Êtes-vous sûr ?</p>
        <div class="text-end">
            <button class="btn btn-secondary btn-sm" onclick="closeModal()">Annuler</button>
            <button class="btn btn-danger btn-sm" onclick="submitAction()">Confirmer</button>
        </div>
    </div>
</div>

<style>
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.4);
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background: white;
        padding: 20px;
        width: 90%;
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 0 10px #0003;
        text-align: center;
    }
</style>

<script>
    let actionType = null;
    let actionTarget = null;

    function confirmDelete(id) {
        actionType = 'delete';
        actionTarget = id;
        document.getElementById('confirmText').innerText = '⚠️ Supprimer cette entrée ?';
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function confirmClear(date) {
        actionType = 'clear';
        actionTarget = date;
        document.getElementById('confirmText').innerText = '⚠️ Supprimer toutes les données de cette journée ?';
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('confirmModal').style.display = 'none';
        actionType = null;
        actionTarget = null;
    }

    function submitAction() {
    if (actionType === 'delete') {
        document.getElementById(`delete-form-${actionTarget}`).submit();
    } else if (actionType === 'clear') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dashboard/trap-checks/clear/${actionTarget}`; // <-- FIXED
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

</script>
@endsection
