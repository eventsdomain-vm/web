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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Documents</h2>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary text-sm">+ Upload Document</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6">
        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2"><h3 class="font-semibold text-gray-900"><?php echo e($document->name); ?></h3><span class="badge badge-<?php echo e($document->status === 'final' ? 'success' : 'gray'); ?> text-xs"><?php echo e(ucfirst($document->status)); ?></span></div>
                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                            <span><?php echo e(ucfirst($document->type)); ?></span>
                            <span>Uploaded by <?php echo e($document->uploader->name); ?></span>
                            <span><?php echo e($document->created_at->format('M d, Y')); ?></span>
                            <?php if($document->versions->count()): ?><span><?php echo e($document->versions->count()); ?> versions</span><?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        <?php if($document->status === 'draft'): ?>
                            <form method="POST" action="<?php echo e(route('sponsor.documents.finalize', $document)); ?>"><?php echo csrf_field(); ?><button type="submit" class="btn-outline text-xs">Finalize</button></form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">No documents yet.</div>
        <?php endif; ?>
        <?php if(method_exists($documents, 'links')): ?><?php echo e($documents->links()); ?><?php endif; ?>
    </div>
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Upload Document</h3>
            <form method="POST" action="<?php echo e(route('sponsor.documents.store')); ?>"><?php echo csrf_field(); ?>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full border-gray-300 rounded-md"><option value="proposal">Proposal</option><option value="contract">Contract</option><option value="report">Report</option><option value="creative">Creative</option><option value="legal">Legal</option><option value="other">Other</option></select></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">File Path / URL</label><input type="text" name="file_path" required class="w-full border-gray-300 rounded-md"></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Upload</button></div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/documents/index.blade.php ENDPATH**/ ?>