<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Summary</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #007bff;
            font-size: 22px;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0 8px 0;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #f2f2f2;
        }
        .summary-box {
            margin-bottom: 20px;
        }
        .summary-box p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Weekly Partner Summary</h2>
    </div>

    <div class="summary-box">
        <p><strong>Partner Name:</strong> {{ $partner->name }}</p>
        <p><strong>Total Commission:</strong> £{{ number_format($totalCommission, 2) }}</p>
        <p><strong>Total Payouts (This Week):</strong> £{{ number_format($totalPayouts, 2) }}</p>
        <p><strong>Remaining Balance:</strong> £{{ number_format($remainingBalance, 2) }}</p>
    </div>

    <div class="section-title">Payout History</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount (£)</th>
                <th>Type</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($history as $h)
            <tr>
                <td>{{ $h->created_at->format('d M Y') }}</td>
                <td>{{ number_format($h->amount, 2) }}</td>
                <td>{{ ucfirst($h->type ?? 'weekly') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
