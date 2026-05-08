<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Department Funds Report | SDA Church</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; color: #111827; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 12px; }
        .meta { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; padding: 10px 15px; margin-bottom: 20px; font-size: 11px; color: #6b7280; }
        .meta span { font-weight: bold; color: #111827; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #4f46e5; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .amount { text-align: right; font-weight: bold; }
        .receipt-badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; background: #dbeafe; color: #1e40af; }
        .total-row td { font-weight: bold; font-size: 13px; background-color: #ede9fe; border-top: 2px solid #4f46e5; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SDA CHURCH MANAGEMENT SYSTEM</h1>
        <p>Department Funds Report</p>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <div class="meta">
        <strong>Records:</strong> <span>{{ $departmentFunds->count() }}</span> &nbsp;&nbsp;
        @if(!empty($filters['start_date']) || !empty($filters['end_date']))
            <strong>Date Range:</strong>
            <span>{{ $filters['start_date'] ?? 'Any' }} to {{ $filters['end_date'] ?? 'Any' }}</span>
        @endif
        @if(!empty($filters['search']))
            &nbsp;&nbsp;<strong>Search:</strong> <span>{{ $filters['search'] }}</span>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date Received</th>
                <th>Department</th>
                <th>Receipt No.</th>
                <th class="amount">Amount (GHS)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($departmentFunds as $i => $fund)
                @php $total += $fund->amount; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($fund->date_received)->format('M d, Y') }}</td>
                    <td>{{ $fund->department->name ?? 'Unknown' }}</td>
                    <td><span class="receipt-badge">{{ $fund->receipt_number }}</span></td>
                    <td class="amount">{{ number_format($fund->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4">TOTAL</td>
                <td class="amount">GHS {{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        SDA Church CMS &mdash; Department Funds Report &mdash; Confidential
    </div>
</body>
</html>
