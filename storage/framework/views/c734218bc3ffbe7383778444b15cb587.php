<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 gradient-hero relative items-center justify-center p-12">
            <div class="absolute inset-0 bg-pattern opacity-5"></div>
            <div class="relative z-10 text-center max-w-md">
                <img src="<?php echo e(asset('logo-white.png')); ?>" alt="EventsDomain" class="h-14 w-auto mx-auto mb-8">
                <h2 class="text-3xl font-bold text-white mb-4">Welcome Back</h2>
                <p class="text-white/70 text-lg leading-relaxed">India's B2B Event Sponsorship & Partnership Marketplace</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden flex items-center mb-8">
                    <img src="<?php echo e(asset('logo.png')); ?>" alt="EventsDomain" class="h-8 object-contain">
                </div>

                <div class="mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Sign In</h1>
                    <p class="text-sm text-gray-500">Enter your email and password to sign in!</p>
                </div>



                <?php if(session('status')): ?>
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-5">
                        <div class="input-group">
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                                    placeholder="info@gmail.com"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="input-group" x-data="{ showPassword: false }">
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition pr-11">
                                <span @click="showPassword = !showPassword" class="absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </span>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer select-none" x-data="{ checked: <?php echo e(old('remember') ? 'true' : 'false'); ?> }">
                                <input type="checkbox" name="remember" class="sr-only" @change="checked = !checked" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                <div class="flex h-5 w-5 items-center justify-center rounded-md border transition" :class="checked ? 'border-terracotta-500 bg-terracotta-500' : 'border-gray-300 bg-transparent'">
                                    <svg class="w-3.5 h-3.5 text-white" x-show="checked" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-sm text-gray-600">Keep me logged in</span>
                            </label>
                            <?php if(Route::has('password.request')): ?>
                                <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-medium text-terracotta-600 hover:text-terracotta-700 transition">Forgot password?</a>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="bg-terracotta-500 hover:bg-terracotta-700 shadow-sm hover:shadow-md flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-semibold text-white transition">
                            Sign In
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>" class="font-semibold text-terracotta-600 hover:text-terracotta-700 transition">Sign Up</a>
                </p>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/auth/login.blade.php ENDPATH**/ ?>