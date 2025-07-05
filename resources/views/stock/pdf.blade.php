<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Historique de Stock - {{ $month->format('F Y') }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header-container {
            margin-bottom: 15px;
        }
        .company-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .logo-container {
            width: 30%;
        }
        .logo {
            height: 80px;
            max-width: 200px;
            object-fit: contain;
        }
        .document-info {
            width: 30%;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .title-container {
            text-align: center;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 2px solid #4e73df;
            border-bottom: 2px solid #4e73df;
        }
        h1 {
            color: #2e59d9;
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #4e73df;
            color: white;
            text-transform: uppercase;
            font-size: 11px;
            padding: 10px 5px;
            text-align: center;
            font-weight: 600;
        }
        td {
            border: 1px solid #e0e0e0;
            padding: 8px 5px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }
        .signature-box {
            width: 250px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin: 30px auto 5px;
            width: 80%;
        }
        .signature-label {
            font-size: 10px;
            color: #555;
        }
        .document-ref {
            background-color: #f5f5f5;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 10px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <!-- Company Header with Logo -->
        <div class="company-header">
            <div class="logo-container">
                @if(isset($logo))
                    <img src="{{ $logo }}" class="logo" alt="Logo Sweet Berry">
                @endif
            </div>

        </div>

        <!-- Document Title -->
        <div class="title-container">
            <h1>SUIVI DES SACHETS DE RÉACTIFS</h1>
            <div class="subtitle">Période: {{ $month->locale('fr')->isoFormat('MMMM YYYY') }}</div>
            <div class="document-info">
                Réf. : F-02/POM-02<br>
                Version : 01<br>
                Date : 16/10/2020
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th width="30%">Date</th>
                <th width="35%">Quantité utilisée</th>
                <th width="35%">Quantité en stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usages as $usage)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($usage->date)->format('d/m/Y') }}</td>
                    <td>{{ $usage->used_quantity }} sachets</td>
                    <td>{{ $usage->stock_quantity }} sachets</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer and Signatures -->
    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }}
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Signe Res. maintenance Res PCQA : </div>
        </div>
    
    </div>
</body>
</html>
