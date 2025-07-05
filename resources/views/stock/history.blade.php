@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-3 border-0">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0 text-primary fw-bold">
                    <i class="fas fa-chart-line me-2"></i>Historique des Stocks
                </h3>
                <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('F Y') }}
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-light p-4 rounded-3 mb-4">
                <form method="GET" action="{{ route('stock.history') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="month" class="form-label text-muted small mb-1">Filtrer par mois</label>
                        <input type="month" name="month" id="month" value="{{ request('month') }}"
                               class="form-control border-primary border-2">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('stock.history.pdf', ['month' => request('month')]) }}"
                           class="btn btn-outline-danger w-100 {{ !request('month') ? 'disabled' : '' }}">
                            <i class="fas fa-file-pdf me-2"></i>Télécharger PDF
                        </a>
                    </div>
                </form>
            </div>

            <!-- Add Day Button -->
            <div class="mb-4">
                <form method="POST" action="{{ route('stock.history.add') }}">
                    @csrf
                    <button class="btn btn-success px-4">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter un jour
                    </button>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-responsive rounded-3 border overflow-hidden">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 bg-primary text-white">Date</th>
                            <th class="py-3 bg-primary text-white">Quantité utilisée</th>
                            <th class="py-3 bg-primary text-white">Quantité en stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usages as $usage)
                            <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                <td class="py-3">
                                    <i class="far fa-calendar text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($usage->date)->format('d/m/Y') }}
                                </td>
                                <td class="py-3 text-warning fw-bold">
                                    {{ $usage->used_quantity }}
                                    <small class="text-muted ms-1">unités</small>
                                </td>
                                <td class="py-3 text-success fw-bold">
                                    {{ $usage->stock_quantity }}
                                    <small class="text-muted ms-1">unités</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-muted">
                                    <i class="fas fa-info-circle me-2"></i>Aucune donnée disponible
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- @if($usages->hasPages())
                <div class="mt-4">
                    {{ $usages->links() }}
                </div>
            @endif --}}
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #2e59d9;
        transform: translateY(-1px);
    }

    .btn-success {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
@endsection
