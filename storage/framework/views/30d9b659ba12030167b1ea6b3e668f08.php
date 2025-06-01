<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value']));

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

foreach (array_filter((['title', 'value']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center transition duration-300">
    <h3 class="text-lg font-semibold mb-2"><?php echo e($title); ?></h3>
    <p class="text-3xl font-bold"><?php echo e($value); ?></p>
</div>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\components\dashboard\card.blade.php ENDPATH**/ ?>