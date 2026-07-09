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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Message Center</h2>
            <?php if($unreadCount > 0): ?>
                <span class="badge badge-danger text-sm"><?php echo e($unreadCount); ?> unread</span>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card lg:col-span-1">
            <div class="px-4 py-3 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Conversations</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('sponsor.messages.show', $conv->user)); ?>" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition <?php echo e($conv->unread_count > 0 ? 'bg-blue-50/50' : ''); ?>">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center shrink-0">
                            <span class="text-sm font-medium text-gray-600"><?php echo e(strtoupper(substr($conv->user->name, 0, 2))); ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-sm text-gray-900 truncate"><?php echo e($conv->user->name); ?></h4>
                                <?php if($conv->last_message): ?>
                                    <span class="text-xs text-gray-400"><?php echo e($conv->last_message->created_at->diffForHumans()); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs text-gray-500 truncate"><?php echo e($conv->last_message?->body ?? 'No messages yet'); ?></p>
                        </div>
                        <?php if($conv->unread_count > 0): ?>
                            <span class="w-5 h-5 rounded-full bg-terracotta-500 text-white text-xs flex items-center justify-center"><?php echo e($conv->unread_count); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-4 py-8 text-center text-gray-500 text-sm">No conversations yet.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">All Messages</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition <?php echo e(is_null($message->read_at) && $message->recipient_id === auth()->id() ? 'bg-blue-50/50' : ''); ?>">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-sm text-gray-900"><?php echo e($message->sender->name); ?></span>
                                    <span class="text-xs text-gray-400"><?php echo e($message->created_at->format('M d, Y H:i')); ?></span>
                                    <?php if(is_null($message->read_at) && $message->recipient_id === auth()->id()): ?>
                                        <span class="w-2 h-2 rounded-full bg-terracotta-500"></span>
                                    <?php endif; ?>
                                </div>
                                <?php if($message->subject): ?>
                                    <p class="text-sm font-medium text-gray-700 mt-0.5"><?php echo e($message->subject); ?></p>
                                <?php endif; ?>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2"><?php echo e(Str::limit($message->body, 200)); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No messages. Start a conversation with a team member or organizer.</div>
                <?php endif; ?>
            </div>
            <div class="px-6 py-3 border-t border-gray-100">
                <?php if(method_exists($messages, 'links')): ?><?php echo e($messages->links()); ?><?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/messages/index.blade.php ENDPATH**/ ?>