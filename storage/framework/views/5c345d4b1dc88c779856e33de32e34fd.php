<?php ($setErrorsBag($errors ?? null)); ?>



<?php $__env->startSection('input_group_item'); ?>

    
    <select id="<?php echo e($id); ?>" name="<?php echo e($name); ?>"
        <?php echo e($attributes->merge(['class' => $makeItemClass()])); ?>>
        <?php echo e($slot); ?>

    </select>

<?php $__env->stopSection(true); ?>



<?php if($errors->any() && $enableOldSupport): ?>
<?php $__env->startPush('js'); ?>
<script>

    $(() => {

        let oldOptions = <?php echo json_encode(collect($getOldValue($errorKey)), 15, 512) ?>;

        $('#<?php echo e($id); ?> option').each(function()
        {
            let value = $(this).val() || $(this).text();
            $(this).prop('selected', oldOptions.includes(value));
        });
    });

</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('adminlte::components.form.input-group-component', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\src/../resources/views/components/form/select.blade.php ENDPATH**/ ?>