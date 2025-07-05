<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.2;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e74c3c;
        }
        .logo-container img {
            height: 60px;
            max-width: 120px;
            object-fit: contain;
        }
        .header-text {
            flex-grow: 1;
            text-align: center;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
        .report-title {
            font-size: 11px;
            color: #7f8c8d;
        }
        h2 {
            font-size: 12px;
            color: #e74c3c;
            margin: 8px 0;
            padding: 4px 0;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        th {
            background-color: #e74c3c;
            color: white;
            padding: 4px;
            text-align: center;
        }
        td {
            border: 1px solid #ddd;
            padding: 4px;
            vertical-align: middle;
        }
        .status-yes { color: #27ae60; }
        .status-no { color: #e74c3c; }
         .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 9px;
            color: #555;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature {
            width: 40%;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin-top: 25px;
            padding-top: 3px;
        }

        .document-info {
            text-align: right;
            color: #95a5a6;
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if(isset($logo))
        <div class="logo-container">
            <img src="{{ $logo }}" alt="Company Logo">
        </div>
        @endif
        <div class="header-text">
            <div class="company-name">FICHE DE VERIFICATION DE LA MAINTENANCE</div>
        </div>
    </div>

    <div class="report-info">
        <div>Ref : F-03/PG-04</div>
        <div>Version : 01 - Date: 01/11/2020</div>
    </div>

    <h2>CONTROLE DES EQUIPEMENTS</h2>

    <table>
        <thead>
            <tr>
                <th width="40%">Équipement</th>
                <th width="15%">État</th>
                <th width="45%">Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->equipment_name }}</td>
                <td class="{{ $record->is_good ? 'status-yes' : 'status-no' }}">
                    {{ $record->is_good ? '✓ Oui' : '✗ Non' }}
                </td>
                <td>{{ $record->observation ?: '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <div class="signature-line">Signature Responsable de la Maintenance : </div>
        </div>
    </div>
</body>
</html>
