@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Générer données aléatoires pour un mois</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('chlorine-controls.generate-random-month') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="month">Mois</label>
                <select name="month" id="month" class="form-control" required>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="year">Année</label>
                <select name="year" id="year" class="form-control" required>
                    @php
                        $startYear = 2020;
                        $currentYear = date('Y');
                    @endphp
                    @for ($y = $currentYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <button class="btn btn-success">Générer données aléatoires</button>
    </form>
</div>
@endsection
