<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DobiPulse Receipt</title>
    <style>
        /* ... (your existing CSS) ... */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>DobiPulse Receipt</h2>
            <p>Order ID: <strong><?php echo e($order->order_number ?? 'ORD-' . $order->id); ?></strong></p>
            <p>Date: <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
        </div>

        <div class="section">
            <div class="section-title">Order Summary</div>
            <div class="row"><span>Status:</span><span><?php echo e(ucfirst($order->status)); ?></span></div>
            <div class="row"><span>Type:</span><span><?php echo e($order->type); ?></span></div>
            <div class="row"><span>Total Price:</span><span>RM <?php echo e(number_format($order->total_amount, 2)); ?></span></div>
            <div class="row"><span>Loyalty Points:</span><span><?php echo e($userPoints); ?> pts</span></div>
        </div>

        <?php if($order->machine): ?>
        <div class="section">
            <div class="section-title">Machine Details</div>
            <div class="row"><span>Machine #:</span><span><?php echo e($order->machine->id); ?></span></div>
            <div class="row"><span>Type:</span><span><?php echo e(ucfirst($order->machine->type)); ?></span></div>
            <div class="row"><span>Location:</span><span><?php echo e($order->machine->location); ?></span></div>
        </div>
        <?php endif; ?>

        <div class="footer">
            Thank you for choosing DobiPulse. Contact us via WhatsApp if you need assistance.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/pdf/receipt.blade.php ENDPATH**/ ?>