<!DOCTYPE html>
<html>
<head>
    <title>Calibration Form - Instrument Control</title>
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
        }

        body {
            font-family: 'Roboto', 'Segoe UI', sans-serif;
            line-height: 1.5;
            color: var(--text);
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
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

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        h2 {
            color: var(--primary);
            margin: 0;
            font-weight: 600;
            font-size: 24px;
        }

        .date-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-input label {
            font-weight: 500;
            color: var(--text-light);
        }

        input[type="date"] {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        thead {
            background-color: var(--primary);
            color: white;
        }

        th {
            padding: 14px 16px;
            text-align: center;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background-color: var(--secondary);
        }

        tbody tr:hover {
            background-color: #f1f5fd;
        }

        .instrument-name {
            font-weight: 500;
            color: var(--primary);
            text-align: left;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.2s;
            background-color: white;
        }

        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(58,123,200,0.2);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #e6f7ee;
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background-color: #fce8e8;
            color: var(--error);
            border-left: 4px solid var(--error);
        }

        .status-select {
            min-width: 100px;
        }

        .comment-input {
            min-width: 200px;
        }

        .signature-input {
            min-width: 120px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('calibrations.store') }}">
                @csrf

                <div class="form-header">
                    <h2>Étalonnage des Instruments</h2>
                    <div class="date-input">
                        <label for="calibration_date">Date de contrôle:</label>
                        <input type="date" name="calibration_date" value="{{ now()->toDateString() }}" required>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 25%;">Instrument</th>
                            <th style="width: 15%;">Vérifié</th>
                            <th style="width: 15%;">Conforme</th>
                            <th style="width: 30%;">Commentaire</th>
                            <th style="width: 15%;">Signature</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instruments as $instrument)
                        <tr>
                            <td class="instrument-name">{{ $instrument->name }}</td>
                            <td>
                                <select class="status-select" name="calibrations[{{ $instrument->id }}][verified]">
                                    <option value="1">✓ Oui</option>
                                    <option value="0">✗ Non</option>
                                </select>
                            </td>
                            <td>
                                <select class="status-select" name="calibrations[{{ $instrument->id }}][conform]">
                                    <option value="1">✓ Oui</option>
                                    <option value="0">✗ Non</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="comment-input" name="calibrations[{{ $instrument->id }}][comment]" value="RAS">
                            </td>
                            <td>
                                <input type="text" class="signature-input" name="calibrations[{{ $instrument->id }}][signature]" value="M,L">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="form-actions">
                    <button type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
