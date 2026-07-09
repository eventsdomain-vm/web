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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deal Pipeline</h2>
            <a href="<?php echo e(route('sponsor.proposals.index')); ?>" class="btn-outline text-sm px-3 py-1.5">View All Proposals</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="overflow-x-auto pb-4">
        <div class="flex gap-4 min-w-[900px]">
            <?php
                $columnConfig = [
                    'discovery' => ['label' => 'Discovery', 'color' => 'gray'],
                    'interest' => ['label' => 'Interest', 'color' => 'blue'],
                    'proposal' => ['label' => 'Proposal', 'color' => 'yellow'],
                    'negotiation' => ['label' => 'Negotiation', 'color' => 'orange'],
                    'closed_won' => ['label' => 'Closed Won', 'color' => 'green'],
                    'closed_lost' => ['label' => 'Closed Lost', 'color' => 'red'],
                ];
            ?>

            <?php $__currentLoopData = $columnConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex-1 min-w-[140px]">
                    <div class="card mb-3">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-sm text-gray-900"><?php echo e($config['label']); ?></h3>
                                <span class="text-xs text-gray-500"><?php echo e($columnTotals[$key]['count']); ?></span>
                            </div>
                            <?php if($columnTotals[$key]['value'] > 0): ?>
                                <p class="text-xs text-gray-400 mt-0.5">₹<?php echo e(number_format($columnTotals[$key]['value'])); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="p-3 space-y-2 min-h-[120px]">
                            <?php $__empty_1 = true; $__currentLoopData = $columns[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="bg-<?php echo e($config['color']); ?>-50 rounded-lg p-3 border border-<?php echo e($config['color']); ?>-100 hover:shadow-sm transition cursor-pointer">
                                    <h4 class="font-medium text-sm text-gray-900 truncate"><?php echo e($proposal->event?->title ?? 'Event #' . $proposal->event_id); ?></h4>
                                    <?php if($proposal->budget_offer): ?>
                                        <p class="text-xs font-medium text-gray-600 mt-1">₹<?php echo e(number_format($proposal->budget_offer)); ?></p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-[10px] text-gray-400"><?php echo e($proposal->created_at->format('M d')); ?></span>
                                        <a href="<?php echo e(route('sponsor.proposals.show', $proposal)); ?>" class="text-[10px] text-terracotta-500 hover:underline">View</a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center text-gray-300 text-xs py-4">No deals</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/pipeline/index.blade.php ENDPATH**/ ?>