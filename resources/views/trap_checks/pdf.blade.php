<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des Pièges - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            margin: 20px;
            color: #222;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .logo img {
            width: 120px;
        }

        h1.title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            color: #1a237e;
        }

        .header-info {
            margin-top: 8px;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .header-left span,
        .header-right span {
            display: block;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }

        th, td {
            border: 1px solid #888;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #1a237e;
            color: #fff;
            font-weight: 600;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        h4.section-title {
            color: #1a237e;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        .date-inline {
            font-size: 10px;
            color: #444;
            margin-left: 10px;
        }

        p.no-data {
            font-style: italic;
            color: #777;
            margin-top: 8px;
        }
    </style>
</head>
<body>

    <div class="top-header">
        <div class="logo">
            <img src="{{ public_path('images/sweet.png') }}" alt="Logo">
        </div>
        <h1 class="title">FICHE DE CONTRÔLE DE LA LUTTE CONTRE LA VERMINE</h1>
    </div>

    <div class="header-info">
        <div class="header-left">
            <span>Réf : F03/POM08</span>
            <span>Version : 02</span>
            <span>Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
        </div>
        <div class="header-right">
            <span>Date d'impression : {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    {{-- Pièges Raticide --}}
    <h4 class="section-title">
        Pièges Raticide
        <span class="date-inline">(Date: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }})</span>
    </h4>

    <table>
        <thead>
            <tr>
                <th>N° de Piège</th>
                <th>Appâts touché</th>
                <th>Présence de cadavre</th>
                <th>Mesure prise</th>
            </tr>
        </thead>
        <tbody>
            @foreach($raticideRecords as $r)
                <tr>
                    <td>{{ $r->trap_number }}</td>
                    <td>{{ $r->bait_touched }}</td>
                    <td>{{ $r->corpse_present }}</td>
                    <td>{{ $r->action_taken }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pièges Mécaniques --}}
    <h4 class="section-title">Pièges Mécaniques</h4>

    @if($mecaniqueRecords->count())
        <table>
            <thead>
                <tr>
                    <th>Piège mécanique</th>
                    @foreach($mecaniqueRecords as $m)
                        <th>{{ $m->trap_code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Nombre de capture</th>
                    @foreach($mecaniqueRecords as $m)
                        <td>{{ $m->captures }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Mesure prise</th>
                    @foreach($mecaniqueRecords as $m)
                        <td>{{ $m->action_taken }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @else
        <p class="no-data">Aucune donnée mécanique disponible.</p>
    @endif

</body>
</html>
