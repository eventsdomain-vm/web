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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings</h2>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6 max-w-3xl">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Organization Profile</h3>
            </div>
            <form action="<?php echo e(route('sponsor.settings.update-org')); ?>" method="POST" class="p-6 space-y-4">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Legal Name</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $sponsor->name)); ?>" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Organization Type</label>
                        <select name="org_type" class="w-full rounded-lg border-gray-200 text-sm">
                            <option value="">-- Select --</option>
                            <?php $__currentLoopData = ['Corporate', 'Government', 'Non-Profit', 'Educational Institution', 'Association', 'Startup', 'SME', 'Enterprise', 'Holding Company']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>" <?php echo e(($sponsor->org_type ?? '') === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                        <input type="text" name="industry" value="<?php echo e(old('industry', $sponsor->industry)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" value="<?php echo e(old('website', $sponsor->website)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                        <input type="text" name="registration_number" value="<?php echo e(old('registration_number', $sponsor->registration_number)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tax ID</label>
                        <input type="text" name="tax_id" value="<?php echo e(old('tax_id', $sponsor->tax_id)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Headquarters</label>
                        <input type="text" name="headquarters" value="<?php echo e(old('headquarters', $sponsor->headquarters)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Email</label>
                        <input type="email" name="business_email" value="<?php echo e(old('business_email', $sponsor->business_email)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Phone</label>
                        <input type="text" name="business_phone" value="<?php echo e(old('business_phone', $sponsor->business_phone)); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                        <select name="timezone" class="w-full rounded-lg border-gray-200 text-sm">
                            <option value="">-- Select --</option>
                            <?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tz); ?>" <?php echo e(($sponsor->timezone ?? '') === $tz ? 'selected' : ''); ?>><?php echo e($tz); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Currency</label>
                        <select name="default_currency" class="w-full rounded-lg border-gray-200 text-sm">
                            <?php $__currentLoopData = ['INR' => 'INR - Indian Rupee', 'USD' => 'USD - US Dollar', 'EUR' => 'EUR - Euro', 'GBP' => 'GBP - British Pound', 'AED' => 'AED - Dirham']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($code); ?>" <?php echo e(($sponsor->default_currency ?? 'INR') === $code ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fiscal Year</label>
                        <input type="text" name="fiscal_year" value="<?php echo e(old('fiscal_year', $sponsor->fiscal_year)); ?>" placeholder="e.g., 2025-2026" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm"><?php echo e(old('description', $sponsor->description)); ?></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary text-sm px-4 py-2">Save Organization Profile</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Brand Profiles</h3>
                <button x-data @click="$dispatch('open-modal', 'create-brand-modal')" class="btn-primary text-sm px-3 py-1.5">Add Brand</button>
            </div>
            <div class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-medium text-gray-900"><?php echo e($brand->name); ?></h4>
                                    <?php if($brand->is_primary): ?>
                                        <span class="badge badge-success text-[10px]">Primary</span>
                                    <?php endif; ?>
                                </div>
                                <?php if($brand->tagline): ?>
                                    <p class="text-sm text-gray-500"><?php echo e($brand->tagline); ?></p>
                                <?php endif; ?>
                                <p class="text-xs text-gray-400 mt-1"><?php echo e($brand->assets->count()); ?> assets</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button x-data @click="$dispatch('open-modal', 'edit-brand-<?php echo e($brand->id); ?>')" class="text-sm text-terracotta-500 hover:underline">Edit</button>
                                <form action="<?php echo e(route('sponsor.settings.brands.delete', $brand)); ?>" method="POST" onsubmit="return confirm('Delete this brand?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No brands yet. Add your first brand profile.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div x-data="{ open: false }" @keydown.escape.window="open = false" x-show="open" x-cloak
         @open-modal.window="if ($event.detail === 'create-brand-modal') open = true"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.away="open = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Brand</h3>
            <form action="<?php echo e(route('sponsor.settings.brands.store')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" class="w-full rounded-lg border-gray-200 text-sm" maxlength="300">
                </div>
                <label class="flex items-center gap-2">
                    <input type="hidden" name="is_primary" value="0">
                    <input type="checkbox" name="is_primary" value="1" class="rounded border-gray-300">
                    <span class="text-sm text-gray-700">Set as primary brand</span>
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Create Brand</button>
                </div>
            </form>
        </div>
    </div>

    
    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div x-data="{ open: false }" @keydown.escape.window="open = false" x-show="open" x-cloak
             @open-modal.window="if ($event.detail === 'edit-brand-<?php echo e($brand->id); ?>') open = true"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div @click.away="open = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Brand: <?php echo e($brand->name); ?></h3>
                <form action="<?php echo e(route('sponsor.settings.brands.update', $brand)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                        <input type="text" name="name" value="<?php echo e($brand->name); ?>" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="<?php echo e($brand->tagline); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Colors (JSON)</label>
                        <textarea name="brand_colors" rows="2" class="w-full rounded-lg border-gray-200 text-sm font-mono"><?php echo e(json_encode($brand->brand_colors)); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Guidelines (JSON)</label>
                        <textarea name="brand_guidelines" rows="3" class="w-full rounded-lg border-gray-200 text-sm font-mono"><?php echo e(json_encode($brand->brand_guidelines)); ?></textarea>
                    </div>
                    <label class="flex items-center gap-2">
                        <input type="hidden" name="is_primary" value="0">
                        <input type="checkbox" name="is_primary" value="1" <?php echo e($brand->is_primary ? 'checked' : ''); ?> class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Primary brand</span>
                    </label>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="open = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                        <button type="submit" class="btn-primary text-sm px-3 py-1.5">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/settings/index.blade.php ENDPATH**/ ?>