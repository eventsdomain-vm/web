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
     <?php $__env->slot('header', null, []); ?> <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Acquisition</h2> <?php $__env->endSlot(); ?>
    <div class="container-page space-y-6">
        <?php if($events->count()): ?>
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Your Events & Request Summary</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded-lg p-3 text-sm">
                    <p class="font-medium truncate"><?php echo e($event->title); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e($event->sponsorship_requests_count); ?> requests (<?php echo e($event->pending_requests_count); ?> pending)</p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Recent Requests</h3>
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="pb-2">Sponsor</th><th class="pb-2">Event</th><th class="pb-2">Package</th><th class="pb-2">Status</th><th class="pb-2">Date</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-gray-100">
                            <td class="py-2"><?php echo e($r->sponsor?->company_name ?? 'ID:'.$r->sponsor_id); ?></td>
                            <td class="py-2"><?php echo e($r->event?->title ?? '-'); ?></td>
                            <td class="py-2"><?php echo e($r->package?->name ?? '-'); ?></td>
                            <td class="py-2"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')); ?>"><?php echo e(ucfirst($r->status)); ?></span></td>
                            <td class="py-2"><?php echo e($r->created_at->format('M d, Y')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="py-6 text-center text-gray-400">No requests yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/acquisition/index.blade.php ENDPATH**/ ?>