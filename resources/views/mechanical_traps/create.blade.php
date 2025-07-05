@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Saisie Journalière – Pièges Mécaniques</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('mechanical-traps.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="check_date" class="form-label">Date :</label>
            <input type="date" name="check_date" class="form-control" required>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Piège mécanique</th>
                    @foreach($traps as $trap)
                        <th>{{ $trap }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Nombre de capture</th>
                    @foreach($traps as $trap)
                        <td>
                            <input type="number" name="captures[{{ $trap }}]" class="form-control" value="0" min="0" required>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Mesure prise</th>
                    @foreach($traps as $trap)
                        <td>
                            <input type="text" name="actions[{{ $trap }}]" class="form-control" value="RAS" required>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
