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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
            <div class="flex items-center gap-2">
                <?php if($unreadCount > 0): ?>
                    <span class="badge badge-danger text-sm"><?php echo e($unreadCount); ?> unread</span>
                    <form action="<?php echo e(route('sponsor.notifications.mark-all-read')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-outline text-sm px-3 py-1.5">Mark All Read</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card hover:shadow-sm transition <?php echo e(is_null($notification->read_at) ? 'border-l-4 border-l-terracotta-500' : ''); ?>">
                <div class="px-6 py-4 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full <?php echo e(is_null($notification->read_at) ? 'bg-terracotta-100' : 'bg-gray-100'); ?> flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 <?php echo e(is_null($notification->read_at) ? 'text-terracotta-500' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-sm text-gray-900"><?php echo e($notification->title); ?></h4>
                            <span class="text-xs text-gray-400"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                        </div>
                        <?php if($notification->body): ?>
                            <p class="text-sm text-gray-600 mt-0.5"><?php echo e($notification->body); ?></p>
                        <?php endif; ?>
                        <div class="flex items-center gap-2 mt-2">
                            <?php if($notification->action_url): ?>
                                <a href="<?php echo e(route('sponsor.notifications.read', $notification)); ?>" class="text-xs text-terracotta-500 hover:underline font-medium"><?php echo e($notification->action_label ?? 'View Details'); ?></a>
                            <?php endif; ?>
                            <?php if(is_null($notification->read_at)): ?>
                                <a href="<?php echo e(route('sponsor.notifications.read', $notification)); ?>" class="text-xs text-gray-500 hover:underline">Mark read</a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('sponsor.notifications.dismiss', $notification)); ?>" class="text-xs text-gray-400 hover:text-red-500 hover:underline">Dismiss</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-12 text-center">
                <p class="text-gray-500">No notifications yet.</p>
                <p class="text-sm text-gray-400 mt-1">You will receive notifications for important updates and actions.</p>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <?php if(method_exists($notifications, 'links')): ?><?php echo e($notifications->links()); ?><?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/notifications/index.blade.php ENDPATH**/ ?>