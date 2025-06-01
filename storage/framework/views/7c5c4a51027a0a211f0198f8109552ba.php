<?php $__env->startSection('content'); ?>
<div class="relative min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 overflow-hidden">

    <!-- Background Image with Gradient -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/loginback.jpg')); ?>" alt="Laundry Background"
             class="w-full h-full object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-br from-white/70 via-white/50 to-white/20 dark:from-black/70 dark:via-black/50 dark:to-black/20 backdrop-blur-sm"></div>
    </div>

    <!-- Registration Card -->
    <div class="z-10 w-full max-w-md bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-xl px-8 py-10 backdrop-blur-md animate-fade-in">
        <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">📝 Register Account</h1>

        <form action="<?php echo e(route('register')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Full Name -->
            <div>
                <label for="name" class="block mb-1 font-medium">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>"
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                       required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                       required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                       required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                       required>
                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Account Type -->
            <div>
                <label for="account_type" class="block mb-1 font-medium">Account Type</label>
                <select name="account_type" id="account_type"
                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                        required>
                    <option value="regular" <?php echo e(old('account_type') == 'regular' ? 'selected' : ''); ?>>Regular</option>
                    <option value="bulk" <?php echo e(old('account_type') == 'bulk' ? 'selected' : ''); ?>>Bulk</option>
                </select>
            </div>

            <!-- Register Button -->
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition transform hover:scale-[1.02]">
                    ✅ Register
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-700 dark:text-gray-300">
            Already have an account?
            <a href="<?php echo e(route('login')); ?>" class="text-blue-500 hover:underline font-semibold">Login here</a>.
        </p>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out both;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amirs\OneDrive\Documents\DobiPulseV3\resources\views/auth/register.blade.php ENDPATH**/ ?>