<!DOCTYPE html>
<html>
<head>
    <title>Historique d'Étalonnage</title>
    <style>
        :root {
            --primary: #2c5e92;
            --primary-light: #3a7bc8;
            --secondary: #f8f9fa;
            --border: #e0e0e0;
            --text: #333;
            --text-light: #666;
            --success: #28a745;
            --error: #dc3545;
            --warning: #ffc107;
        }

        body {
            font-family: 'Roboto', 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: var(--text);
            background-color: #f5f7fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .filter-form label {
            font-weight: 500;
            color: var(--text-light);
            white-space: nowrap;
        }

        .filter-form input[type="date"] {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-form button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .filter-form button:hover {
            background-color: var(--primary-light);
        }

        .no-data {
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            color: var(--text-light);
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .calibration-group {
            margin-bottom: 40px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .calibration-header {
            padding: 15px 20px;
            background-color: var(--primary);
            color: white;
            font-size: 18px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 14px 16px;
            text-align: left;
            background-color: #f1f5fd;
            color: var(--primary);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background-color: var(--secondary);
        }

        tbody tr:hover {
            background-color: #f8fafd;
        }

        .status-yes {
            color: var(--success);
            font-weight: 500;
        }

        .status-no {
            color: var(--error);
            font-weight: 500;
        }

        .comment-cell {
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
           <form method="GET" action="{{ route('calibrations.index') }}" class="filter-form">
    <div class="form-controls">
        <label for="date">Choisir une date :</label>
        <input type="date" name="date" id="date" value="{{ $date ?? '' }}">
        <button type="submit">Afficher</button>
    </div>
    <div class="form-actions">
        <a href="{{ route('calibrations.create') }}" class="action-button add-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Nouvel Étalonnage
        </a>
        <a href="{{ route('calibrations.downloadPdf', ['date' => $date ?? \Carbon\Carbon::today()->toDateString()]) }}"
           class="action-button download-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
            </svg>
            Télécharger PDF
        </a>
    </div>
</form>

<style>
.filter-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
    padding: 15px;
    background-color: white;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.form-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-controls label {
    font-weight: 500;
    color: #555;
}

.form-controls input[type="date"] {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-controls button[type="submit"] {
    padding: 4px 16px;
    background-color: #2c5e92;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.form-controls button[type="submit"]:hover {
    background-color: #1d4b7a;
}

.form-actions {
    display: flex;
    gap: 10px;
}

.action-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 16px;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.action-button svg {
    width: 14px;
    height: 14px;
}

.download-button {
    background-color: #28a745;
    border-color: #23923c;
}

.download-button:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

.add-button {
    background-color: #17a2b8;
    border-color: #138496;
}

.add-button:hover {
    background-color: #138496;
    transform: translateY(-1px);
}
.back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            transition: var(--transition);
            color: #3B82F6;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: #2563EB;
        }

        .back-button i {
            font-size: 1.2rem;
        }
</style>
<head>
  <!-- Add FontAwesome CDN link -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  />
</head>
<body>
  <button class="back-button" onclick="window.history.back()" aria-label="Retour">
      <i class="fas fa-arrow-left"></i>
  </button>
</body>
            @if($calibrationsByDate->isEmpty())
                <div class="no-data">
                    <p>Aucun étalonnage trouvé pour la date {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}.</p>
                </div>
            @else
                @foreach($calibrationsByDate as $dateKey => $group)
                    <div class="calibration-group">
                        <div class="calibration-header">
                            Étallonage du {{ \Carbon\Carbon::parse($dateKey)->format('d/m/Y') }}
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Instrument</th>
                                    <th>Vérifié</th>
                                    <th>Valeur Conforme</th>
                                    <th>Commentaire</th>
                                    <th>Signature</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $calibration)
                                    <tr>
                                        <td>{{ $calibration->instrument->name ?? 'N/A' }}</td>
                                        <td class="{{ $calibration->verified ? 'status-yes' : 'status-no' }}">
                                            {{ $calibration->verified ? 'Oui' : 'Non' }}
                                        </td>
                                        <td class="{{ $calibration->conform ? 'status-yes' : 'status-no' }}">
                                            {{ $calibration->conform ? 'Oui' : 'Non' }}
                                        </td>
                                        <td class="comment-cell">{{ $calibration->comment }}</td>
                                        <td>{{ $calibration->signature }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
