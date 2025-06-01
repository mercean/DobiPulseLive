

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Bulk Order Details</h2>

        <!-- Display User Name on Top -->
        <h3 class="text-xl font-medium mb-4">User: <?php echo e($bulkOrder->user->name); ?></h3>

        <div class="admin-dashboard-card mb-6">
            <h3 class="mb-4">Order ID: <?php echo e($bulkOrder->id); ?></h3>

            <div class="mb-4">
                <strong>Load Arrival Date:</strong> <?php echo e($bulkOrder->load_arrival_date); ?>

            </div>

            <div class="mb-4">
                <strong>Load Arrival Time:</strong> <?php echo e($bulkOrder->load_arrival_time); ?>

            </div>

            <div class="mb-4">
                <strong>Pickup Date:</strong> <?php echo e($bulkOrder->pickup_date); ?>

            </div>

            <div class="mb-4">
                <strong>Pickup Time:</strong> <?php echo e($bulkOrder->pickup_time); ?>

            </div>

            <div class="mb-4">
                <strong>Cloth Type:</strong> <?php echo e($bulkOrder->cloth_type); ?> <!-- Added Cloth Type -->
            </div>

            <div class="mb-4">
                <strong>Load (Kg):</strong> <?php echo e($bulkOrder->load_kg); ?> <!-- Added Load in Kg -->
            </div>

            <div class="mb-4">
                <strong>Created At:</strong> <?php echo e($bulkOrder->created_at); ?>

            </div>

            <div class="mb-4">
                <strong>Updated At:</strong> <?php echo e($bulkOrder->updated_at); ?>

            </div>

            <!-- Optionally, you can add more details here -->
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/admin/bulkOrderDetails.blade.php ENDPATH**/ ?>