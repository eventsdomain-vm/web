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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Target Preferences & AI Matching</h2>
            <p class="text-sm text-gray-500 mt-1">Tell us how you like to sponsor so our AI can match you with the right events.</p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-4xl mx-auto">
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

        <form action="<?php echo e(route('sponsor.plan.preferences.update')); ?>" method="POST" class="space-y-6">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <section class="card overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-5m-9 0H3m2 0h5M7 7h1v1H7V7zm5 0h1v1h-1V7zm-5 4h1v1H7v-1zm5 0h1v1h-1v-1zm-5 4h1v1H7v-1zm5 0h1v1h-1v-1z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Industry Targets</h3>
                        <p class="text-sm text-gray-500">Select the industries your brand wants to reach.</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $industryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $industryId = 'industry_' . \Illuminate\Support\Str::slug($industry); ?>
                            <label for="<?php echo e($industryId); ?>" class="cursor-pointer inline-flex">
                                <input type="checkbox" id="<?php echo e($industryId); ?>" name="industry_targets[]" value="<?php echo e($industry); ?>" class="w-4 h-4 rounded-full accent-terracotta-500 cursor-pointer" <?php echo e(in_array($industry, $preferences->industry_targets ?? []) ? 'checked' : ''); ?>>
                                <span class="ml-2 inline-flex items-center px-3 py-2 rounded-full border border-gray-200 text-sm text-gray-600 transition hover:border-terracotta-300 cursor-pointer"><?php echo e($industry); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

            
            <section class="card overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Event Types & Sponsorship Formats</h3>
                        <p class="text-sm text-gray-500">Choose how you prefer to show up at events.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-3">Event Types</p>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $typeId = 'event_' . \Illuminate\Support\Str::slug($type); ?>
                                <label for="<?php echo e($typeId); ?>" class="cursor-pointer inline-flex">
                                    <input type="checkbox" id="<?php echo e($typeId); ?>" name="event_types[]" value="<?php echo e($type); ?>" class="w-4 h-4 rounded-full accent-terracotta-500 cursor-pointer" <?php echo e(in_array($type, $preferences->event_types ?? []) ? 'checked' : ''); ?>>
                                    <span class="ml-2 inline-flex items-center px-3 py-2 rounded-full border border-gray-200 text-sm text-gray-600 capitalize transition hover:border-terracotta-300 cursor-pointer"><?php echo e(str_replace('_', ' ', $type)); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-3">Sponsorship Formats</p>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $formatOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $formatId = 'format_' . \Illuminate\Support\Str::slug($format); ?>
                                <label for="<?php echo e($formatId); ?>" class="cursor-pointer inline-flex">
                                    <input type="checkbox" id="<?php echo e($formatId); ?>" name="formats_preferred[]" value="<?php echo e($format); ?>" class="w-4 h-4 rounded-full accent-terracotta-500 cursor-pointer" <?php echo e(in_array($format, $preferences->formats_preferred ?? []) ? 'checked' : ''); ?>>
                                    <span class="ml-2 inline-flex items-center px-3 py-2 rounded-full border border-gray-200 text-sm text-gray-600 transition hover:border-terracotta-300 cursor-pointer"><?php echo e(str_replace('_', ' ', $format)); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </section>

            
            <section class="card overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Locations & Categories</h3>
                        <p class="text-sm text-gray-500">Add cities and event categories you care about (comma separated).</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Geographic Preferences</label>
                        <input type="text" name="geographic_preferences" value="<?php echo e($preferences->geographic_preferences ? implode(', ', $preferences->geographic_preferences) : ''); ?>" placeholder="Mumbai, Delhi, Bangalore" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category Preferences</label>
                        <input type="text" name="category_preferences" value="<?php echo e($preferences->category_preferences ? implode(', ', $preferences->category_preferences) : ''); ?>" placeholder="technology, healthcare, education" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                </div>
            </section>

            
            <section class="card overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Budget & Audience</h3>
                        <p class="text-sm text-gray-500">Help us scope recommendations to your investment and reach.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Budget Range (₹)</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="budget_range[min]" value="<?php echo e($preferences->budget_range['min'] ?? ''); ?>" placeholder="Min" class="w-full rounded-lg border-gray-200 text-sm">
                            <input type="number" name="budget_range[max]" value="<?php echo e($preferences->budget_range['max'] ?? ''); ?>" placeholder="Max" class="w-full rounded-lg border-gray-200 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience Size</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="min_audience_size" value="<?php echo e($preferences->min_audience_size ?? ''); ?>" placeholder="Min" class="w-full rounded-lg border-gray-200 text-sm" min="0" max="1000000">
                            <input type="number" name="max_audience_size" value="<?php echo e($preferences->max_audience_size ?? ''); ?>" placeholder="Max" class="w-full rounded-lg border-gray-200 text-sm" min="0" max="1000000">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Audience Age Range</label>
                        <input type="text" name="target_audience_demographics[age_range]" value="<?php echo e($preferences->target_audience_demographics['age_range'] ?? ''); ?>" placeholder="e.g., 25-45" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Income Bracket</label>
                        <input type="text" name="target_audience_demographics[income]" value="<?php echo e($preferences->target_audience_demographics['income'] ?? ''); ?>" placeholder="e.g., 50k-100k" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                </div>
            </section>

            
            <section class="card overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Additional Notes</h3>
                        <p class="text-sm text-gray-500">Anything else we should know about your sponsorship goals.</p>
                    </div>
                </div>
                <div class="p-6">
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-200 text-sm" placeholder="Share any context, past events, or must-haves..."><?php echo e($preferences->notes ?? ''); ?></textarea>
                </div>
            </section>

            <div class="flex items-center justify-end gap-3">
                <button type="submit" class="btn-primary px-5 py-2.5 inline-flex items-center gap-2">
                    <span>Save Preferences</span>
                </button>
            </div>
        </form>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/plan/preferences/index.blade.php ENDPATH**/ ?>