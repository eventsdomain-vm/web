<?php
    $notifCount = 0;
    $recentNotifs = collect();
    if (auth()->check()) {
        try {
            $notifCount = \App\Models\SponsorNotification::where('user_id', auth()->id())->whereNull('read_at')->count();
            $recentNotifs = \App\Models\SponsorNotification::where('user_id', auth()->id())->latest()->take(5)->get();
        } catch (\Exception $e) {
            // table may not exist yet
        }
    }
?>
<header
    x-data="{ notifOpen: false }"
    @click.outside="notifOpen = false"
    class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm h-16 shrink-0"
>
    <div class="flex items-center justify-between h-full px-4 sm:px-6">
        
        <div class="flex items-center gap-3 min-w-0">
            <button
                @click="$dispatch('toggle-sidebar')"
                class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-[#F26C4F]"
                aria-label="Toggle sidebar"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <button
                @click="$dispatch('toggle-sidebar')"
                class="hidden lg:flex p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-[#F26C4F]"
                aria-label="Toggle sidebar"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <div class="hidden sm:block min-w-0">
                <?php if (isset($component)) { $__componentOriginal045477955e5b1d8c9df01934ca3836c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal045477955e5b1d8c9df01934ca3836c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.breadcrumb','data' => ['items' => (new \App\View\Components\Breadcrumbs())->items]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((new \App\View\Components\Breadcrumbs())->items)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal045477955e5b1d8c9df01934ca3836c0)): ?>
<?php $attributes = $__attributesOriginal045477955e5b1d8c9df01934ca3836c0; ?>
<?php unset($__attributesOriginal045477955e5b1d8c9df01934ca3836c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal045477955e5b1d8c9df01934ca3836c0)): ?>
<?php $component = $__componentOriginal045477955e5b1d8c9df01934ca3836c0; ?>
<?php unset($__componentOriginal045477955e5b1d8c9df01934ca3836c0); ?>
<?php endif; ?>
            </div>

            <div class="sm:hidden min-w-0">
                <?php
                    $path = request()->path();
                    $segments = array_filter(explode('/', $path));
                    $lastSegment = end($segments) ?? 'Dashboard';
                    $titleMap = [
                        'dashboard' => 'Home',
                        'create' => 'Create',
                        'edit' => 'Edit',
                        'pending' => 'Pending',
                        'social' => 'Social Accounts',
                        'posts' => 'Social Posts',
                    ];
                    $mobileTitle = $titleMap[$lastSegment] ?? \Illuminate\Support\Str::title(str_replace('-', ' ', $lastSegment));
                ?>
                <span class="text-sm font-semibold text-gray-900"><?php echo e($mobileTitle); ?></span>
            </div>
        </div>

        
        <div class="flex items-center gap-2 shrink-0">
            
            <div class="relative">
                <button
                    @click="notifOpen = !notifOpen"
                    class="relative p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-[#F26C4F]"
                    aria-label="Notifications"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                    <?php if($notifCount > 0): ?>
                        <span class="absolute -top-0.5 -right-0.5 w-4.5 h-4.5 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center"><?php echo e($notifCount > 9 ? '9+' : $notifCount); ?></span>
                    <?php endif; ?>
                </button>

                
                <div x-show="notifOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-900">Notifications</span>
                        <a href="<?php echo e(route('sponsor.notifications.index')); ?>" class="text-xs text-terracotta-500 hover:underline">View All</a>
                    </div>
                    <div class="max-h-72 overflow-y-auto divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentNotifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e($notif->action_url ? route('sponsor.notifications.read', $notif) : '#'); ?>" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition <?php echo e(is_null($notif->read_at) ? 'bg-terracotta-50/50' : ''); ?>">
                                <div class="w-8 h-8 rounded-full <?php echo e(is_null($notif->read_at) ? 'bg-terracotta-100' : 'bg-gray-100'); ?> flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 <?php echo e(is_null($notif->read_at) ? 'text-terracotta-500' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($notif->title); ?></p>
                                    <?php if($notif->body): ?>
                                        <p class="text-xs text-gray-500 truncate"><?php echo e($notif->body); ?></p>
                                    <?php endif; ?>
                                    <p class="text-[10px] text-gray-400 mt-0.5"><?php echo e($notif->created_at->diffForHumans()); ?></p>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-4 py-8 text-center text-sm text-gray-500">No notifications</div>
                        <?php endif; ?>
                    </div>
                    <?php if($notifCount > 0): ?>
                        <div class="px-4 py-2 border-t border-gray-100 bg-gray-50">
                            <form action="<?php echo e(route('sponsor.notifications.mark-all-read')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs text-terracotta-500 hover:underline w-full text-center">Mark all as read</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="hidden sm:block w-px h-8 bg-gray-200 mx-1"></div>

            
            <?php if (isset($component)) { $__componentOriginala7e5d5f940d406080d463dd80fbcabc7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala7e5d5f940d406080d463dd80fbcabc7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.profile-dropdown','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.profile-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala7e5d5f940d406080d463dd80fbcabc7)): ?>
<?php $attributes = $__attributesOriginala7e5d5f940d406080d463dd80fbcabc7; ?>
<?php unset($__attributesOriginala7e5d5f940d406080d463dd80fbcabc7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7e5d5f940d406080d463dd80fbcabc7)): ?>
<?php $component = $__componentOriginala7e5d5f940d406080d463dd80fbcabc7; ?>
<?php unset($__componentOriginala7e5d5f940d406080d463dd80fbcabc7); ?>
<?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/components/layout/dashboard-header.blade.php ENDPATH**/ ?>