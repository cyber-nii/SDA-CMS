<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transfers Record | SDA Church</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; color: #111827; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #4f46e5; color: white; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 9px; font-weight: bold; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SDA CHURCH MANAGEMENT SYSTEM</h1>
        <p>Member Transfers Report</p>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member Name</th>
                <th>Type</th>
                <th>From Church</th>
                <th>To Church</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $i => $transfer)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $transfer->member ? $transfer->member->first_name . ' ' . $transfer->member->last_name : 'Unknown' }}</strong></td>
                    <td>
                        <span class="badge {{ $transfer->transfer_type === 'In' ? 'badge-green' : 'badge-blue' }}">
                            {{ $transfer->transfer_type === 'In' ? 'Incoming' : 'Outgoing' }}
                        </span>
                    </td>
                    <td>{{ $transfer->from_church ?? 'N/A' }}</td>
                    <td>{{ $transfer->to_church ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($transfer->request_date)->format('M d, Y') }}</td>
                    <td>
                        @php
                            $bc = match($transfer->status) {
                                'Approved' => 'badge-green', 'Completed' => 'badge-green',
                                'Rejected' => 'badge-red', default => 'badge-yellow',
                            };
                        @endphp
                        <span class="badge {{ $bc }}">{{ $transfer->status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        SDA Church CMS &mdash; Transfer Records
    </div>
</body>
</html>
