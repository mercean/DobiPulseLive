<?php ($setErrorsBag($errors ?? null)); ?>



<?php $__env->startSection('input_group_item'); ?>

    
    <textarea id="<?php echo e($id); ?>" name="<?php echo e($name); ?>"
        <?php echo e($attributes->merge(['class' => $makeItemClass()])); ?>

    ><?php echo e($getOldValue($errorKey, $slot)); ?></textarea>

<?php $__env->stopSection(true); ?>



<?php $__env->startPush('js'); ?>
<script>

    $(() => {
        let usrCfg = <?php echo json_encode($config, 15, 512) ?>;

        // Check for placeholder attribute.

        <?php if(isset($attributes['placeholder'])): ?>
            usrCfg['placeholder'] = "<?php echo e($attributes['placeholder']); ?>";
        <?php endif; ?>

        // Initialize the plugin.

        $('#<?php echo e($id); ?>').summernote(usrCfg);

        // Check for disabled attribute.

        <?php if(isset($attributes['disabled'])): ?>
            $('#<?php echo e($id); ?>').summernote('disable');
        <?php endif; ?>
    })

</script>
<?php $__env->stopPush(); ?>




<?php if (! $__env->hasRenderedOnce('2774b22a-dbf4-4c74-abd3-8cf40b24f733')): $__env->markAsRenderedOnce('2774b22a-dbf4-4c74-abd3-8cf40b24f733'); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">

    
    .input-group-sm .note-editor {
        font-size: .875rem;
        line-height: 1;
    }

    
    .input-group-lg .note-editor {
        font-size: 1.25rem;
        line-height: 1.5;
    }

    

    .adminlte-invalid-itegroup .note-editor {
        box-shadow: 0 .25rem 0.5rem rgba(0,0,0,.25);
        border-color: #dc3545 !important;
    }

</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('adminlte::components.form.input-group-component', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\resources\views\components\form\text-editor.blade.php ENDPATH**/ ?>