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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
            <button onclick="document.getElementById('createTaskModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Task</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6">
        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <form method="POST" action="<?php echo e(route('sponsor.tasks.update', $task)); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="<?php echo e($task->status === 'done' ? 'todo' : 'done'); ?>">
                            <button type="submit" class="w-5 h-5 rounded-full border-2 flex items-center justify-center <?php echo e($task->status === 'done' ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-terracotta-500'); ?>">
                                <?php if($task->status === 'done'): ?><svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg><?php endif; ?>
                            </button>
                        </form>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium <?php echo e($task->status === 'done' ? 'line-through text-gray-400' : 'text-gray-900'); ?>"><?php echo e($task->title); ?></p>
                            <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                <?php if($task->campaign): ?><span><?php echo e($task->campaign->event?->title ?? 'Campaign'); ?></span><?php endif; ?>
                                <?php if($task->due_date): ?><span>Due: <?php echo e($task->due_date->format('M d')); ?></span><?php endif; ?>
                                <span class="badge badge-<?php echo e($task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'gray')); ?> text-xs"><?php echo e(ucfirst($task->priority)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        <?php $__currentLoopData = $task->assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs bg-gray-100 rounded-full px-2 py-1"><?php echo e($assignee->user->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge badge-<?php echo e($task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'gray')); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No tasks yet.</div>
        <?php endif; ?>
        <?php if(method_exists($tasks, 'links')): ?>
            <?php echo e($tasks->links()); ?>

        <?php endif; ?>
    </div>
    <div id="createTaskModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Task</h3>
            <form method="POST" action="<?php echo e(route('sponsor.tasks.store')); ?>"><?php echo csrf_field(); ?>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea></div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div><label class="block text-sm font-medium mb-1">Priority</label><select name="priority" class="w-full border-gray-300 rounded-md"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option><option value="urgent">Urgent</option></select></div>
                    <div><label class="block text-sm font-medium mb-1">Due Date</label><input type="date" name="due_date" class="w-full border-gray-300 rounded-md"></div>
                </div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createTaskModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
            </form>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/tasks/index.blade.php ENDPATH**/ ?>