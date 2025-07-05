@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Maintenance Intervention</h4>
                <a href="{{ route('maintenance.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('maintenance.update', $record->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Date Fields -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                               value="{{ old('date', $record->date) }}" required>
                    </div>

                    <!-- Time Fields -->
                    <div class="col-md-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time"
                               value="{{ old('start_time', $record->start_time) }}">
                    </div>

                    <div class="col-md-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time"
                               value="{{ old('end_time', $record->end_time) }}">
                    </div>

                    <!-- Zone and Company -->
                    <div class="col-md-6">
                        <label for="zone" class="form-label">Zone</label>
                        <select class="form-select" id="zone" name="zone" required>
                            <option value="">Select Zone</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone }}" {{ $record->zone == $zone ? 'selected' : '' }}>{{ $zone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" id="company" name="company"
                               value="{{ old('company', $record->company) }}" required>
                    </div>

                    <!-- Technician -->
                    <div class="col-md-6">
                        <label for="intervenant" class="form-label">Technician</label>
                        <input type="text" class="form-control" id="intervenant" name="intervenant"
                               value="{{ old('intervenant', $record->intervenant) }}" required>
                    </div>

                    <!-- Work Details -->
                    <div class="col-12">
                        <label for="work_details" class="form-label">Work Details</label>
                        <textarea class="form-control" id="work_details" name="work_details" rows="3">{{ old('work_details', $record->work_details) }}</textarea>
                    </div>

                    <!-- Materials Used -->
                    <div class="col-12">
                        <label for="materials_used" class="form-label">Materials Used</label>
                        <textarea class="form-control" id="materials_used" name="materials_used" rows="2">{{ old('materials_used', $record->materials_used) }}</textarea>
                    </div>

                    <!-- Status and Safety -->
                    <div class="col-md-4">
                        <label class="form-label">Site Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="site_clean" name="site_clean"
                                   {{ $record->site_clean ? 'checked' : '' }}>
                            <label class="form-check-label" for="site_clean">Site Clean</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="production_ongoing" name="production_ongoing"
                                   {{ $record->production_ongoing ? 'checked' : '' }}>
                            <label class="form-check-label" for="production_ongoing">Production Ongoing</label>
                        </div>
                    </div>

                    <!-- Risk Information -->
                    <div class="col-md-8">
                        <label for="risk_description" class="form-label">Risk Description</label>
                        <textarea class="form-control" id="risk_description" name="risk_description" rows="2">{{ old('risk_description', $record->risk_description) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Intervention
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
