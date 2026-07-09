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
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Budget Allocations</h2>
            <p class="text-sm text-gray-500 mt-1">Plan and track your sponsorship spend by fiscal year and category.</p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Your Allocations</h3>
                <p class="text-sm text-gray-500">Define a budget per fiscal year and split it across categories.</p>
            </div>
            <button x-data @click="$dispatch('open-modal', 'create-budget-modal')" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Allocation
            </button>
        </div>

        <?php if($budgetAllocations->isNotEmpty()): ?>
            <div class="space-y-5">
                <?php $__currentLoopData = $budgetAllocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $badge = match($allocation->status) {
                            'active' => 'bg-green-100 text-green-700',
                            'approved' => 'bg-blue-100 text-blue-700',
                            'draft' => 'bg-gray-100 text-gray-600',
                            'closed' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                        $used = $allocation->total_budget > 0 ? min(100, ($allocation->allocated_so_far / $allocation->total_budget) * 100) : 0;
                        $remaining = ($allocation->total_budget ?? 0) - ($allocation->allocated_so_far ?? 0);
                        $catRows = $allocation->category_allocations
                            ? collect($allocation->category_allocations)->map(fn ($a, $c) => ['category' => $c, 'amount' => $a])->values()->all()
                            : [];
                    ?>
                    <div class="card overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="font-semibold text-lg text-gray-900"><?php echo e($allocation->fiscal_year); ?> Fiscal Year</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($badge); ?>"><?php echo e(ucfirst($allocation->status)); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <?php echo e($allocation->valid_from?->format('M d, Y') ?? '—'); ?>

                                        <?php if($allocation->valid_to): ?> &rarr; <?php echo e($allocation->valid_to->format('M d, Y')); ?> <?php endif; ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Budget</p>
                                    <p class="text-2xl font-bold text-gray-900">₹<?php echo e(number_format($allocation->total_budget, 2)); ?></p>
                                </div>
                            </div>

                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="text-gray-500">Utilization</span>
                                <span class="font-medium text-gray-700"><?php echo e(number_format($used, 1)); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-terracotta-500 h-2.5 rounded-full transition-all" style="width: <?php echo e($used); ?>%"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-5">
                                <div class="p-3.5 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Allocated</p>
                                    <p class="text-sm font-semibold text-gray-900">₹<?php echo e(number_format($allocation->allocated_so_far, 2)); ?></p>
                                </div>
                                <div class="p-3.5 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Remaining</p>
                                    <p class="text-sm font-semibold text-gray-900">₹<?php echo e(number_format($remaining, 2)); ?></p>
                                </div>
                            </div>

                            <?php if($allocation->category_allocations): ?>
                                <div class="mt-5">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Category Split</p>
                                    <div class="flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $allocation->category_allocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-terracotta-50 text-terracotta-700 text-sm">
                                                <span class="font-medium"><?php echo e($category); ?></span>
                                                <span class="text-terracotta-500">₹<?php echo e(number_format($amount, 2)); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center justify-end gap-3 mt-5 pt-4 border-t border-gray-100">
                                <button x-data @click="$dispatch('open-modal', 'edit-budget-<?php echo e($allocation->id); ?>')" class="text-terracotta-500 hover:underline text-sm font-medium">Edit</button>
                                <form action="<?php echo e(route('sponsor.plan.budgets.delete', $allocation)); ?>" method="POST" x-data onsubmit="return confirm('Delete this budget allocation?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:underline text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'edit-budget-'.e($allocation->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'edit-budget-'.e($allocation->id).'']); ?>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Edit Budget Allocation</h3>
                            <p class="text-sm text-gray-500 mb-5"><?php echo e($allocation->fiscal_year); ?> Fiscal Year</p>
                            <form x-data="budgetForm()" x-ref="form" action="<?php echo e(route('sponsor.plan.budgets.update', $allocation)); ?>" method="POST"
                                  @submit.prevent="submit($refs.form)" class="space-y-5">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Fiscal Year</label>
                                        <input type="text" name="fiscal_year" value="<?php echo e($allocation->fiscal_year); ?>" pattern="[0-9]{4}" class="w-full rounded-lg border-gray-200 text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Budget (₹)</label>
                                        <input type="number" name="total_budget" value="<?php echo e($allocation->total_budget); ?>" step="0.01" min="0" class="w-full rounded-lg border-gray-200 text-sm" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                                    <select name="status" class="w-full rounded-lg border-gray-200 text-sm">
                                        <option value="draft" <?php echo e($allocation->status === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                        <option value="approved" <?php echo e($allocation->status === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                        <option value="active" <?php echo e($allocation->status === 'active' ? 'selected' : ''); ?>>Active</option>
                                        <option value="closed" <?php echo e($allocation->status === 'closed' ? 'selected' : ''); ?>>Closed</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valid From</label>
                                        <input type="date" name="valid_from" value="<?php echo e($allocation->valid_from?->format('Y-m-d')); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valid To</label>
                                        <input type="date" name="valid_to" value="<?php echo e($allocation->valid_to?->format('Y-m-d')); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Allocations</label>
                                    <div x-data='{ rows: <?php echo json_encode($catRows, 15, 512) ?> }' class="space-y-3">
                                        <template x-for="(row, index) in rows" :key="index">
                                            <div class="flex items-center gap-2">
                                                <input type="text" x-model="row.category" placeholder="Category (e.g., Marketing)" class="flex-1 rounded-lg border-gray-200 text-sm">
                                                <div class="relative w-44">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                                    <input type="number" x-model="row.amount" placeholder="0" min="0" step="0.01" class="w-full rounded-lg border-gray-200 text-sm pl-7">
                                                </div>
                                                <button type="button" @click="rows.splice(index, 1)" class="text-gray-400 hover:text-red-500 p-1.5 shrink-0" aria-label="Remove">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                                <template x-if="row.category">
                                                    <input type="hidden" :name="'category_allocations[' + row.category + ']'" :value="row.amount">
                                                </template>
                                            </div>
                                        </template>
                                        <button type="button" @click="rows.push({category:'', amount:''})" class="text-sm text-terracotta-500 hover:underline inline-flex items-center gap-1 font-medium">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Add Category Allocation
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                                    <button type="button" @click="show = false" class="btn-outline text-sm px-4 py-2">Cancel</button>
                                    <button type="submit" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-2" :class="submitting ? 'opacity-70 cursor-wait' : ''" :disabled="submitting">
                                        <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        <span x-text="submitting ? 'Saving…' : 'Save Changes'">Save Changes</span>
                                    </button>
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
            </div>
        <?php else: ?>
            <div class="card p-12 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-terracotta-50 text-terracotta-500 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-gray-700 font-medium">No budget allocation set yet</p>
                <p class="text-sm text-gray-400 mt-1 mb-5">Define a fiscal year and total budget to start planning.</p>
                <button x-data @click="$dispatch('open-modal', 'create-budget-modal')" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create First Allocation
                </button>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'create-budget-modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'create-budget-modal']); ?>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Allocate Budget for Fiscal Year</h3>
            <p class="text-sm text-gray-500 mb-5">Set the total amount and split it across categories.</p>
            <form x-data="budgetForm()" x-ref="form" action="<?php echo e(route('sponsor.plan.budgets.store')); ?>" method="POST"
                  @submit.prevent="submit($refs.form)" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Fiscal Year</label>
                        <input type="text" name="fiscal_year" pattern="[0-9]{4}" placeholder="e.g., 2026" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Budget (₹)</label>
                        <input type="number" name="total_budget" step="0.01" min="0" placeholder="0" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-200 text-sm" required>
                        <option value="draft">Draft</option>
                        <option value="approved">Approved</option>
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valid From</label>
                        <input type="date" name="valid_from" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Valid To</label>
                        <input type="date" name="valid_to" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Allocations</label>
                    <div x-data="{ rows: [] }" class="space-y-3">
                        <template x-for="(row, index) in rows" :key="index">
                            <div class="flex items-center gap-2">
                                <input type="text" x-model="row.category" placeholder="Category (e.g., Marketing)" class="flex-1 rounded-lg border-gray-200 text-sm">
                                <div class="relative w-44">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                    <input type="number" x-model="row.amount" placeholder="0" min="0" step="0.01" class="w-full rounded-lg border-gray-200 text-sm pl-7">
                                </div>
                                <button type="button" @click="rows.splice(index, 1)" class="text-gray-400 hover:text-red-500 p-1.5 shrink-0" aria-label="Remove">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <template x-if="row.category">
                                    <input type="hidden" :name="'category_allocations[' + row.category + ']'" :value="row.amount">
                                </template>
                            </div>
                        </template>
                        <button type="button" @click="rows.push({category:'', amount:''})" class="text-sm text-terracotta-500 hover:underline inline-flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Category Allocation
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" @click="show = false" class="btn-outline text-sm px-4 py-2">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-2" :class="submitting ? 'opacity-70 cursor-wait' : ''" :disabled="submitting">
                        <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        <span x-text="submitting ? 'Creating…' : 'Create Allocation'">Create Allocation</span>
                    </button>
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

    <script>
        function budgetForm() {
            return {
                submitting: false,
                async submit(form) {
                    this.submitting = true;
                    const token = document.querySelector('input[name="_token"]').value;
                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                        });
                        if (res.ok) {
                            window.location.reload();
                            return;
                        }
                        const data = await res.json().catch(() => ({}));
                        const msg = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Please check your input.');
                        alert(msg);
                    } catch (e) {
                        alert('Network error. Please try again.');
                    } finally {
                        this.submitting = false;
                    }
                }
            };
        }
    </script>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/plan/budgets/index.blade.php ENDPATH**/ ?>