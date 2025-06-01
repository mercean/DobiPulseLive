<?php $__env->startComponent('mail::message'); ?>
# Bulk Order Receipt

Hi <?php echo e($order->user->name); ?>,

Your bulk laundry order has been paid successfully.

---

**Order ID:** <?php echo e($order->id); ?>  
**Cloth Type:** <?php echo e($order->cloth_type); ?>  
**Weight:** <?php echo e($order->load_kg); ?> kg  
**Drop-off:** <?php echo e($order->load_arrival_date); ?> at <?php echo e($order->load_arrival_time); ?>  
**Pickup:** <?php echo e($order->pickup_date); ?> at <?php echo e($order->pickup_time); ?>  
**Total Paid:** MYR <?php echo e(number_format($order->price, 2)); ?>  

---

<?php $__env->startComponent('mail::button', ['url' => route('bulk.orders.index')]); ?>
View My Orders
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
DobiPulse Team
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\emails\bulk\receipt.blade.php ENDPATH**/ ?>