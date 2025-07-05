@extends('layouts.app')

@section('content')
@php
    $zones = $records->pluck('zone')->unique()->sort();
    $technicians = $records->pluck('intervenant')->unique()->sort();
@endphp

<!-- Then use these in your selects as shown above -->
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 font-weight-bold mb-1">Maintenance History</h1>
            <p class="text-muted small mb-0">Track and manage all maintenance interventions</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#helpModal">
                <i class="fas fa-question-circle mr-2"></i>Help
            </button>
            <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-2"></i>New Intervention
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <h6 class="m-0 font-weight-bold text-primary">Filter Records</h6>
            <div class="mt-2 mt-md-0">
                <span class="badge badge-light">
                    Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} records
                </span>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('maintenance.index') }}" class="row g-3">
                <!-- Date Range Filters -->
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted fw-bold">Start Date</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                        <input type="date" name="from" id="from" value="{{ request('from') }}"
                               class="form-control border-start-0" max="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted fw-bold">End Date</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                        <input type="date" name="to" id="to" value="{{ request('to') }}"
                               class="form-control border-start-0" max="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>

             <div class="col-md-3">
    <label class="form-label small text-uppercase text-muted fw-bold">Zone</label>
    <select name="zone" class="form-select">
        <option value="">All Zones</option>
        @foreach($zones as $zone)
            <option value="{{ $zone }}" {{ request('zone') == $zone ? 'selected' : '' }}>
                {{ $zone }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-3">
    <label class="form-label small text-uppercase text-muted fw-bold">Technician</label>
    <select name="technician" class="form-select">
        <option value="">All Technicians</option>
        @foreach($technicians as $tech)
            <option value="{{ $tech }}" {{ request('technician') == $tech ? 'selected' : '' }}>
                {{ $tech }}
            </option>
        @endforeach
    </select>
</div>

                <!-- Action Buttons -->
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </a>
                    <div class="dropdown">
                        {{-- <button class="btn btn-danger dropdown-toggle" type="button" id="exportDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false" {{ $records->isEmpty() ? 'disabled' : '' }}>
                            <i class="fas fa-file-export mr-2"></i>Export
                        </button> --}}
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('maintenance.pdf', request()->query()) }}">
                                    <i class="fas fa-file-pdf text-danger mr-2"></i>PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('maintenance.export', array_merge(request()->query(), ['format' => 'csv'])) }}">
                                    <i class="fas fa-file-csv text-primary mr-2"></i>CSV
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('maintenance.export', array_merge(request()->query(), ['format' => 'excel'])) }}">
                                    <i class="fas fa-file-excel text-success mr-2"></i>Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="py-3 px-4 text-uppercase small font-weight-bold">Date</th>
                            <th class="py-3 px-4 text-uppercase small font-weight-bold">Zone</th>
                            <th class="py-3 px-4 text-uppercase small font-weight-bold">Company</th>
                            <th class="py-3 px-4 text-uppercase small font-weight-bold">Technician</th>
                            <th class="py-3 px-4 text-uppercase small font-weight-bold">Work Details</th>
                            {{-- <th class="py-3 px-4 text-uppercase small font-weight-bold">Status</th> --}}
                            <th class="py-3 px-4 text-uppercase small font-weight-bold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr class="align-middle">
                                <td class="px-4">
                                    <div class="d-flex flex-column">
                                        <span class="text-primary font-weight-bold">
                                            {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($record->date)->diffForHumans() }}
                                        </small>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <span class="badge badge-pill bg-primary-light text-primary">
                                        {{ $record->zone }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-soft-primary rounded me-3">
                                            <span class="avatar-text font-weight-bold">
                                                {{ substr($record->company, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $record->company }}</h6>
                                            <small class="text-muted">{{ $record->contact_phone ?? 'No contact' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-soft-info rounded-circle me-3">
                                            <span class="avatar-text">
                                                {{ substr($record->intervenant, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $record->intervenant }}</h6>
                                            <small class="text-muted">{{ $record->intervenant_phone ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="work-details" data-bs-toggle="tooltip" data-bs-placement="top"
                                         title="{{ $record->work_details }}">
                                        <p class="mb-0 text-truncate" style="max-width: 250px;">
                                            {{ $record->work_details }}
                                        </p>
                                        <small class="text-muted">Hover for details</small>
                                    </div>
                                </td>
                                {{-- <td class="px-4">
                                    @if($record->status === 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-success">Completed</span>
                                    @elseif($record->status === 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Pending</span>
                                    @elseif($record->status === 'cancelled')
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Unknown</span>
                                    @endif
                                </td> --}}
                                <td class="px-4 text-end">
                                    <div class="d-flex gap-3 justify-between">
                                        {{-- <a href="{{ route('maintenance.show', $record->id) }}"
                                           class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('maintenance.edit', $record->id) }}"
                                           class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip"
                                           title="Edit Record">
                                            <i class="fas fa-edit"></i>
                                        </a> --}}
                                        <a href="{{ route('maintenance.single.pdf', $record->id) }}"
                                           class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                           title="Download PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <form action="{{ route('maintenance.destroy', $record->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" title="Delete Record"
                                                    onclick="return confirm('Are you sure you want to delete this record?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-5">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No maintenance records found</h5>
                                        <p class="text-muted small">Create your first maintenance intervention</p>
                                        <a href="{{ route('maintenance.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus-circle mr-2"></i>Add New Record
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <span class="text-muted small">
                            Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} entries
                        </span>
                    </div>
                    <div>
                        {{ $records->withQueryString()->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="helpModalLabel">Maintenance History Help</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary"><i class="fas fa-filter mr-2"></i>Filtering Records</h6>
                        <p class="small">Use the date range filters to narrow down records by specific time periods. You can also filter by zone or technician for more targeted results.</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary"><i class="fas fa-file-export mr-2"></i>Exporting Data</h6>
                        <p class="small">Export your filtered results to PDF, CSV, or Excel formats for reporting or further analysis.</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary"><i class="fas fa-plus-circle mr-2"></i>Adding New Records</h6>
                        <p class="small">Click the "New Intervention" button to add a new maintenance record to the system.</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary"><i class="fas fa-edit mr-2"></i>Managing Records</h6>
                        <p class="small">Use the action buttons to view, edit, export, or delete individual maintenance records.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-text {
        font-size: 0.875rem;
        color: inherit;
    }
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }
    .table thead th {
        border-bottom: 1px solid #e9ecef;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8fafc;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f5f9;
    }
    .rounded-circle {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .work-details small {
        opacity: 0;
        transition: opacity 0.2s;
    }
    .work-details:hover small {
        opacity: 1;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .badge.bg-opacity-10 {
        opacity: 0.9;
    }
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        border-bottom: none;
    }
    /* Custom confirmation dialog styles */
.confirmation-dialog {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.confirmation-dialog.active {
    opacity: 1;
    pointer-events: all;
}

.confirmation-box {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 90%;
    text-align: center;
}

.confirmation-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.confirmation-buttons button {
    padding: 0.5rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.confirm-btn {
    background: #dc3545;
    color: white;
}

.confirm-btn:hover {
    background: #bb2d3b;
}

.cancel-btn {
    background: #6c757d;
    color: white;
}

.cancel-btn:hover {
    background: #5c636a;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const confirmationDialog = document.getElementById('confirmationDialog');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    let currentForm = null;

    // Attach click handlers to all delete buttons
    document.querySelectorAll('[data-delete-form]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentForm = document.getElementById(this.dataset.deleteForm);
            confirmationDialog.classList.add('active');
        });
    });

    // Confirm delete
    confirmDelete.addEventListener('click', function() {
        if (currentForm) {
            currentForm.submit();
        }
        confirmationDialog.classList.remove('active');
    });

    // Cancel delete
    cancelDelete.addEventListener('click', function() {
        confirmationDialog.classList.remove('active');
        currentForm = null;
    });
});
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Date validation
        const fromDate = document.getElementById('from');
        const toDate = document.getElementById('to');

        if (fromDate && toDate) {
            fromDate.addEventListener('change', function() {
                if (this.value && toDate.value && this.value > toDate.value) {
                    toDate.value = this.value;
                }
            });

            toDate.addEventListener('change', function() {
                if (this.value && fromDate.value && this.value < fromDate.value) {
                    fromDate.value = this.value;
                }
            });
        }

        // Auto-close dropdown after selection
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const dropdown = bootstrap.Dropdown.getInstance(this.closest('.dropdown').querySelector('[data-bs-toggle="dropdown"]'));
                dropdown.hide();
            });
        });
    });
</script>
@endsection
