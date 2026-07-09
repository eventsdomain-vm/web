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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contracts</h2>
            <span class="text-sm text-gray-500"><?php echo e(method_exists($contracts, 'total') ? $contracts->total() : $contracts->count()); ?> total</span>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6">
        <?php $__empty_1 = true; $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-4 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="<?php echo e(route('sponsor.contracts.show', $contract)); ?>" class="font-semibold text-gray-900 hover:text-terracotta-500"><?php echo e($contract->title ?? $contract->contract_number ?? 'Contract #'.$contract->id); ?></a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span><?php echo e($contract->event?->title); ?></span>
                            <span>₹<?php echo e(number_format($contract->amount)); ?></span>
                            <?php if($contract->start_date): ?><span><?php echo e($contract->start_date->format('M d, Y')); ?> - <?php echo e($contract->end_date?->format('M d, Y') ?? 'Ongoing'); ?></span><?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-<?php echo e($contract->status_color); ?>"><?php echo e($contract->status_label); ?></span>
                        <a href="<?php echo e(route('sponsor.contracts.show', $contract)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No contracts yet.</div>
        <?php endif; ?>
        <?php if(method_exists($contracts, 'links')): ?><?php echo e($contracts->links()); ?><?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/contracts/index.blade.php ENDPATH**/ ?>