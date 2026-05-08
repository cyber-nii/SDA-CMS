<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px; }
        .header { text-align: center; border-bottom: 2px solid #4a5568; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { max-width: 150px; }
        .receipt-title { font-size: 24px; font-bold; color: #2d3748; margin-top: 10px; }
        .details { margin-bottom: 30px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #edf2f7; }
        .detail-label { font-weight: bold; color: #4a5568; }
        .amount { font-size: 20px; font-weight: bold; color: #38a169; }
        .footer { text-align: center; font-size: 12px; color: #718096; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="receipt-title">Payment Receipt</div>
            <p>SDA Church Management System</p>
        </div>

        <div class="details">
            <p>Dear {{ $member->first_name }},</p>
            <p>Thank you for your faithful support. We have successfully recorded your {{ strtolower($type) }}.</p>

            <div class="detail-row">
                <span class="detail-label">Receipt Number:</span>
                <span>{{ $payment->receipt_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span>{{ \Carbon\Carbon::parse($payment->date_received)->format('M d, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Type:</span>
                <span>{{ $type }}</span>
            </div>
            @if($type === 'Donation')
            <div class="detail-row">
                <span class="detail-label">Purpose:</span>
                <span>{{ $payment->purpose }}</span>
            </div>
            @endif
            <div class="detail-row" style="border-bottom: none; margin-top: 10px;">
                <span class="detail-label">Amount:</span>
                <span class="amount">GHS {{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated receipt for your records.</p>
            <p>&copy; {{ date('Y') }} Seventh Day Adventist Church. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
