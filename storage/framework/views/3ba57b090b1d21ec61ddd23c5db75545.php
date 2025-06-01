<?php $navbarItemHelper = app('JeroenNoten\LaravelAdminLte\Helpers\NavbarItemHelper'); ?>

<?php if($navbarItemHelper->isSubmenu($item)): ?>

    
    <?php echo $__env->make('adminlte::partials.navbar.dropdown-item-submenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php elseif($navbarItemHelper->isLink($item)): ?>

    
    <?php echo $__env->make('adminlte::partials.navbar.dropdown-item-link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\vendor\jeroennoten\laravel-adminlte\resources\views\partials\navbar\dropdown-item.blade.php ENDPATH**/ ?>