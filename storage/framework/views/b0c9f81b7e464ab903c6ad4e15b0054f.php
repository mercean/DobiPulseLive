

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-clipboard-document-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-blue-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            Transaction History
        </h1>

        <a href="<?php echo e(route('admin.exportTransactionHistory')); ?>"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow transition">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-arrow-down-tray'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            Export CSV
        </a>
    </div>

    <!-- Transaction History Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Method</th>
                    <th class="px-4 py-3">Order ID</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 font-medium"><?php echo e($transaction->id); ?></td>
                        <td class="px-4 py-3">RM<?php echo e(number_format($transaction->amount / 100, 2)); ?></td>
                        <td class="px-4 py-3 capitalize"><?php echo e($transaction->status); ?></td>
                        <td class="px-4 py-3">
                            <?php if(isset($transaction->payment_method_details->card)): ?>
                                <?php echo e(ucfirst($transaction->payment_method_details->card->brand)); ?>

                            <?php else: ?>
                                <span class="text-gray-400">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3"><?php echo e($transaction->metadata['order_id'] ?? 'N/A'); ?></td>
                        <td class="px-4 py-3"><?php echo e(\Carbon\Carbon::createFromTimestamp($transaction->created)->toDateString()); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            No transactions found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\admin\transactionHistory.blade.php ENDPATH**/ ?>