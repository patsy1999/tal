<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Étalonnage des Instruments - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .document-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .header-logo img {
            height: 80px;
            width: auto;
            max-width: 100px;
        }
        .header-title {
            flex-grow: 1;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
        .header-meta {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .instrument-cell {
            text-align: left;
            font-weight: 500;
            width: 25%;
        }
        .signature-cell {
            font-family: 'Brush Script MT', cursive;
            font-size: 14px;
        }
        .conform {
            color: #388e3c;
            font-weight: 500;
        }
        .non-conform {
            color: #d32f2f;
            font-weight: 500;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signature-section {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
        }
        .signature-label {
            font-size: 12px;
            color: #333;
        }
        .signature-image {
            height: 40px;
            width: auto;
            max-width: 150px;
        }
        .signature-line {
            border-top: 1px solid #333;
            opacity: 0.3;
            margin-top: 5px;
        }
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="document-header">
        @if(isset($logo))
            <div class="header-logo">
                <img src="{{ $logo }}" alt="Company Logo">
            </div>
        @endif
        <div class="header-title">
            ETALONNAGE DES INSTRUMENTS ET EQUIPEMENTS<br>
            <span style="font-size: 13px; font-weight: normal;">
                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </span>
        </div>
        <div class="header-meta">
            <div>Réf. : F-01/PG-04</div>
            <div>Version : 03 - Date : 21/02/2025</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="instrument-cell">Instrument</th>
                <th>Vérifié</th>
                <th>Conforme</th>
                <th>Commentaire</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calibrationsByDate as $dateKey => $group)
                @foreach($group as $calibration)
                    <tr>
                        <td class="instrument-cell">{{ $calibration->instrument->name ?? 'N/A' }}</td>
                        <td class="{{ $calibration->verified ? 'conform' : 'non-conform' }}">
                            {{ $calibration->verified ? 'Oui' : 'Non' }}
                        </td>
                        <td class="{{ $calibration->conform ? 'conform' : 'non-conform' }}">
                            {{ $calibration->conform ? 'Oui' : 'Non' }}
                        </td>
                        <td>{{ $calibration->comment }}</td>
                        <td class="signature-cell">{{ $calibration->signature }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">
        <div class="flex justify-between gap-5">
             <div class="signature-label">Signe Contrôleur maintenance :</div>
             <div class="signature-label">Signe responsable maintenance :</div>
        </div>
        <div>
            @if(isset($signature))
                <img src="{{ $signature }}" alt="Signature" class="signature-image">
            @else
                <div style="height: 40px;"></div>
            @endif
            <div class="signature-line"></div>
        </div>
    </div>

    <div class="footer">
        Document généré le: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
