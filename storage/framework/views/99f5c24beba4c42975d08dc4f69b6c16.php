<?php ($isGuestPage = true); ?>


<?php $__env->startSection('content'); ?>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white overflow-hidden py-24">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-md"></div>
    <div class="relative z-10 container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">

        <!-- Left: Text -->
        <div class="lg:w-1/2 text-center lg:text-left">
            <h1 class="text-5xl font-extrabold text-white leading-tight mb-4">
                Welcome to <span class="text-blue-400">DobiPulse</span>
            </h1>
            <p class="text-lg text-gray-300 mb-6">Smarter laundry, better rewards.<br>Scan. Pay. Track.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="<?php echo e(route('register')); ?>?type=regular"
                class="px-6 py-3 rounded-xl font-semibold text-white bg-white/10 hover:bg-white/20 ring-1 ring-white/20 backdrop-blur-md shadow transition-all duration-300 hover:scale-105">
                    👤 Regular Customer
                </a>
                <a href="<?php echo e(route('register')); ?>?type=bulk"
                class="px-6 py-3 rounded-xl font-semibold text-white bg-white/10 hover:bg-white/20 ring-1 ring-white/20 backdrop-blur-md shadow transition-all duration-300 hover:scale-105">
                    🏢 Business User
                </a>
            </div>

        </div>

        <!-- Right: Washing Machine -->
        <div class="lg:w-1/2 w-full flex justify-center">
            <img src="<?php echo e(asset('images/WASH.png')); ?>" alt="Washing Machine" class="max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg drop-shadow-2xl">
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="bg-gradient-to-br from-slate-800 to-slate-900 text-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">How DobiPulse Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white/10 border border-white/10 backdrop-blur-sm p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-camera'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-10 h-10 text-blue-400 mx-auto mb-3']); ?>
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
                <h3 class="text-xl font-semibold mb-2">Scan & Start</h3>
                <p class="text-gray-300">Scan QR codes to begin a laundry session.</p>
            </div>
            <div class="bg-white/10 border border-white/10 backdrop-blur-sm p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-10 h-10 text-yellow-400 mx-auto mb-3']); ?>
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
                <h3 class="text-xl font-semibold mb-2">Earn Rewards</h3>
                <p class="text-gray-300">Collect points and redeem them for free washes or discounts.</p>
            </div>
            <div class="bg-white/10 border border-white/10 backdrop-blur-sm p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-10 h-10 text-pink-400 mx-auto mb-3']); ?>
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
                <h3 class="text-xl font-semibold mb-2">Real-time Updates</h3>
                <p class="text-gray-300">Get notified instantly when your laundry is ready.</p>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="bg-gray-100 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2">
            <img src="<?php echo e(asset('images/mainpagebanner.jpg')); ?>" alt="About Us" class="rounded-lg shadow-lg w-full">
        </div>
        <div class="w-full md:w-1/2 bg-white dark:bg-gray-800 p-8 rounded-xl shadow">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Digitally Transforming Laundromats</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                <li>🚀 QR-based service activation</li>
                <li>🏅 Rewards and loyalty system</li>
                <li>📦 Bulk order logic with auto-pricing</li>
                <li>📊 Admin dashboard with real-time analytics</li>
            </ul>
        </div>
    </div>
</section>

<!-- WHY DOBIPULSE -->
<section class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-900 py-20">
    <div class="container mx-auto text-center px-6">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Why Choose DobiPulse?</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
            We optimize laundromat operations while offering customers a modern, rewarding, and effortless experience.
        </p>
        <a href="<?php echo e(route('login')); ?>"
        class="inline-block px-8 py-3 rounded-xl font-semibold text-white bg-white/10 hover:bg-white/20 ring-1 ring-white/20 backdrop-blur-md shadow transition-all duration-300 hover:scale-105">
            🚀 Try It Now

        </a>
    </div>
</section>

<!-- DASHBOARD PREVIEW -->
<section class="bg-gray-100 dark:bg-gray-900 py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Inside the Regular Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <div class="text-5xl mb-4">📋</div>
                <h3 class="text-xl font-semibold mb-2">Order History</h3>
                <p class="text-gray-600 dark:text-gray-300">Quickly access your wash records and QR logs.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <div class="text-5xl mb-4">⭐</div>
                <h3 class="text-xl font-semibold mb-2">Loyalty Tracker</h3>
                <p class="text-gray-600 dark:text-gray-300">See earned points and available rewards at a glance.</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow hover:scale-[1.02] transition">
                <div class="text-5xl mb-4">💳</div>
                <h3 class="text-xl font-semibold mb-2">Payments</h3>
                <p class="text-gray-600 dark:text-gray-300">E-wallet & Stripe support. Seamless and secure.</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views\layouts\main.blade.php ENDPATH**/ ?>