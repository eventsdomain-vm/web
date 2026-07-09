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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Announcements</h2>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Announcement</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card"><p class="text-sm text-gray-500">Total</p><p class="text-2xl font-bold"><?php echo e($stats['total']); ?></p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Published</p><p class="text-2xl font-bold text-green-600"><?php echo e($stats['published']); ?></p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Total Reads</p><p class="text-2xl font-bold"><?php echo e($stats['total_reads']); ?></p></div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card p-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900"><?php echo e($announcement->title); ?></h3>
                        <p class="text-sm text-gray-600 mt-1"><?php echo e(Str::limit($announcement->body, 200)); ?></p>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span>By <?php echo e($announcement->creator->name); ?></span>
                            <span class="badge badge-<?php echo e($announcement->type === 'urgent' ? 'danger' : 'gray'); ?> text-xs"><?php echo e(ucfirst($announcement->type)); ?></span>
                            <span><?php echo e(ucfirst($announcement->audience_type)); ?></span>
                            <?php if($announcement->published_at): ?><span>Published <?php echo e($announcement->published_at->diffForHumans()); ?></span><?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        <?php if($announcement->status === 'draft'): ?>
                            <form method="POST" action="<?php echo e(route('sponsor.announcements.publish', $announcement)); ?>"><?php echo csrf_field(); ?><button type="submit" class="btn-outline text-xs">Publish</button></form>
                        <?php endif; ?>
                        <span class="badge badge-<?php echo e($announcement->status === 'published' ? 'success' : ($announcement->status === 'archived' ? 'gray' : 'warning')); ?>"><?php echo e(ucfirst($announcement->status)); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No announcements yet.</div>
        <?php endif; ?>
        <?php if(method_exists($announcements, 'links')): ?><?php echo e($announcements->links()); ?><?php endif; ?>
    </div>
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">New Announcement</h3>
            <form method="POST" action="<?php echo e(route('sponsor.announcements.store')); ?>"><?php echo csrf_field(); ?>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Body</label><textarea name="body" required class="w-full border-gray-300 rounded-md" rows="4"></textarea></div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full border-gray-300 rounded-md"><option value="general">General</option><option value="campaign_update">Campaign Update</option><option value="contract">Contract</option><option value="team">Team</option><option value="urgent">Urgent</option></select></div>
                    <div><label class="block text-sm font-medium mb-1">Audience</label><select name="audience_type" class="w-full border-gray-300 rounded-md"><option value="internal">Internal</option><option value="cross_org">Cross-Org</option><option value="public">Public</option></select></div>
                </div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/announcements/index.blade.php ENDPATH**/ ?>