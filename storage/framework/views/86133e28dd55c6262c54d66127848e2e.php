

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">📋 Bulk Orders Management</h1>

    <!-- Filter -->
    <form method="GET" action="<?php echo e(route('admin.bulkOrders')); ?>" class="max-w-md mx-auto mb-8">
        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Filter by Status
        </label>
        <div class="flex items-center space-x-2">
            <select name="status" id="status" class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600">
                <option value="">All Statuses</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                <option value="finished" <?php echo e(request('status') == 'finished' ? 'selected' : ''); ?>>Finished</option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
                Filter
            </button>
        </div>
    </form>

    <!-- Orders Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-700 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3">Order ID</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Action</th>
                    <th class="px-4 py-3">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-gray-700">
                <?php $__currentLoopData = $bulkOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulkOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-4 py-2 font-medium"><?php echo e($bulkOrder->id); ?></td>
                    <td class="px-4 py-2"><?php echo e($bulkOrder->user->name); ?></td>
                    <td class="px-4 py-2 capitalize"><?php echo e($bulkOrder->status); ?></td>
                    <td class="px-4 py-2">$<?php echo e(number_format($bulkOrder->price, 2)); ?></td>
                    <td class="px-4 py-2">
                        <form action="<?php echo e(route('admin.updateOrderStatus', ['id' => $bulkOrder->id, 'type' => 'bulkOrder'])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="flex space-x-2 items-center">
                                <select name="status"
                                    class="rounded border px-2 py-1 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                    <option value="pending" <?php echo e($bulkOrder->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="approved" <?php echo e($bulkOrder->status == 'approved' ? 'selected' : ''); ?>>Approved</option>
                                    <option value="processing" <?php echo e($bulkOrder->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                    <option value="finished" <?php echo e($bulkOrder->status == 'finished' ? 'selected' : ''); ?>>Finished</option>
                                </select>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">
                                    Update
                                </button>
                            </div>
                        </form>
                    </td>
                    <td class="px-4 py-2">
                        <a href="<?php echo e(route('admin.viewBulkOrderDetails', $bulkOrder->id)); ?>"
                            class="inline-block bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            View
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\admin\bulkOrders.blade.php ENDPATH**/ ?>