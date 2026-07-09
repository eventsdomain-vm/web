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
     <?php $__env->slot('header', null, []); ?> <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contracts & Finance</h2> <?php $__env->endSlot(); ?>
    <div class="container-page space-y-6">
        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="text-left bg-gray-50 text-gray-600"><th class="p-3">Sponsor</th><th class="p-3">Event</th><th class="p-3">Amount</th><th class="p-3">Status</th><th class="p-3">Signed</th><th class="p-3"></th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-t border-gray-100">
                            <td class="p-3 font-medium"><?php echo e($c->sponsor?->company_name ?? 'ID:'.$c->sponsor_id); ?></td>
                            <td class="p-3"><?php echo e($c->event?->title ?? '-'); ?></td>
                            <td class="p-3">₹<?php echo e(number_format($c->amount ?? 0, 2)); ?></td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e(match($c->status) { 'active' => 'bg-green-100 text-green-800', 'pending' => 'bg-yellow-100 text-yellow-800', 'expired' => 'bg-red-100 text-red-800', 'cancelled' => 'bg-gray-100 text-gray-800', default => 'bg-blue-100 text-blue-800' }); ?>">
                                    <?php echo e(ucfirst($c->status)); ?>

                                </span>
                            </td>
                            <td class="p-3"><?php echo e($c->signed_at?->format('M d, Y') ?? '-'); ?></td>
                            <td class="p-3"><a href="<?php echo e(route('organizer.contracts.show', $c->id)); ?>" class="text-indigo-600 hover:underline text-xs">View</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No contracts found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($contracts->links()); ?>

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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/contracts/index.blade.php ENDPATH**/ ?>