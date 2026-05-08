<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Members Directory | SDA Church</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; color: #111827; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 7px 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #4f46e5; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 30px; }
        .summary { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; padding: 10px 15px; margin-bottom: 20px; }
        .summary span { font-weight: bold; color: #4f46e5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SDA CHURCH MANAGEMENT SYSTEM</h1>
        <p>Members Directory Report</p>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <div class="summary">
        Total members in report: <span>{{ $members->count() }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $i => $member)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $member->first_name }} {{ $member->last_name }}</strong></td>
                    <td>{{ $member->gender }}</td>
                    <td>{{ $member->contact_number ?? 'N/A' }}</td>
                    <td>{{ $member->email ?? 'N/A' }}</td>
                    <td>{{ $member->role_in_church ?? 'Member' }}</td>
                    <td>
                        @if($member->status === 'Active')
                            <span class="badge badge-green">Active</span>
                        @elseif($member->status === 'Inactive')
                            <span class="badge badge-yellow">Inactive</span>
                        @elseif($member->status === 'Transferred')
                            <span class="badge badge-blue">Transferred</span>
                        @else
                            <span class="badge badge-red">{{ $member->status }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        SDA Church CMS &mdash; Confidential Members Directory
    </div>
</body>
</html>
