<div class="max-w-xl mx-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-md p-6 print:p-0 print:shadow-none print:border-0 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
    <div class="text-center mb-4">
        <?php echo $__env->yieldPushContent('receipt-icon'); ?>
        <h2 class="text-2xl font-bold mb-1">DobiPulse Receipt</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Order ID: <strong><?php echo e($order->order_number ?? 'ORD-' . ($order->id ?? 'Unknown')); ?></strong><br>
            Date: <?php echo e($order->created_at?->format('d M Y, h:i A') ?? 'N/A'); ?>

        </p>
    </div>

    <div class="border-t border-b py-4 text-sm space-y-2">
        <div class="flex justify-between">
            <span>Status:</span>
            <span><?php echo e(ucfirst($order->status ?? 'Unknown')); ?></span>
        </div>
        <div class="flex justify-between">
            <span>Type:</span>
            <span><?php echo e($order->type ?? 'N/A'); ?></span>
        </div>
        <div class="flex justify-between">
            <span>Total Price:</span>
            <span>RM <?php echo e(number_format($order->total_amount ?? 0, 2)); ?></span>
        </div>
        <div class="flex justify-between">
            <span>Loyalty Points:</span>
            <span><?php echo e($userPoints ?? 0); ?> pts</span>
        </div>
    </div>

    <?php if(!empty($order->machine)): ?>
        <div class="mt-4 text-sm">
            <div class="font-semibold mb-1">Machine Used</div>
            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded">
                Machine #<?php echo e($order->machine->id ?? '-'); ?> – <?php echo e(ucfirst($order->machine->type ?? '-')); ?> @ <?php echo e($order->machine->location ?? '-'); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="text-center text-xs text-gray-500 dark:text-gray-400 mt-6 border-t pt-3">
        Thank you for choosing DobiPulse. Contact us anytime.
    </div>
</div>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\components\regular\order-receipt.blade.php ENDPATH**/ ?>