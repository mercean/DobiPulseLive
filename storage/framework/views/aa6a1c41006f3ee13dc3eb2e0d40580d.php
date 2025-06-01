

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">🔔 All Notifications</h1>

    <form action="<?php echo e(route('notifications.readall')); ?>" method="POST" class="mb-4">
        <?php echo csrf_field(); ?>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ✅ Mark All as Read
        </button>
    </form>

    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 shadow mb-4 rounded p-4 border-l-4 
                    <?php echo e($notification->read_at ? 'border-gray-400' : 'border-blue-600'); ?>">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                <?php echo e($notification->data['title'] ?? 'Notification'); ?>

            </h2>
            <p class="text-gray-600 dark:text-gray-300"><?php echo e($notification->data['body'] ?? '-'); ?></p>
            <p class="text-sm text-gray-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
            <?php if(isset($notification->data['url'])): ?>
                <a href="<?php echo e($notification->data['url']); ?>" class="text-blue-600 text-sm hover:underline">
                    ➡ View
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-center text-gray-500 dark:text-gray-400">You have no notifications.</p>
    <?php endif; ?>

    <div class="mt-6">
        <?php echo e($notifications->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\notifications\index.blade.php ENDPATH**/ ?>