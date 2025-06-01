<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'value',
    'color' => 'text-blue-600 dark:text-blue-400',
]));

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

foreach (array_filter(([
    'title',
    'value',
    'color' => 'text-blue-600 dark:text-blue-400',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200"><?php echo e($title); ?></h2>
    <p class="text-3xl font-bold <?php echo e($color); ?> mt-2"><?php echo e($value); ?></p>
</div>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\components\admin\stat-card.blade.php ENDPATH**/ ?>