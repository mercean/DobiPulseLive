

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto mt-10 bg-white dark:bg-gray-800 shadow p-6 rounded-lg text-center">
    <h2 class="text-2xl font-bold text-green-600 mb-4">🎉 Redemption Successful!</h2>

    <p class="text-lg text-gray-800 dark:text-white mb-2">
        You’ve redeemed: <strong><?php echo e($reward->title); ?></strong>
    </p>

    <p class="text-sm text-gray-500 dark:text-gray-400">Use the following coupon code during checkout:</p>

    <div class="text-3xl font-mono bg-gray-100 dark:bg-gray-700 px-6 py-3 rounded-lg text-blue-600 dark:text-white mt-4 tracking-widest">
        <?php echo e($coupon->code); ?>

    </div>

    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">* Valid for one-time use only</p>

    <div class="mt-6">
    <a href="<?php echo e(route('redeem_catalog')); ?>" class="btn">Back to Catalog</a>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/Regular/receipt.blade.php ENDPATH**/ ?>