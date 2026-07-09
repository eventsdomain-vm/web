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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Renewal Pipeline</h2>
            <button onclick="document.getElementById('create-renewal').classList.toggle('hidden')" class="btn-primary px-4 py-2 rounded-lg text-sm">+ New Renewal</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page space-y-6">
        <div id="create-renewal" class="hidden card p-6 max-w-2xl">
            <form method="POST" action="<?php echo e(route('organizer.renewals.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Sponsor ID</label>
                        <input type="number" name="sponsor_id" class="w-full rounded-lg border-gray-300 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Contract ID (optional)</label>
                        <input type="number" name="contract_id" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 text-sm" required>
                            <option value="negotiation">Negotiation</option>
                            <option value="proposal_sent">Proposal Sent</option>
                            <option value="approved">Approved</option>
                            <option value="renewed">Renewed</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Proposed Value (₹)</label>
                        <input type="number" name="proposed_value" min="0" step="0.01" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Probability (%)</label>
                        <input type="number" name="probability" min="0" max="100" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Expected Close Date</label>
                        <input type="date" name="expected_close_date" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-4 flex justify-end"><button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Create Renewal</button></div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="text-left bg-gray-50 text-gray-600"><th class="p-3">Sponsor</th><th class="p-3">Value</th><th class="p-3">Probability</th><th class="p-3">Status</th><th class="p-3">Close Date</th><th class="p-3"></th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $renewals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-t border-gray-100">
                            <td class="p-3 font-medium"><?php echo e($r->sponsor?->company_name ?? 'ID:'.$r->sponsor_id); ?></td>
                            <td class="p-3">₹<?php echo e(number_format($r->proposed_value ?? 0, 2)); ?></td>
                            <td class="p-3"><?php echo e($r->probability); ?>%</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e(match($r->status) { 'renewed' => 'bg-green-100 text-green-800', 'lost' => 'bg-red-100 text-red-800', 'approved' => 'bg-blue-100 text-blue-800', default => 'bg-yellow-100 text-yellow-800' }); ?>">
                                    <?php echo e(ucfirst($r->status)); ?>

                                </span>
                            </td>
                            <td class="p-3"><?php echo e($r->expected_close_date?->format('M d, Y') ?? '-'); ?></td>
                            <td class="p-3">
                                <form method="POST" action="<?php echo e(route('organizer.renewals.update-stage', $r->id)); ?>" class="flex gap-1">
                                    <?php echo csrf_field(); ?>
                                    <select name="status" class="text-xs rounded border-gray-300">
                                        <option value="negotiation" <?php echo e($r->status === 'negotiation' ? 'selected' : ''); ?>>Negotiation</option>
                                        <option value="proposal_sent" <?php echo e($r->status === 'proposal_sent' ? 'selected' : ''); ?>>Proposal Sent</option>
                                        <option value="approved" <?php echo e($r->status === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                        <option value="renewed" <?php echo e($r->status === 'renewed' ? 'selected' : ''); ?>>Renewed</option>
                                        <option value="lost" <?php echo e($r->status === 'lost' ? 'selected' : ''); ?>>Lost</option>
                                    </select>
                                    <button type="submit" class="text-xs text-indigo-600 hover:underline">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No renewals.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($renewals->links()); ?>

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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/renewals/index.blade.php ENDPATH**/ ?>