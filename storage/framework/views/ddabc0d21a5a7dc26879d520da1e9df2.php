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
     <?php $__env->slot('header', null, []); ?> <h2 class="font-semibold text-xl text-gray-800 leading-tight">Analytics & Reports</h2> <?php $__env->endSlot(); ?>
    <div class="container-page space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4"><p class="text-xs text-gray-500">Total Events</p><p class="text-2xl font-bold text-indigo-600"><?php echo e($totalEvents); ?></p><p class="text-xs text-gray-400"><?php echo e($publishedEvents); ?> published, <?php echo e($draftEvents); ?> draft</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Contract Value (Active)</p><p class="text-2xl font-bold text-green-600">₹<?php echo e(number_format($totalContractValue, 0)); ?></p><p class="text-xs text-gray-400"><?php echo e($activeContracts); ?> active contracts</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Sponsorship Requests</p><p class="text-2xl font-bold text-yellow-600"><?php echo e($pendingRequests); ?></p><p class="text-xs text-gray-400"><?php echo e($acceptedRequests); ?> accepted</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Active Sponsors</p><p class="text-2xl font-bold text-blue-600"><?php echo e($activeSponsors); ?></p><p class="text-xs text-gray-400">Avg health: <?php echo e($avgHealthScore ? number_format($avgHealthScore, 1) : 'N/A'); ?></p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Avg Sponsor Satisfaction</p><p class="text-2xl font-bold text-purple-600"><?php echo e($avgSatisfaction ? number_format($avgSatisfaction, 1) : 'N/A'); ?>/5</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Avg ROI</p><p class="text-2xl font-bold text-green-600"><?php echo e($avgROI ? number_format($avgROI, 1).'%' : 'N/A'); ?></p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Total Post-Event Revenue</p><p class="text-2xl font-bold text-emerald-600">₹<?php echo e(number_format($totalRevenue, 0)); ?></p></div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/reports/index.blade.php ENDPATH**/ ?>