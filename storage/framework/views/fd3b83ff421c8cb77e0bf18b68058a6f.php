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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Negotiation Center</h2>
            <?php if($openCount > 0): ?>
                <span class="badge badge-warning text-sm"><?php echo e($openCount); ?> open</span>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $negotiations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $negotiation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card hover:shadow-md transition">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-900"><?php echo e($negotiation->request?->event?->title ?? 'Event N/A'); ?></h3>
                                <span class="badge badge-<?php echo e($negotiation->status === 'open' ? 'warning' : ($negotiation->status === 'accepted' ? 'success' : 'danger')); ?> text-xs capitalize"><?php echo e($negotiation->status); ?></span>
                            </div>
                            <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                                <span>Initiated by <?php echo e($negotiation->initiator?->name ?? 'System'); ?></span>
                                <?php if($negotiation->current_offer): ?>
                                    <span class="font-medium text-gray-700">₹<?php echo e(number_format($negotiation->current_offer)); ?></span>
                                <?php endif; ?>
                                <span><?php echo e($negotiation->rounds->count()); ?> round(s)</span>
                                <?php if($negotiation->expires_at): ?>
                                    <span>Expires <?php echo e($negotiation->expires_at->format('M d, Y')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?php echo e(route('sponsor.negotiations.show', $negotiation)); ?>" class="btn-outline text-sm px-3 py-1.5 ml-3">View Negotiation</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-12 text-center">
                <p class="text-gray-500">No negotiations yet.</p>
                <p class="text-sm text-gray-400 mt-1">Negotiations appear here once an organizer responds to your sponsorship request.</p>
            </div>
        <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/negotiations/index.blade.php ENDPATH**/ ?>