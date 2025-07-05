<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Température</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #0d6efd; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Rapport de Température</h1>

    <p>Date de génération : {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Doha</th>
                <th>Imane</th>
                <th>maryam</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Chambre Froide 1</td>
                <td>5</td>
                <td>6</td>
            </tr>
            <tr>
                <td>Tunnel 3</td>
                <td>10</td>
                <td>11</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</body>
</html>
