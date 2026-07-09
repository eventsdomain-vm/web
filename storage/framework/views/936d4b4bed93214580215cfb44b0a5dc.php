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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsorship Budget</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <?php if(session('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Set Fiscal Year Budget</h3>
                <form action="<?php echo e(route('sponsor.budget.store')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Fiscal Year *</label>
                            <select name="fiscal_year" class="input-field w-full" required>
                                <?php for($year = date('Y'); $year <= date('Y') + 3; $year++): ?>
                                    <option value="<?php echo e($year); ?>" <?php echo e(($currentBudget->fiscal_year ?? '') == $year ? 'selected' : ''); ?>>FY <?php echo e($year); ?>-<?php echo e($year + 1); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Total Budget (₹) *</label>
                            <input type="number" name="total_budget" min="0" step="0.01" value="<?php echo e(old('total_budget', $currentBudget->total_budget ?? '')); ?>" class="input-field w-full" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Preferred Event Size</label>
                            <select name="preferred_event_size" class="input-field w-full">
                                <option value="">Any Size</option>
                                <option value="small" <?php echo e(($currentBudget->preferred_event_size ?? '') == 'small' ? 'selected' : ''); ?>>Small (under 1,000)</option>
                                <option value="medium" <?php echo e(($currentBudget->preferred_event_size ?? '') == 'medium' ? 'selected' : ''); ?>>Medium (1,000 - 10,000)</option>
                                <option value="large" <?php echo e(($currentBudget->preferred_event_size ?? '') == 'large' ? 'selected' : ''); ?>>Large (10,000+)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Preferred Categories</label>
                            <select name="preferred_categories[]" multiple class="input-field w-full" size="3">
                                <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, ($currentBudget->preferred_categories ?? [])) ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-primary text-sm">Save Budget</button>
                    </div>
                </form>
            </div>

            <?php if($budgets->count()): ?>
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Budget History</h3>
                <div class="space-y-3">
                    <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div>
                                <span class="font-medium text-gray-900">FY <?php echo e($budget->fiscal_year); ?>-<?php echo e($budget->fiscal_year + 1); ?></span>
                                <p class="text-sm text-gray-500">Total: ₹<?php echo e(number_format($budget->total_budget)); ?></p>
                            </div>
                            <div class="text-right">
                                <span class="block font-bold text-gray-900">₹<?php echo e(number_format($budget->remaining)); ?></span>
                                <span class="text-sm text-gray-500">remaining</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if($currentBudget): ?>
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Budget Utilization</h3>
                <?php
                    $activeProposals = $proposals ?? collect();
                    $committed = $activeProposals->whereIn('status', ['agreed', 'contracted', 'active'])->sum('budget_offer');
                    $pending = $activeProposals->whereIn('status', ['submitted', 'viewed', 'shortlisted', 'negotiating'])->sum('budget_offer');
                    $total = $currentBudget->total_budget;
                    $committedPercent = $total > 0 ? round(($committed / $total) * 100) : 0;
                    $pendingPercent = $total > 0 ? round(($pending / $total) * 100) : 0;
                ?>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Committed</span>
                        <span class="font-medium">₹<?php echo e(number_format($committed)); ?> (<?php echo e($committedPercent); ?>%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-terracotta-500 h-3 rounded-full" style="width: <?php echo e(min($committedPercent, 100)); ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Pending</span>
                        <span class="font-medium">₹<?php echo e(number_format($pending)); ?> (<?php echo e($pendingPercent); ?>%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: <?php echo e(min($pendingPercent, 100)); ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-2 border-t">
                        <span class="font-semibold text-gray-700">Available</span>
                        <span class="font-bold text-green-600">₹<?php echo e(number_format($total - $committed - $pending)); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/budget/index.blade.php ENDPATH**/ ?>