<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PDF - Fiches de Maintenance</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Historique des interventions de maintenance</h3>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Zone</th>
                <th>Société</th>
                <th>Intervenant</th>
                <th>Détail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                    <td>{{ $record->zone }}</td>
                    <td>{{ $record->company }}</td>
                    <td>{{ $record->intervenant }}</td>
                    <td>{{ Str::limit($record->work_details, 50) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
