<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Relationships</h2> <?php $__env->endSlot(); ?>
    <div class="container-page">
        <div class="card p-4 mb-4 text-sm text-gray-600 bg-blue-50 border border-blue-200 rounded-lg">
            Track and manage sponsor health scores, engagement, and retention.
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('organizer.srm.show', $rel->id)); ?>" class="card p-4 block hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-900"><?php echo e($rel->sponsor?->company_name ?? 'Unknown'); ?></h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php echo e($rel->health_score >= 4 ? 'bg-green-100 text-green-800' : ($rel->health_score >= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                            <?php echo e($rel->health_score ?? 'N/A'); ?>

                        </span>
                    </div>
                    <p class="text-xs text-gray-500">Status: <span class="font-medium"><?php echo e(ucfirst($rel->status ?? 'active')); ?></span></p>
                    <?php if($rel->last_engagement_at): ?>
                        <p class="text-xs text-gray-500">Last engagement: <?php echo e($rel->last_engagement_at->diffForHumans()); ?></p>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="md:col-span-3 text-center py-12 text-gray-400"><p>No sponsor relationships yet.</p></div>
            <?php endif; ?>
        </div>
        <?php echo e($relationships->links()); ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/srm/index.blade.php ENDPATH**/ ?>