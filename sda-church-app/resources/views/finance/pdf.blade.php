<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Report | SDA Church</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #111827; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #111827; }
        .header p { margin: 5px 0 0; color: #4b5563; font-size: 12px; }
        .section-title { font-size: 16px; font-weight: bold; color: #111827; background: #f3f4f6; padding: 5px 10px; border-left: 4px solid #111827; margin-top: 25px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 6px 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: bold; color: #374151; font-size: 10px; text-transform: uppercase; }
        .amount { text-align: right; font-weight: bold; }
        .amount-in { color: #059669; }
        .amount-out { color: #dc2626; }
        .totals-container { width: 350px; float: right; margin-top: 30px; border: 2px solid #111827; padding: 15px; border-radius: 8px; }
        .totals-row { display: block; width: 100%; margin-bottom: 8px; border-bottom: 1px dashed #e5e7eb; padding-bottom: 4px; }
        .totals-label { font-weight: bold; color: #374151; display: inline-block; width: 220px; }
        .totals-value { text-align: right; display: inline-block; width: 100px; font-weight: bold; }
        .net-balance { border-top: 2px solid #111827; border-bottom: none; padding-top: 10px; margin-top: 5px; font-size: 15px; background: #f9fafb; }
        .footer { position: fixed; bottom: 20px; left: 0; width: 100%; text-align: center; font-size: 9px; color: #9ca3af; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SDA CHURCH MANAGEMENT SYSTEM</h1>
        <p>Comprehensive Financial Summary & Expenditure Report</p>
        <p>Document Generated: {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <!-- INCOME SECTIONS -->
    <h3 class="section-title">1. INCOME: Tithes</h3>
    @if($tithes->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Receipt No.</th>
                    <th class="amount">Amount (GHS)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tithes as $tithe)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($tithe->date_received)->format('M d, Y') }}</td>
                        <td>{{ $tithe->member ? $tithe->member->first_name . ' ' . $tithe->member->last_name : 'N/A' }}</td>
                        <td>{{ $tithe->receipt_number }}</td>
                        <td class="amount amount-in">{{ number_format($tithe->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tithes recorded.</p>
    @endif

    <h3 class="section-title">2. INCOME: Offerings & Donations</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type / Purpose</th>
                <th>Source</th>
                <th class="amount">Amount (GHS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offerings as $offering)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($offering->date_received)->format('M d, Y') }}</td>
                    <td>{{ $offering->category }} (Offering)</td>
                    <td>Church General</td>
                    <td class="amount amount-in">{{ number_format($offering->amount, 2) }}</td>
                </tr>
            @endforeach
            @foreach($donations as $donation)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($donation->date_received)->format('M d, Y') }}</td>
                    <td>{{ $donation->purpose }} (Donation)</td>
                    <td>{{ $donation->member ? $donation->member->first_name . ' ' . $donation->member->last_name : 'Anonymous' }}</td>
                    <td class="amount amount-in">{{ number_format($donation->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- EXPENDITURE SECTION -->
    <h3 class="section-title">3. EXPENDITURE / OUTFLOWS</h3>
    @if($expenditures->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title / Purpose</th>
                    <th>Category</th>
                    <th>Method</th>
                    <th class="amount">Amount (GHS)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenditures as $exp)
                    <tr>
                        <td>{{ $exp->expenditure_date->format('M d, Y') }}</td>
                        <td>{{ $exp->title }}</td>
                        <td>{{ $exp->category }}</td>
                        <td>{{ $exp->payment_method }}</td>
                        <td class="amount amount-out">(GHS {{ number_format($exp->amount, 2) }})</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No expenditures recorded.</p>
    @endif

    <!-- FINAL BALANCE SUMMARY -->
    <div class="totals-container">
        <div class="totals-row">
            <span class="totals-label">TOTAL TITHES:</span>
            <span class="totals-value">GHS {{ number_format($totalTithes, 2) }}</span>
        </div>
        <div class="totals-row">
            <span class="totals-label">TOTAL OFFERINGS:</span>
            <span class="totals-value">GHS {{ number_format($totalOfferings, 2) }}</span>
        </div>
        <div class="totals-row">
            <span class="totals-label">TOTAL DONATIONS:</span>
            <span class="totals-value">GHS {{ number_format($totalDonations, 2) }}</span>
        </div>
        <div class="totals-row" style="background:#d7e6dc; color:#1a3323;">
            <span class="totals-label">TOTAL INCOME:</span>
            <span class="totals-value">GHS {{ number_format($totalIncome, 2) }}</span>
        </div>
        <div class="totals-row" style="background:#fef2f2; color:#b91c1c;">
            <span class="totals-label">TOTAL EXPENSES:</span>
            <span class="totals-value">GHS {{ number_format($totalExpenses, 2) }}</span>
        </div>
        <div class="totals-row net-balance">
            <span class="totals-label">NET BALANCE:</span>
            <span class="totals-value @if($netBalance < 0) amount-out @else amount-in @endif">GHS {{ number_format($netBalance, 2) }}</span>
        </div>
    </div>
    
    <div class="clear"></div>

    <div class="footer">
        <p>SDA Church Management System — Financial Integrity Report — Confidental</p>
    </div>

</body>
</html>
