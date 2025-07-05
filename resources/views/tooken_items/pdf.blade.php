<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Withdrawal Details #{{ $withdrawal->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .badge {
            background: #3498db;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            width: 30%;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Withdrawal Details</h1>
            <div class="badge">#{{ $withdrawal->id }}</div>
        </div>

        <table>
            <tr>
                <th>User</th>
                <td class="capitalize">{{ $withdrawal->user->name }}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td>{{ $withdrawal->product->name }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $withdrawal->quantity }}</td>
            </tr>
            <tr>
                <th>Reason</th>
                <td>{{ $withdrawal->reason }}</td>
            </tr>
            <tr>
                <th>Taken At</th>
                <td>{{ $withdrawal->taken_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <div class="footer">
            Generated on {{ now()->format('Y-m-d H:i') }} | Inventory Management System
        </div>
    </div>
</body>
</html>
