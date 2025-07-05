<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Contrôle des Températures - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
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
            height: 100px;
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
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .zone-cell {
            text-align: left;
            font-weight: 500;
            width: 15%;
        }
        .sub-header th {
            background-color: #e6e6e6;
            font-size: 11px;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
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
                <img src="{{ $logo }}" alt="Sweet Berry Logo">
            </div>
        @endif
        <div class="header-title">
            CONTROLE DES CHAMBRES FRIGORIFIQUES<br>
            <span style="font-size: 13px; font-weight: normal;">
                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </span>
        </div>
        <div class="header-meta">
            <div>Réf. : F-07/POM-04</div>
            <div>Version : 01 - Date : 08/03/21</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="zone-cell">Zone</th>
                @foreach($timeSlots as $slot)
                    <th colspan="2">{{ $slot }}</th>
                @endforeach
            </tr>
            <tr class="sub-header">
                @foreach($timeSlots as $slot)
                    <th>VL</th>
                    <th>VM</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($locations as $index => $location)
                <tr>
                    <td class="zone-cell">{{ $location }}</td>
                    @foreach($timeSlots as $slot)
                        <td>{{ $values[$index][$slot]['vl'] ?? '-' }}</td>
                        <td>{{ $values[$index][$slot]['vm'] ?? '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex align-items-end justify-content-end gap-4" style="margin-top: 40px; border-top: 1px solid #ddd; padding-top: 10px; width: 100%;">
    <h5 class="mb-0" style="font-size: 13px; font-weight: normal; color: #333;">Signé Res. maintenance Res PCQA :</h5>
    <div style="position: relative; display: inline-block;">
        <img src="{{ $Sin }}" alt="Signature" style="height: 40px; width: auto; max-width: 150px; display: block;">
        <div style="position: absolute; bottom: -15px; width: 100%; border-top: 1px solid #333; opacity: 0.3;"></div>
    </div>
</div>
    {{-- <div class="footer">
        Document généré le: {{ now()->format('d/m/Y H:i') }} | Sweet Berry
    </div> --}}
</body>
</html>
