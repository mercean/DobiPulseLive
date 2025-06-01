

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Transaction History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price (RM)</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($order->id); ?></td>
                        <td>RM<?php echo e($order->total_amount); ?></td>

                        <td><?php echo e($order->status); ?></td>
                        <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\dashboard\transactions.blade.php ENDPATH**/ ?>