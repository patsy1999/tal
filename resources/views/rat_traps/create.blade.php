@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Saisie Journalière – Pièges Raticide</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('rat-traps.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="check_date">Date :</label>
            <input type="date" name="check_date" class="form-control" required>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>N° de Piège</th>
                    <th>Appâts touché</th>
                    <th>Présence de cadavre</th>
                    <th>Mesure prise</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 46; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <select name="traps[{{ $i }}][bait_touched]" class="form-control" required>
                                <option value="Oui">Oui</option>
                                <option value="Non">Non</option>
                            </select>
                        </td>
                        <td>
                            <select name="traps[{{ $i }}][corpse_present]" class="form-control" required>
                                <option value="Oui">Oui</option>
                                <option value="Non">Non</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="traps[{{ $i }}][action_taken]" class="form-control" value="RAS" required>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
