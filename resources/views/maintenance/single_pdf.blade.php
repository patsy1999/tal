<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Intervention</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .small-text {
            font-size: 11px;
        }
        .tall-cell {
            height: 100px;
        }
        .signature-label {
            text-align: center;
            font-size: 11px;
            line-height: 1.3;
            border-top: none;
        }
        .signature-space-row td {
            height: 60px;
        }
    </style>
</head>
<body>
    @if(isset($logo))
        <img src="{{ $logo }}" alt="Logo" style="width: 100px; height: auto; margin-bottom: 10px;"> <!-- Display logo if available -->
    @endif
    <img src="{{ public_path('images/sweet.png') }}" width="130">

    <table>
        <tr>
            <td colspan="4" class="header">FICHE D’INTERVENTION DE MAINTENANCE À L’INTÉRIEUR DE LA STATION</td>
            <td colspan="2">
                Réf. : F-11/PG-04<br>
                Version : 03 - Date : 12/03/25
            </td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
            <th>Heure Début</th>
            <td>{{ $record->start_time }}</td>
            <th>Heure Fin</th>
            <td>{{ $record->end_time }}</td>
        </tr>
        <tr>
            <th>Zone</th>
            <td colspan="5">{{ $record->zone }}</td>
        </tr>
        <tr>
            <th>Société</th>
            <td colspan="2">{{ $record->company }}</td>
            <th>Intervenant(s)</th>
            <td colspan="2">{{ $record->intervenant }}</td>
        </tr>
        <tr>
            <th colspan="6">Description de l’intervention</th>
        </tr>
        <tr>
            <td colspan="6" class="tall-cell">{{ $record->work_details }}</td>
        </tr>
        <tr>
            <th>Matériel utilisé (préciser si produit chimique)</th>
            <td colspan="5" class="tall-cell">{{ $record->materials_used }}</td>
        </tr>
        <tr>
            <th>Vérification de la propreté du site après intervention</th>
            <td colspan="2">{{ $record->site_clean }}</td>
            <th>Production en cours</th>
            <td colspan="2">{{ $record->production_ongoing }}</td>
        </tr>
        <tr>
            <th>Heure de fin de nettoyage</th>
            <td colspan="2">{{ $record->cleaning_end_time }}</td>
            <th>Évaluation de risque de l’intervention</th>
            <td colspan="2">{{ $record->risk_level }}</td>
        </tr>
        <tr>
            <th>Y-a-t-il un risque sur la sécurité du produit ?</th>
            <td>{{ $record->product_safety_risk }}</td>
            <th>Lequel ?</th>
            <td colspan="3">{{ $record->risk_description }}</td>
        </tr>
        <tr>
            <td colspan="6" class="small-text">
                Après chaque intervention au niveau des équipements, tout le matériel utilisé doit être ramassé, le matériel réparé et la zone où l'intervention a eu lieu doit être bien examinée et bien nettoyée pour assurer qu’aucunes parties n’ont été dégagées et que la zone a laissé propre.
            </td>
        </tr>
       <tr>
    <th>Fait à :</th>
    <td>{{ $record->location_signed }}</td>
    <th>Le :</th>
    <td colspan="3">
        {{ \Carbon\Carbon::parse($record->date_signed)->format('d/m/Y') }}
    </td>
</tr>


        <!-- Signature space -->
        <tr class="signature-space-row">
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2" class="signature-label">Signature de<br>l’intervenant</td>
            <td colspan="2" class="signature-label">Signature Responsable<br>Maintenance</td>
            <td colspan="2" class="signature-label">Signature du chargé<br>de nettoyage</td>
        </tr>
    </table>

</body>
</html>
