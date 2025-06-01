<?php ($setErrorsBag($errors ?? null)); ?>



<?php $__env->startSection('input_group_item'); ?>

    
    <textarea id="<?php echo e($id); ?>" name="<?php echo e($name); ?>"
        <?php echo e($attributes->merge(['class' => $makeItemClass()])); ?>

    ><?php echo e($getOldValue($errorKey, $slot)); ?></textarea>

<?php $__env->stopSection(true); ?>

<?php echo $__env->make('adminlte::components.form.input-group-component', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\resources\views\components\form\textarea.blade.php ENDPATH**/ ?>