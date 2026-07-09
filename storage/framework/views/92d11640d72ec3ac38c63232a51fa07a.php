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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Security Settings</h2>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6 max-w-3xl">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">API Keys</h3>
            </div>
            <div class="p-6">
                <form action="<?php echo e(route('sponsor.settings.api-keys.store')); ?>" method="POST" class="flex items-end gap-3 mb-4">
                    <?php echo csrf_field(); ?>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key Name</label>
                        <input type="text" name="name" placeholder="e.g., Production API Key" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <button type="submit" class="btn-primary text-sm px-4 py-2">Generate Key</button>
                </form>

                <?php if($integrations->isNotEmpty()): ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $integrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $integration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900"><?php echo e($integration->name); ?></h4>
                                    <p class="text-xs text-gray-500 font-mono"><?php echo e(substr($integration->api_key ?? '', 0, 12)); ?>...<?php echo e(substr($integration->api_key ?? '', -4)); ?></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-<?php echo e($integration->status === 'active' ? 'success' : 'danger'); ?> text-xs"><?php echo e(ucfirst($integration->status)); ?></span>
                                    <?php if($integration->status === 'active'): ?>
                                        <form action="<?php echo e(route('sponsor.settings.api-keys.revoke', $integration)); ?>" method="POST" onsubmit="return confirm('Revoke this API key? This cannot be undone.')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-xs text-red-500 hover:underline">Revoke</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500">No API keys generated yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Two-Factor Authentication</h3>
            </div>
            <div class="p-6">
                <form action="<?php echo e(route('sponsor.settings.two-factor')); ?>" method="POST" class="flex items-center justify-between">
                    <?php echo csrf_field(); ?>
                    <div>
                        <p class="text-sm text-gray-700">Protect your account with an additional authentication layer.</p>
                        <p class="text-xs text-gray-500 mt-0.5">Uses authenticator app or SMS OTP.</p>
                    </div>
                    <button type="submit" name="two_factor_enabled" value="<?php echo e($user->two_factor_enabled ? '0' : '1'); ?>"
                            class="<?php echo e($user->two_factor_enabled ? 'btn-outline' : 'btn-primary'); ?> text-sm px-4 py-2">
                        <?php echo e($user->two_factor_enabled ? 'Disable' : 'Enable'); ?>

                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Single Sign-On (SSO)</h3>
            </div>
            <div class="p-6">
                <form action="<?php echo e(route('sponsor.settings.sso')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SSO Provider</label>
                            <select name="sso_provider" class="w-full rounded-lg border-gray-200 text-sm">
                                <option value="">-- Select Provider --</option>
                                <option value="google" <?php echo e(($sponsor->sso_provider ?? '') === 'google' ? 'selected' : ''); ?>>Google Workspace</option>
                                <option value="microsoft" <?php echo e(($sponsor->sso_provider ?? '') === 'microsoft' ? 'selected' : ''); ?>>Microsoft 365</option>
                                <option value="okta" <?php echo e(($sponsor->sso_provider ?? '') === 'okta' ? 'selected' : ''); ?>>Okta</option>
                                <option value="azure" <?php echo e(($sponsor->sso_provider ?? '') === 'azure' ? 'selected' : ''); ?>>Azure AD</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Client ID</label>
                            <input type="text" name="sso_client_id" value="<?php echo e($sponsor->sso_client_id ?? ''); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Client Secret</label>
                            <input type="password" name="sso_client_secret" value="<?php echo e($sponsor->sso_client_secret ?? ''); ?>" class="w-full rounded-lg border-gray-200 text-sm">
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2">
                                <input type="hidden" name="sso_enabled" value="0">
                                <input type="checkbox" name="sso_enabled" value="1" <?php echo e(($sponsor->sso_enabled ?? false) ? 'checked' : ''); ?> class="rounded border-gray-300">
                                <span class="text-sm text-gray-700">Enable SSO</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary text-sm px-4 py-2">Save SSO Configuration</button>
                    </div>
                </form>
            </div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/settings/security.blade.php ENDPATH**/ ?>