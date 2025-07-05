<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrôle Moustiquaire - Mois {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 15px 10px;
            line-height: 1.2;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .reference {
            text-align: right;
            font-size: 8px;
            margin-bottom: 10px;
            margin-top: 15px;
        }
        .subtitle {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            font-size: 9px;
            height: 15px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .notes {
            margin: 5px 0;
            font-size: 8px;
            text-align: justify;
        }
        .footer-sign {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }
        .sign-block {
            width: 45%;
            text-align: center;
            font-size: 9px;
        }
        .sign-line {
            margin-top: 20px;
            border-top: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .compact-cell {
            padding: 1px 2px;
        }
    </style>
</head>
<body>

    <div class="header">
            <img src="{{ public_path('images/sweet.png') }}" width="130">
    </div>

    <div class="title">CONTROLE JOURNALIER DE FONCTIONNEMENT ET NETTOYAGE DES MOUSTIQUAIRES</div>
    <div class="reference ">
            Réf. : F-01/POM-06<br>
            Version : 02<br>
            Date : 01/11/2020
        </div>
    <div class="subtitle">Mois : {{ $month }}</div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Jour</th>
                @for ($i = 1; $i <= 15; $i++)
                    <th style="width: 3.5%;">D{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                @endfor
                <th style="width: 10%;">Moustiquaire</th>
                <th style="width: 12%;">État/Nettoyage</th>
                <th style="width: 15%;">Action Corrective</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td class="compact-cell">{{ \Carbon\Carbon::parse($record->date)->day }}</td>
                    @for ($i = 1; $i <= 15; $i++)
                        <td class="compact-cell">{{ $record['D' . str_pad($i, 2, '0', STR_PAD_LEFT)] }}</td>
                    @endfor
                    <td class="compact-cell">{{ $record->moustiquaire }}</td>
                    <td class="compact-cell">{{ $record->etat_nettoyage }}</td>
                    <td class="compact-cell">{{ $record->action_corrective }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-sign">
        <div class="sign-block">
            <p>Signature Contrôleur Maintenance</p>
            <div class="sign-line"></div>
        </div>
        <div class="sign-block">
            <p>Signature Responsable Maintenance</p>
            <div class="sign-line"></div>
        </div>
    </div>

</body>
</html>
