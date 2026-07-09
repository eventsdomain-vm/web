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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Campaigns</h2>
            <span class="text-sm text-gray-500"><?php echo e(method_exists($campaigns, 'total') ? $campaigns->total() : $campaigns->count()); ?> total</span>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6">
        <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-4 p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="<?php echo e(route('sponsor.campaigns.show', $campaign)); ?>" class="font-semibold text-gray-900 hover:text-terracotta-500"><?php echo e($campaign->event?->title ?? 'Untitled Campaign'); ?></a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>Budget: ₹<?php echo e(number_format($campaign->budget)); ?></span>
                            <span>Spent: ₹<?php echo e(number_format($campaign->spent)); ?></span>
                            <span>Reach: <?php echo e(number_format($campaign->actual_reach ?? 0)); ?></span>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 rounded-full h-2 max-w-[200px]">
                                <div class="bg-terracotta-500 h-2 rounded-full" style="width: <?php echo e($campaign->progress); ?>%"></div>
                            </div>
                            <span class="text-xs text-gray-500"><?php echo e($campaign->progress); ?>%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-<?php echo e($campaign->status === 'active' ? 'success' : ($campaign->status === 'paused' ? 'warning' : 'gray')); ?>"><?php echo e(ucfirst($campaign->status)); ?></span>
                        <a href="<?php echo e(route('sponsor.campaigns.show', $campaign)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">
                <p class="mb-2">No campaigns yet.</p>
                <a href="<?php echo e(route('sponsor.events.index')); ?>" class="text-terracotta-500 hover:underline">Browse events to start a sponsorship</a>
            </div>
        <?php endif; ?>
        <?php if(method_exists($campaigns, 'links')): ?><?php echo e($campaigns->links()); ?><?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/campaigns/index.blade.php ENDPATH**/ ?>