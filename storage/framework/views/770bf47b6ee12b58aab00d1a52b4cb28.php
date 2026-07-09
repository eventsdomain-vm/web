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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsorship Objectives</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        <?php endif; ?>

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Your Objectives</h3>
            <button x-data @click="$dispatch('open-modal', 'create-objective-modal')" class="btn-primary text-sm px-3 py-1.5">Add Objective</button>
        </div>

        <?php if($objectives->isNotEmpty()): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900"><?php echo e($objective->name); ?></h4>
                                <p class="text-sm text-gray-500 mt-1"><?php echo e($objective->description); ?></p>
                                <div class="flex items-center gap-4 mt-3">
                                    <span class="px-2 py-1 bg-terracotta-100 text-terracotta-700 text-xs font-medium rounded">
                                        <?php echo e(str_replace('_', ' ', $objective->objective_type)); ?>

                                    </span>
                                    <?php if($objective->target_kpi_value): ?>
                                        <span class="text-xs text-gray-500">Target: <?php echo e($objective->target_kpi_value); ?> <?php echo e($objective->kpi_unit ?? ''); ?></span>
                                    <?php endif; ?>
                                    <?php if($objective->estimated_cost): ?>
                                        <span class="text-xs text-gray-500">Cost: ₹<?php echo e(number_format($objective->estimated_cost)); ?></span>
                                    <?php endif; ?>
                                    <?php if($objective->estimated_roi): ?>
                                        <span class="text-xs text-gray-500">ROI: <?php echo e($objective->estimated_roi); ?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button x-data @click="$dispatch('open-modal', 'edit-objective-<?php echo e($objective->id); ?>')" class="text-terracotta-500 hover:underline text-sm">Edit</button>
                                <form action="<?php echo e(route('sponsor.plan.objectives.destroy', $objective)); ?>" method="POST" onsubmit="return confirm('Delete this objective?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="p-12 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a9 9 0 01-9 9 9a9 0 01-9-9 9 0 0118 0z"/></svg>
                <p class="text-sm">No sponsorship objectives defined yet</p>
                <p class="text-xs text-gray-400 mt-1">Set objectives to guide AI recommendations</p>
                <button x-data @click="$dispatch('open-modal', 'create-objective-modal')" class="mt-4 btn-primary text-sm px-3 py-1.5">Create Your First Objective</button>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'create-objective-modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'create-objective-modal']); ?>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Sponsorship Objective</h3>
            <form action="<?php echo e(route('sponsor.plan.objectives.store')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Type</label>
                    <select name="objective_type" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="brand_awareness">Brand Awareness</option>
                        <option value="lead_generation" selected>Lead Generation</option>
                        <option value="sales_conversion">Sales Conversion</option>
                        <option value="csr">CSR / Community</option>
                        <option value="product_launch">Product Launch</option>
                        <option value="market_entry">Market Entry</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target KPI Value</label>
                        <input type="number" name="target_kpi_value" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KPI Unit</label>
                        <input type="text" name="kpi_unit" class="w-full rounded-lg border-gray-200 text-sm" placeholder="e.g., leads, views, revenue">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
                        <input type="number" name="estimated_cost" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated ROI (%)</label>
                        <input type="number" name="estimated_roi" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="show = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Create Objective</button>
                </div>
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

    <?php $__currentLoopData = $objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'edit-objective-'.e($objective->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'edit-objective-'.e($objective->id).'']); ?>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Objective</h3>
            <form action="<?php echo e(route('sponsor.plan.objectives.update', $objective)); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Name</label>
                    <input type="text" name="name" value="<?php echo e($objective->name); ?>" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm"><?php echo e($objective->description); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Type</label>
                    <select name="objective_type" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="brand_awareness" <?php echo e($objective->objective_type === 'brand_awareness' ? 'selected' : ''); ?>>Brand Awareness</option>
                        <option value="lead_generation" <?php echo e($objective->objective_type === 'lead_generation' ? 'selected' : ''); ?>>Lead Generation</option>
                        <option value="sales_conversion" <?php echo e($objective->objective_type === 'sales_conversion' ? 'selected' : ''); ?>>Sales Conversion</option>
                        <option value="csr" <?php echo e($objective->objective_type === 'csr' ? 'selected' : ''); ?>>CSR / Community</option>
                        <option value="product_launch" <?php echo e($objective->objective_type === 'product_launch' ? 'selected' : ''); ?>>Product Launch</option>
                        <option value="market_entry" <?php echo e($objective->objective_type === 'market_entry' ? 'selected' : ''); ?>>Market Entry</option>
                        <option value="other" <?php echo e($objective->objective_type === 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target KPI Value</label>
                        <input type="number" name="target_kpi_value" value="<?php echo e($objective->target_kpi_value); ?>" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KPI Unit</label>
                        <input type="text" name="kpi_unit" value="<?php echo e($objective->kpi_unit); ?>" class="w-full rounded-lg border-gray-200 text-sm" placeholder="e.g., leads, views, revenue">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
                        <input type="number" name="estimated_cost" value="<?php echo e($objective->estimated_cost); ?>" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated ROI (%)</label>
                        <input type="number" name="estimated_roi" value="<?php echo e($objective->estimated_roi); ?>" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="show = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Update Objective</button>
                </div>
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/plan/objectives/index.blade.php ENDPATH**/ ?>