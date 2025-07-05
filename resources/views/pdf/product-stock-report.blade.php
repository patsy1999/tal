<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>État du Stock - Rapport PSF</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .logo {
            max-width: 150px;
            max-height: 80px;
        }
        .report-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        .report-meta {
            text-align: right;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }
        th {
            background-color: #34495e;
            color: white;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-size: 10px;
            color: #95a5a6;
            text-align: center;
        }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 class="report-title">État du Stock</h1>
                <div class="company-info">
                    <strong>Sweet Berry</strong><br>
                </div>
            </div>
            <div class="report-meta">
                <div class="date">Généré le: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
                <!-- Add logo here if needed -->
                <!-- <img src="path/to/logo.png" class="logo" alt="Company Logo"> -->
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Nom du Produit</th>
                    <th style="width: 30%;">Type</th>
                    <th style="width: 30%;">Quantité en Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <div class="signature-line">
                Signature
            </div>
        </div>

        <div class="footer">
            Rapport généré automatiquement - © {{ date('Y') }} Nom de l'Entreprise. Tous droits réservés.
        </div>
    </div>
</body>
</html>
