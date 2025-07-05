<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Contrôle des équipements - Mois : {{ $month }}</h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Équipement</th>
                <th>État</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->date }}</td>
                    <td style="text-align: left;">{{ $record->equipment_name }}</td>
                    <td>{{ $record->is_good ? 'Oui' : 'Non' }}</td>
                    <td>{{ $record->observation }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
