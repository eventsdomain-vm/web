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
                <h2 class="text-3xl font-bold text-white mb-4">Verify Your Email</h2>
                <p class="text-white/70 text-lg leading-relaxed">One last step to unlock India's leading B2B event sponsorship marketplace.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-lg">
                <div class="lg:hidden flex items-center mb-8">
                    <img src="<?php echo e(asset('logo.png')); ?>" alt="EventsDomain" class="h-8 object-contain">
                </div>

                <div class="mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Check Your Inbox</h1>
                    <p class="text-sm text-gray-500">We've sent a verification link to your email address. Please click it to activate your account.</p>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-6 flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 text-amber-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Email sent to:</p>
                        <p class="text-sm text-amber-700 mt-0.5 break-all"><?php echo e(auth()->user()->email ?? 'your registered email'); ?></p>
                    </div>
                </div>

                <?php if(session('status') == 'verification-link-sent'): ?>
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <?php echo e(__('A new verification link has been sent to your email address.')); ?>

                    </div>
                <?php endif; ?>

                <div class="space-y-4">
                    <form method="POST" action="<?php echo e(route('verification.send')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-terracotta-500 hover:bg-terracotta-700 shadow-sm hover:shadow-md flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-semibold text-white transition gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Resend Verification Email
                        </button>
                    </form>

                    <div class="relative flex items-center gap-3">
                        <span class="flex-1 border-t border-gray-200"></span>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">or</span>
                        <span class="flex-1 border-t border-gray-200"></span>
                    </div>

                    <a href="<?php echo e(route('otp.notice')); ?>"
                       class="flex w-full items-center justify-center rounded-lg border-2 border-terracotta-200 bg-terracotta-50 px-4 py-3 text-sm font-semibold text-terracotta-700 hover:bg-terracotta-100 transition gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                    </svg>
                        Use OTP Verification
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 transition underline underline-offset-2">
                            <?php echo e(__('Not you? Sign out and try again')); ?>

                        </button>
                    </form>
                </div>
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
<?php /**PATH C:\xampp\htdocs\vm\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>