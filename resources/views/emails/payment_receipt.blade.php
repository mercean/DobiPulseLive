<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <tr>
            <td style="padding: 20px;">
                <h2 style="color: #2b6cb0;">Hello {{ $order->user->name ?? 'Guest' }},</h2>
                <p style="font-size: 16px;">Thank you for your payment. Here is your receipt:</p>

                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                    <tr>
                        <td style="padding: 8px 0;"><strong>Order ID:</strong></td>
                        <td style="padding: 8px 0;">#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Order Date:</strong></td>
                        <td style="padding: 8px 0;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Machine ID:</strong></td>
                        <td style="padding: 8px 0;">{{ $order->machine_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Required Time:</strong></td>
                        <td style="padding: 8px 0;">{{ $order->required_time }} minutes</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Total Paid:</strong></td>
                        <td style="padding: 8px 0;">RM{{ number_format($order->final_price ?? $order->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Status:</strong></td>
                        <td style="padding: 8px 0;">{{ ucfirst($order->status) }}</td>
                    </tr>
                </table>

                <p style="margin-top: 30px;">We appreciate your business!</p>
                <p style="color: #888;">— The DobiPulse Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
