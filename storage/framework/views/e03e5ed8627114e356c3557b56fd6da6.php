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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
            <span class="text-sm text-gray-500"><?php echo e(method_exists($invoices, 'total') ? $invoices->total() : $invoices->count()); ?> total</span>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stat-card"><p class="text-sm text-gray-500">Total Invoiced</p><p class="text-2xl font-bold">₹<?php echo e(number_format($summary['total_invoiced'])); ?></p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Total Paid</p><p class="text-2xl font-bold text-green-600">₹<?php echo e(number_format($summary['total_paid'])); ?></p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Outstanding</p><p class="text-2xl font-bold text-yellow-600">₹<?php echo e(number_format($summary['outstanding'])); ?></p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Overdue</p><p class="text-2xl font-bold text-red-600"><?php echo e($summary['overdue_count']); ?></p></div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="<?php echo e(route('sponsor.invoices.show', $invoice)); ?>" class="font-semibold text-gray-900 hover:text-terracotta-500"><?php echo e($invoice->invoice_number); ?></a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>₹<?php echo e(number_format($invoice->total)); ?></span>
                            <span>Due: <?php echo e($invoice->due_date->format('M d, Y')); ?></span>
                            <span>Paid: ₹<?php echo e(number_format($invoice->amount_paid)); ?></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : ($invoice->status === 'draft' ? 'gray' : 'warning'))); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?></span>
                        <a href="<?php echo e(route('sponsor.invoices.show', $invoice)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No invoices yet.</div>
        <?php endif; ?>
        <?php if(method_exists($invoices, 'links')): ?>
            <?php echo e($invoices->links()); ?>

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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/invoices/index.blade.php ENDPATH**/ ?>