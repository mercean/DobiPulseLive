

<?php $__env->startSection('content'); ?>
<div class="flex justify-center min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <div class="w-full max-w-2xl p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-10 space-y-8">

        <!-- Title -->
        <div class="flex items-center justify-center space-x-2 text-2xl font-bold text-gray-800 dark:text-white">
            <i data-lucide="archive" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            <span>Create Bulk Order</span>
        </div>

        <!-- Validation Errors -->
        <?php if($errors->any()): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded space-y-2">
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Bulk Order Form -->
        <form action="<?php echo e(route('bulk.orders.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Cloth Type -->
            <div>
                <label for="cloth_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cloth Type</label>
                <input type="text" name="cloth_type" id="cloth_type"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="e.g., Bedsheets, Towels" required>
            </div>

            <!-- Load (kg) -->
            <div>
                <label for="load_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Load (kg)</label>
                <input type="number" name="load_kg" id="load_kg" step="0.1"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="e.g., 5.5" required>
            </div>

            <!-- Arrival Date & Time -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="load_arrival_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Date</label>
                    <input type="date" name="load_arrival_date" id="load_arrival_date"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
                <div>
                    <label for="load_arrival_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Time</label>
                    <input type="time" name="load_arrival_time" id="load_arrival_time"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
            </div>

            <!-- Pickup Date & Time -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="pickup_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Date</label>
                    <input type="date" name="pickup_date" id="pickup_date"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
                <div>
                    <label for="pickup_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Time</label>
                    <input type="time" name="pickup_time" id="pickup_time"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    Submit Order
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    lucide.createIcons();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/bulk_orders/create.blade.php ENDPATH**/ ?>