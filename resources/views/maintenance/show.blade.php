@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Maintenance Intervention Details</h4>
                <div>
                    <a href="{{ route('maintenance.edit', $record->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('maintenance.single.pdf', $record->id) }}" class="btn btn-danger btn-sm me-2">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-list"></i> All Records
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Main Information -->
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Intervention Details</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</dd>

                        <dt class="col-sm-4">Time:</dt>
                        <dd class="col-sm-8">
                            @if($record->start_time && $record->end_time)
                                {{ $record->start_time }} - {{ $record->end_time }}
                            @else
                                N/A
                            @endif
                        </dd>

                        <dt class="col-sm-4">Zone:</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-primary">{{ $record->zone }}</span>
                        </dd>

                        <dt class="col-sm-4">Company:</dt>
                        <dd class="col-sm-8">{{ $record->company }}</dd>

                        <dt class="col-sm-4">Technician:</dt>
                        <dd class="col-sm-8">{{ $record->intervenant }}</dd>
                    </dl>
                </div>

                <!-- Status Information -->
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Status Information</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Site Clean:</dt>
                        <dd class="col-sm-8">
                            @if($record->site_clean)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Production Ongoing:</dt>
                        <dd class="col-sm-8">
                            @if($record->production_ongoing)
                                <span class="badge bg-warning">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Created At:</dt>
                        <dd class="col-sm-8">{{ $record->created_at->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-4">Last Updated:</dt>
                        <dd class="col-sm-8">{{ $record->updated_at->format('d M Y H:i') }}</dd>
                    </dl>
                </div>

                <!-- Work Details -->
                <div class="col-12 mt-4">
                    <h5 class="border-bottom pb-2 mb-3">Work Details</h5>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($record->work_details)) !!}
                    </div>
                </div>

                <!-- Materials Used -->
                @if($record->materials_used)
                <div class="col-12 mt-4">
                    <h5 class="border-bottom pb-2 mb-3">Materials Used</h5>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($record->materials_used)) !!}
                    </div>
                </div>
                @endif

                <!-- Risk Information -->
                @if($record->risk_description)
                <div class="col-12 mt-4">
                    <h5 class="border-bottom pb-2 mb-3">Risk Information</h5>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($record->risk_description)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between">
            <form action="{{ route('maintenance.destroy', $record->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this record?')">
                    <i class="fas fa-trash-alt me-2"></i>Delete Record
                </button>
            </form>
            <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
</div>
@endsection
