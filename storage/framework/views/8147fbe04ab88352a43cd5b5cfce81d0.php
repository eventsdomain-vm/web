<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <?php echo e(__('GST Details')); ?>

        </h2>
        <p class="mt-1 text-sm text-gray-600">
            <?php echo e(__('Add your GSTIN to apply GST on invoices and enable tax-compliant checkout.')); ?>

        </p>
    </header>

    <?php $profile = auth()->user()->profile; ?>

    <?php if(session('status') === 'gst-verified'): ?>
        <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-lg p-3 text-sm">
            GSTIN verified successfully<?php echo e($profile?->gst_legal_name ? ' — '.$profile->gst_legal_name : ''); ?>.
        </div>
    <?php elseif(session('status') === 'gst-saved-unverified'): ?>
        <div class="mt-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3 text-sm">
            GSTIN saved — pending verification. Use the <strong>Verify Now</strong> button below to re-attempt verification.
            <?php if(session('gst_reason') && !str_contains(session('gst_reason'), 'not configured')): ?>
                <br><span class="text-xs opacity-75"><?php echo e(session('gst_reason')); ?></span>
            <?php endif; ?>
        </div>
    <?php elseif(session('status') === 'gst-invalid'): ?>
        <div class="mt-4 bg-red-50 border border-red-200 text-red-800 rounded-lg p-3 text-sm">
            <?php echo e(session('gst_reason') ?? 'Invalid GSTIN.'); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('profile.gst.update')); ?>" class="mt-6 space-y-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'gst_number','value' => __('GSTIN')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'gst_number','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('GSTIN'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'gst_number','name' => 'gst_number','type' => 'text','maxlength' => '15','class' => 'mt-1 block w-full uppercase','value' => old('gst_number', $profile?->gst_number),'placeholder' => '27AAPFU0939F1ZV']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gst_number','name' => 'gst_number','type' => 'text','maxlength' => '15','class' => 'mt-1 block w-full uppercase','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('gst_number', $profile?->gst_number)),'placeholder' => '27AAPFU0939F1ZV']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $errors->get('gst_number')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('gst_number'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>

            <?php if($profile?->gst_number): ?>
                <p class="mt-2 text-sm">
                    Status:
                    <?php if($profile->gst_verified): ?>
                        <span class="badge badge-green">Verified</span>
                        <?php if($profile->gst_verified_at): ?>
                            <span class="text-gray-400 text-xs">on <?php echo e($profile->gst_verified_at->format('M d, Y')); ?></span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge badge-yellow">Not verified</span>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-4">
            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Save & Verify')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
        </div>
    </form>

    <?php if($profile?->gst_number && !$profile->gst_verified): ?>
        <form method="POST" action="<?php echo e(route('profile.gst.update')); ?>" class="mt-3">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="gst_number" value="<?php echo e($profile->gst_number); ?>">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-amber-500 rounded-xl shadow hover:bg-amber-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Verify Now
            </button>
        </form>
    <?php endif; ?>
</section>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/profile/partials/update-gst-form.blade.php ENDPATH**/ ?>