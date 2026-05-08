<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Departments List | SDA Church</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; color: #111827; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #4f46e5; color: white; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SDA CHURCH MANAGEMENT SYSTEM</h1>
        <p>Departments &amp; Ministries Report</p>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Department Name</th>
                <th>Members</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $i => $dept)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $dept->name }}</strong></td>
                    <td>{{ $dept->members_count }}</td>
                    <td>{{ $dept->description ?? 'No description provided.' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        SDA Church CMS &mdash; Departments Report
    </div>
</body>
</html>
