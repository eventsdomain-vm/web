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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Integrations</h2>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary text-sm">+ Add Integration</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6">
        <?php $__empty_1 = true; $__currentLoopData = $integrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $integration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-bold uppercase"><?php echo e(substr($integration->provider, 0, 2)); ?></div>
                        <div><h3 class="font-semibold text-gray-900"><?php echo e($integration->name ?? $integration->provider); ?></h3>
                            <p class="text-xs text-gray-500"><?php echo e(ucfirst($integration->type)); ?> • <?php echo e($integration->provider); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge badge-<?php echo e($integration->status === 'connected' ? 'success' : ($integration->status === 'error' ? 'danger' : 'gray')); ?>"><?php echo e(ucfirst($integration->status)); ?></span>
                        <?php if($integration->isConnected()): ?>
                            <form method="POST" action="<?php echo e(route('sponsor.integrations.disconnect', $integration)); ?>"><?php echo csrf_field(); ?><button type="submit" class="text-red-500 hover:underline text-sm">Disconnect</button></form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if($integration->last_error): ?>
                    <p class="text-xs text-red-500 mt-2">Error: <?php echo e($integration->last_error); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No integrations configured. Connect your CRM, analytics, or communication tools.</div>
        <?php endif; ?>
    </div>
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Add Integration</h3>
            <form method="POST" action="<?php echo e(route('sponsor.integrations.store')); ?>"><?php echo csrf_field(); ?>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Provider</label><input type="text" name="provider" placeholder="e.g. zapier, hubspot, slack" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" placeholder="Optional label" class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full border-gray-300 rounded-md"><option value="crm">CRM</option><option value="analytics">Analytics</option><option value="communication">Communication</option><option value="automation">Automation</option><option value="payment">Payment</option></select></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Add</button></div>
            </form>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/integrations/index.blade.php ENDPATH**/ ?>