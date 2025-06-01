

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto py-12 text-center text-gray-800 dark:text-white">
    <h1 class="text-2xl font-bold mb-4">✅ Payment Successful</h1>
    <p class="mb-6">Thank you for your payment! Your order has been received.</p>

    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4 text-left">
            <p><strong>Order ID:</strong> <?php echo e($order->id); ?></p>
            <p><strong>Machine:</strong> <?php echo e($order->machine_id); ?></p>
            <p><strong>Amount Paid:</strong> RM <?php echo e(number_format($order->final_price, 2)); ?></p>
            <p><strong>Status:</strong> <?php echo e(ucfirst($order->status)); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/payment/guest_success.blade.php ENDPATH**/ ?>