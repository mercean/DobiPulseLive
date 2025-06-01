<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => "btn btn-{$theme}"])); ?>>
    <?php if(isset($icon)): ?> <i class="<?php echo e($icon); ?>"></i> <?php endif; ?>
    <?php if(isset($label)): ?> <?php echo e($label); ?> <?php endif; ?>
</button>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\resources\views\components\form\button.blade.php ENDPATH**/ ?>