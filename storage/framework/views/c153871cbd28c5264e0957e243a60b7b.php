<?php ($setErrorsBag($errors ?? null)); ?>



<?php $__env->startSection('input_group_item'); ?>

    
    <input id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" data-target="#<?php echo e($id); ?>" data-toggle="datetimepicker"
        <?php echo e($attributes->merge(['class' => $makeItemClass()])); ?>>

<?php $__env->stopSection(true); ?>



<?php $__env->startPush('js'); ?>
<script>

    $(() => {
        let usrCfg = _AdminLTE_InputDate.parseCfg( <?php echo json_encode($config, 15, 512) ?> );
        $('#<?php echo e($id); ?>').datetimepicker(usrCfg);

        // Add support to auto display the old submitted value or values in case
        // of validation errors.

        let value = <?php echo json_encode($getOldValue($errorKey, $attributes->get('value')), 512) ?>;
        $('#<?php echo e($id); ?>').val(value || "");
    })

</script>
<?php $__env->stopPush(); ?>



<?php if (! $__env->hasRenderedOnce('192816bc-ece2-437c-b1b7-4472a2fb3494')): $__env->markAsRenderedOnce('192816bc-ece2-437c-b1b7-4472a2fb3494'); ?>
<?php $__env->startPush('js'); ?>
<script>

    class _AdminLTE_InputDate {

        /**
         * Parse the php plugin configuration and eval the javascript code.
         *
         * cfg: A json with the php side configuration.
         */
        static parseCfg(cfg)
        {
            for (const prop in cfg) {
                let v = cfg[prop];

                if (typeof v === 'string' && v.startsWith('js:')) {
                    cfg[prop] = eval(v.slice(3));
                } else if (typeof v === 'object') {
                    cfg[prop] = _AdminLTE_InputDate.parseCfg(v);
                }
            }

            return cfg;
        }
    }

</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('adminlte::components.form.input-group-component', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\resources\views\components\form\input-date.blade.php ENDPATH**/ ?>