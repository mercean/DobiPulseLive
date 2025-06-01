

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto py-12 text-center text-gray-800 dark:text-white">
    <h1 class="text-2xl font-bold mb-4">🧾 Guest Payment</h1>
    <p class="mb-6">You are paying as a guest. Please complete the payment below.</p>

    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4 text-left">
            <p><strong>Order ID:</strong> <?php echo e($order->id); ?></p>
            <p><strong>Machine:</strong> <?php echo e($order->machine_id); ?></p>
            <p><strong>Amount:</strong> RM <?php echo e(number_format($order->total_amount, 2)); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <form id="payment-form" class="mt-6">
        <div id="card-element" class="p-4 border border-gray-300 rounded bg-white dark:bg-gray-900"></div>
        <button id="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded">Pay Now</button>
        <div id="payment-message" class="mt-4 text-sm text-red-500"></div>
    </form>
</div>

<!-- Stripe Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const stripe = Stripe("<?php echo e(config('services.stripe.key')); ?>");

        // 👇 Get client secret from your initiate endpoint (optional: pass it from controller)
        const response = await fetch("<?php echo e(route('payment.guest.initiate')); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
            },
            body: JSON.stringify({
                order_ids: "<?php echo e(request()->order_ids); ?>",
                guest_email: "<?php echo e(session('guest_email')); ?>"
            }),
        });

        const { clientSecret } = await response.json();

        const elements = stripe.elements();
        const card = elements.create("card");
        card.mount("#card-element");

        const form = document.getElementById("payment-form");
        const message = document.getElementById("payment-message");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card,
                }
            });

            if (error) {
                message.textContent = error.message;
            } else if (paymentIntent.status === "succeeded") {
                window.location.href = "<?php echo e(route('payment.guest.success')); ?>?order_ids=<?php echo e(request()->order_ids); ?>";
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/payment/guest_multi.blade.php ENDPATH**/ ?>