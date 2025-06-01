<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['orders']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['orders']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<section class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow transition duration-300 mb-8">
    <h2 class="text-xl font-semibold mb-4">🧾 Transaction History</h2>

    <?php if($orders->isEmpty()): ?>
        <p class="text-gray-600 dark:text-gray-300">No transactions found.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-600">
                        <th>Order ID</th>
                        <th>Total Price (RM)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td><?php echo e($order->id); ?></td>
                            <td>RM<?php echo e($order->total_amount); ?></td>
                            <td><?php echo e(ucfirst($order->status)); ?></td>
                            <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="<?php echo e(url('/orders/new')); ?>" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Order</a>
</section>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\components\dashboard\transaction-table.blade.php ENDPATH**/ ?>