<!DOCTYPE html>
<html>
<head>
    <title>Weekly Withdrawals Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .report-period {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            font-size: 0.8em;
            letter-spacing: 0.1em;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #7f8c8d;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .no-data {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            margin: 25px 0;
            font-style: italic;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <h2>Weekly Product Withdrawals Report</h2>
    <div class="report-period">
        From: {{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }} To: {{ \Carbon\Carbon::now()->format('Y-m-d') }}
    </div>

    @if(count($data) > 0)
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Reason</th>
                    <th>Taken At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ $item->taken_at ? $item->taken_at->format('Y-m-d H:i') : $item->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            No product withdrawals were recorded during this reporting period (last 7 days).
        </div>
    @endif

    <div class="footer">
        Report generated on {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }} | &copy; {{ date('Y') }} Sweet Berry
    </div>
</body>
</html>
