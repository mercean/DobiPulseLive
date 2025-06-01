<?php $__env->startSection('content'); ?>
<div x-data="{ showHistory: false }" class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <?php echo $__env->make('components.regular.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="flex-1 p-6 lg:p-10 space-y-8 container mx-auto">
        <!-- Welcome Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-4">
                <?php if(auth()->check()): ?>
                    <img src="<?php echo e(Auth::user()->avatar 
                                ? asset('storage/' . Auth::user()->avatar) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff&size=80'); ?>" 
                         class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md object-cover">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">
                            Welcome, <?php echo e(Auth::user()->name); ?>

                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Here’s your personalized laundry dashboard.
                        </p>
                    </div>
                <?php else: ?>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">
                            Welcome, Guest
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            You’re checking out as a guest. Please enter your email to receive a receipt.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-2">
            <p class="text-base font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-information-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-blue-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Need to wash or dry clothes? Let’s get started.
            </p>
            <a href="<?php echo e(route('orders.create')); ?>"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow transition">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-plus-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Start a New Laundry Session
            </a>
        </div>

        <?php if(!auth()->check()): ?>
            <form action="<?php echo e(route('guest.email.store')); ?>" method="POST" class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-xl shadow w-full max-w-md">
                <?php echo csrf_field(); ?>
                <label for="guest_email" class="block mb-2 font-medium">Enter your email to receive receipt</label>
                <input type="email" name="guest_email" id="guest_email" placeholder="e.g. guest@example.com"
                       class="w-full px-4 py-2 rounded border dark:border-gray-600 bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                <button type="submit"
                        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Save Email
                </button>
            </form>
        <?php endif; ?>

        <?php if($promos->isNotEmpty()): ?>
            <div class="bg-yellow-100 dark:bg-yellow-800 border-l-4 border-yellow-500 text-yellow-900 dark:text-yellow-100 p-4 mb-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">🎉 Current Promotions</h3>
                <ul class="list-disc pl-5 text-sm">
                    <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="mb-4 list-none">
                            <?php if($promo->promo_image): ?>
                                <img src="<?php echo e(asset('storage/' . $promo->promo_image)); ?>" alt="Promo Image" class="w-full max-h-48 object-cover mb-2 rounded-xl shadow">
                            <?php endif; ?>

                            <strong class="text-lg"><?php echo e($promo->title); ?></strong><br>
                            <span class="text-sm"><?php echo e($promo->description); ?></span><br>
                            <span class="text-xs text-gray-600 dark:text-gray-300">
                                <?php echo e($promo->start_date->format('M d')); ?> - <?php echo e($promo->end_date->format('M d, Y')); ?>

                            </span><br>

                            <?php if($promo->type === 'percent'): ?>
                                <span class="text-green-700 dark:text-green-300 font-semibold"><?php echo e($promo->value); ?>% off</span>
                            <?php else: ?>
                                <span class="text-green-700 dark:text-green-300 font-semibold">RM<?php echo e(number_format($promo->value, 2)); ?> off</span>
                            <?php endif; ?>

                            <?php if($promo->code): ?>
                                <div class="mt-1 text-xs">
                                    Use Code: <span class="bg-white text-black px-2 py-1 rounded font-mono"><?php echo e($promo->code); ?></span>
                                </div>
                            <?php elseif($promo->auto_apply): ?>
                                <div class="mt-1 text-xs text-green-600 dark:text-green-400 font-semibold">Auto Applied at Checkout</div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (isset($component)) { $__componentOriginalb63f174754b9376d0cbcfda0c77a69e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.card','data' => ['title' => 'Orders','value' => $orders->count(),'icon' => 'o-clipboard-document-list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Orders','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($orders->count()),'icon' => 'o-clipboard-document-list']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2)): ?>
<?php $attributes = $__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2; ?>
<?php unset($__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb63f174754b9376d0cbcfda0c77a69e2)): ?>
<?php $component = $__componentOriginalb63f174754b9376d0cbcfda0c77a69e2; ?>
<?php unset($__componentOriginalb63f174754b9376d0cbcfda0c77a69e2); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalb63f174754b9376d0cbcfda0c77a69e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.card','data' => ['title' => 'Total Spent','value' => 'RM' . $orders->sum('total_amount'),'icon' => 'o-banknotes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Spent','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('RM' . $orders->sum('total_amount')),'icon' => 'o-banknotes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2)): ?>
<?php $attributes = $__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2; ?>
<?php unset($__attributesOriginalb63f174754b9376d0cbcfda0c77a69e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb63f174754b9376d0cbcfda0c77a69e2)): ?>
<?php $component = $__componentOriginalb63f174754b9376d0cbcfda0c77a69e2; ?>
<?php unset($__componentOriginalb63f174754b9376d0cbcfda0c77a69e2); ?>
<?php endif; ?>
            <?php if(auth()->check()): ?>
                <?php if (isset($component)) { $__componentOriginal346d62ffe6e01813dafd1c6a832e8f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal346d62ffe6e01813dafd1c6a832e8f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.points','data' => ['points' => $points,'icon' => 'o-star']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.points'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['points' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($points),'icon' => 'o-star']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal346d62ffe6e01813dafd1c6a832e8f84)): ?>
<?php $attributes = $__attributesOriginal346d62ffe6e01813dafd1c6a832e8f84; ?>
<?php unset($__attributesOriginal346d62ffe6e01813dafd1c6a832e8f84); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal346d62ffe6e01813dafd1c6a832e8f84)): ?>
<?php $component = $__componentOriginal346d62ffe6e01813dafd1c6a832e8f84; ?>
<?php unset($__componentOriginal346d62ffe6e01813dafd1c6a832e8f84); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if(auth()->check()): ?>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4"> Profile Summary</h2>
                <div class="flex items-center gap-4">
                    <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" class="w-16 h-16 rounded-full border-4 border-blue-500 shadow-md">
                    <div>
                        <p class="text-lg font-semibold"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><?php echo e(Auth::user()->email); ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="<?php echo e(route('edit.profile')); ?>" class="text-blue-600 hover:underline text-sm">Update Profile Info</a>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Active Orders</h2>
            <?php
                $activeOrders = $orders->filter(fn($o) => in_array($o->status, ['pending', 'processing', 'approved', 'PayNow', 'completed']));
            ?>
            <?php if($activeOrders->isEmpty()): ?>
                <p class="text-gray-500 dark:text-gray-400">No active orders at the moment.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Machine</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-700">
                            <?php $__currentLoopData = $activeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-2"><?php echo e($order->id); ?></td>
                                    <td class="px-4 py-2">#<?php echo e($order->machine_id); ?></td>
                                    <td class="px-4 py-2"><?php echo e($order->required_time); ?> min</td>
                                    <td class="px-4 py-2 capitalize">
                                        <?php echo e($order->status); ?>

                                        <?php if(in_array($order->status, ['approved', 'PayNow']) && $order->end_time): ?>
                                            <br>
                                            <span class="countdown text-yellow-500 text-xs block" data-end-time="<?php echo e($order->end_time->format('Y-m-d\TH:i:s')); ?>">
                                                Loading...
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Transaction History</h2>
                <button @click="showHistory = !showHistory" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 rounded-lg">
                    <span x-text="showHistory ? 'Hide History' : 'Show History'"></span>
                </button>
            </div>
            <div x-show="showHistory" x-transition>
                <?php if($orders->isEmpty()): ?>
                    <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-2">Order ID</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-2"><?php echo e($order->id); ?></td>
                                        <td class="px-4 py-2">RM<?php echo e(number_format($order->total_amount, 2)); ?></td>
                                        <td class="px-4 py-2"><?php echo e(ucfirst($order->status)); ?></td>
                                        <td class="px-4 py-2"><?php echo e($order->created_at->format('d M Y')); ?></td>
                                        <td class="px-4 py-2">
                                            <?php if($order->status === 'pending'): ?>
                                                <a href="<?php echo e(route('payment.regular.page', ['order' => $order->id])); ?>"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Pay Now
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('receipt.download', $order->id)); ?>"
                                                class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-arrow-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                    Receipt
                                                </a>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.countdown').forEach(span => {
            const endTime = new Date(span.dataset.endTime).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    span.innerText = "Completed";
                    span.classList.remove("text-yellow-500");
                    span.classList.add("text-green-500");
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                span.innerText = `${minutes}m ${seconds}s left`;

                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\dashboard\regular.blade.php ENDPATH**/ ?>