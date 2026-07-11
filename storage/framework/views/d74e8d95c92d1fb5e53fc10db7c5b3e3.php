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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">SEO Settings</h2>
     <?php $__env->endSlot(); ?>

    <div class="container-page">
        <form method="POST" action="<?php echo e(route('admin.seo.settings.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Global Meta Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" name="global[site_name]" value="<?php echo e(old('global.site_name', $globalSettings->get('global')?->firstWhere('key', 'site_name')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Tagline</label>
                        <input type="text" name="global[site_tagline]" value="<?php echo e(old('global.site_tagline', $globalSettings->get('global')?->firstWhere('key', 'site_tagline')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="global[meta_description]" rows="2" class="input-field w-full"><?php echo e(old('global.meta_description', $globalSettings->get('global')?->firstWhere('key', 'meta_description')?->value ?? '')); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input type="text" name="global[meta_keywords]" value="<?php echo e(old('global.meta_keywords', $globalSettings->get('global')?->firstWhere('key', 'meta_keywords')?->value ?? '')); ?>" class="input-field w-full" placeholder="keyword1, keyword2, keyword3">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Author</label>
                        <input type="text" name="global[default_author]" value="<?php echo e(old('global.default_author', $globalSettings->get('global')?->firstWhere('key', 'default_author')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher Name</label>
                        <input type="text" name="global[publisher_name]" value="<?php echo e(old('global.publisher_name', $globalSettings->get('global')?->firstWhere('key', 'publisher_name')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">OG Image URL</label>
                        <input type="text" name="global[og_image]" value="<?php echo e(old('global.og_image', $globalSettings->get('global')?->firstWhere('key', 'og_image')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter Card Image URL</label>
                        <input type="text" name="global[twitter_card_image]" value="<?php echo e(old('global.twitter_card_image', $globalSettings->get('global')?->firstWhere('key', 'twitter_card_image')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Language</label>
                        <input type="text" name="global[default_language]" value="<?php echo e(old('global.default_language', $globalSettings->get('global')?->firstWhere('key', 'default_language')?->value ?? '')); ?>" class="input-field w-full" maxlength="2" placeholder="en">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Country</label>
                        <input type="text" name="global[default_country]" value="<?php echo e(old('global.default_country', $globalSettings->get('global')?->firstWhere('key', 'default_country')?->value ?? '')); ?>" class="input-field w-full" maxlength="2" placeholder="US">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Theme Color</label>
                        <input type="text" name="global[theme_color]" value="<?php echo e(old('global.theme_color', $globalSettings->get('global')?->firstWhere('key', 'theme_color')?->value ?? '')); ?>" class="input-field w-full" placeholder="#E35336">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Favicon URL</label>
                        <input type="text" name="global[favicon]" value="<?php echo e(old('global.favicon', $globalSettings->get('global')?->firstWhere('key', 'favicon')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Google Verification Code</label>
                        <input type="text" name="global[google_verification_code]" value="<?php echo e(old('global.google_verification_code', $globalSettings->get('global')?->firstWhere('key', 'google_verification_code')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bing Verification Code</label>
                        <input type="text" name="global[bing_verification_code]" value="<?php echo e(old('global.bing_verification_code', $globalSettings->get('global')?->firstWhere('key', 'bing_verification_code')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yandex Verification Code</label>
                        <input type="text" name="global[yandex_verification_code]" value="<?php echo e(old('global.yandex_verification_code', $globalSettings->get('global')?->firstWhere('key', 'yandex_verification_code')?->value ?? '')); ?>" class="input-field w-full">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Settings</button>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/admin/seo/settings.blade.php ENDPATH**/ ?>