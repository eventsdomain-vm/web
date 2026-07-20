
<?php
    $user = auth()->user();
    $initials = '';
    if ($user && $user->name) {
        $words = explode(' ', trim($user->name));
        if (count($words) >= 2) {
            $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(mb_substr($user->name, 0, 2));
        }
    }
?>

<div
    x-data="{ showConfirm: false }"
    class="mt-auto border-t border-gray-100 bg-gradient-to-r from-gray-50 via-white to-gray-50 shrink-0"
>
    
    <div class="px-4 pt-4 pb-2">
        <div class="flex items-center gap-3">
            
            <div class="relative flex-shrink-0">
                <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['size' => 'w-10 h-10','fontSize' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'w-10 h-10','fontSize' => 'text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $attributes = $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $component = $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white"></div>
            </div>

            
            <div class="min-w-0 flex-1">
                <p class="text-[15px] font-semibold text-gray-900 leading-tight truncate">
                    <?php echo e($user->name); ?>

                </p>
                <p class="text-[13px] text-gray-500 leading-tight mt-0.5 truncate">
                    <?php echo e($user->email); ?>

                </p>
            </div>
        </div>
    </div>

    
    <div class="mx-4 h-px bg-gray-200 my-2"></div>

    
    <div class="px-2 pb-3">
        <button
            @click="showConfirm = true"
            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group"
        >
            <svg class="w-[18px] h-[18px] text-gray-400 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
            </svg>
            <span class="group-hover:font-semibold transition-all">Sign Out</span>
        </button>
    </div>

    
    <div
        x-show="showConfirm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        
        <div
            class="absolute inset-0 bg-black/50"
            @click="showConfirm = false"
        ></div>

        
        <div
            x-show="showConfirm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6"
            role="dialog"
            aria-modal="true"
            aria-labelledby="logout-title"
        >
            
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
            </div>

            
            <h3 id="logout-title" class="text-lg font-semibold text-gray-900 text-center">
                Sign Out
            </h3>

            
            <p class="mt-2 text-sm text-gray-500 text-center">
                Are you sure you want to sign out? You'll need to log in again to access your account.
            </p>

            
            <div class="flex gap-3 mt-6">
                <button
                    @click="showConfirm = false"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    Cancel
                </button>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button
                        type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/components/layout/sidebar-footer.blade.php ENDPATH**/ ?>