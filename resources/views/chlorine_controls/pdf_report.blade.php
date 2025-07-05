<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Contrôle du Chlore Libre - {{ $month }}/{{ $year }}</title>
    <style>
        /* Modern & Professional Styling */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15mm;
        }

        /* Header Styles */
        .letterhead {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0066cc;
        }

        .logo-placeholder {
            width: 120px;
            height: 60px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
            color: #0066cc;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        /* Document Info */
        .document-info {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            font-size: 10px;
        }

        .document-meta {
            text-align: right;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 25px;
            font-size: 10px;
        }

        th {
            background-color: #0066cc;
            color: white;
            font-weight: 600;
            padding: 8px 6px;
            text-align: center;
            border: 1px solid #0055aa;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Status Indicators */
        .conforme {
            color: #009900;
            font-weight: 600;
        }

        .non-conforme {
            color: #cc0000;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            font-size: 9px;
            color: #666;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }

        /* Utility Classes */
        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: 600;
        }

        .page-break {
            page-break-after: always;
        }
        .logo {
        display: block;       /* Make sure it’s on its own line */
        margin: 0 auto 15px;  /* Center horizontally, with 15px bottom margin */
        max-width: 150px;     /* Max width to prevent oversized logo */
        max-height: 80px;     /* Max height to keep proportion */
        object-fit: contain;  /* Keep aspect ratio */
        border-bottom: 1px solid #ddd;  /* Optional subtle line below */
        padding-bottom: 10px; /* Padding below the logo */
}

    </style>
</head>
<body>

<!-- Company Letterhead -->
<div class="letterhead">
    <div class="header-text">
         @if(!empty($logoBase64))
        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
    @endif
        <div class="title">Contrôle du Chlore Libre dans l'Eau</div>
    </div>

</div>

<!-- Document Metadata -->
<div class="document-info">
    <div>
        <span class="text-bold">Période :</span>
        {{ \Carbon\Carbon::create()->month((int) $month)->format('F') }} {{ $year }}<br>
    </div>

    <div class="document-meta">
        <span class="text-bold">Réf. :</span> F-01/POM-02<br>
        <span class="text-bold">Version :</span> 00<br>
        <span class="text-bold">Date :</span> 21/12/18
    </div>
</div>

<!-- Main Data Table -->
<table>
    <thead>
        <tr>
            <th width="12%">Date</th>
            <th width="10%">Heure</th>
            <th width="25%">Point de prélèvement</th>
            <th width="15%">Chlore libre (ppm)</th>
            <th width="13%">Conformité</th>
            <th width="25%">Mesures correctives</th>
        </tr>
    </thead>
    <tbody>
    @foreach($grouped as $date => $entries)
        @foreach($entries as $i => $entry)
            <tr>
               <td style="font-weight: 600;">{{ $date }}</td>
                <td>{{ $entry->heure }}</td>
                <td>{{ $entry->sampling_point }}</td>
                <td>
                    @if($entry->heure === '09:00')
                        {{ $entry->chlorine_ppm_min }}
                    @else
                        {{ $entry->chlorine_ppm_max }}
                    @endif
                </td>
                <td class="{{ $entry->conforme ? 'conforme' : 'non-conforme' }}">
                    {{ $entry->conforme ? 'Oui' : 'Non ' }}
                </td>
                <td style="text-align: center;">{{ $entry->mesures_correctives ?? 'Aucune mesure corrective nécessaire' }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

<!-- Signature Block -->
<div style="margin-top: 30px; display: flex; justify-content: space-between;">
    <div style="width: 45%; border-top: 1px solid #333; padding-top: 5px;">
        <span class="text-bold">Signe Res. maintenance Res PCQA :</span><br>
    </div>
    <div style="width: 45%; border-top: 1px solid #333; padding-top: 5px;" class="text-right">
        <span class="text-bold">Date de validation :</span><br>
        __/__/____
    </div>
</div>


</body>
</html>
