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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Brand Assets</h2>
            <button onclick="document.getElementById('createBrandModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Brand</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6 space-y-6">
        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card p-4"><div class="flex items-center justify-between mb-3"><h3 class="font-semibold text-lg"><?php echo e($brand->name); ?> <?php if($brand->is_primary): ?><span class="badge badge-success text-xs ml-2">Primary</span><?php endif; ?></h3></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <?php $__currentLoopData = $brand->assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border rounded-lg p-3 text-center hover:shadow-sm transition">
                            <div class="w-full h-20 bg-gray-50 rounded mb-2 flex items-center justify-center text-gray-400 text-xs"><?php echo e($asset->type); ?></div>
                            <p class="text-sm font-medium truncate"><?php echo e($asset->name); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(ucfirst($asset->type)); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Upload Asset</h3>
            <form method="POST" action="<?php echo e(route('sponsor.brand-assets.assets.store')); ?>" class="flex flex-wrap gap-3"><?php echo csrf_field(); ?>
                <select name="brand_id" required class="border-gray-300 rounded-md text-sm"><option value="">Select brand...</option><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                <input type="text" name="name" placeholder="Asset name" required class="border-gray-300 rounded-md text-sm">
                <select name="type" required class="border-gray-300 rounded-md text-sm"><option value="logo">Logo</option><option value="banner">Banner</option><option value="video">Video</option><option value="document">Document</option><option value="social_post">Social Post</option><option value="other">Other</option></select>
                <input type="text" name="file_path" placeholder="File path / URL" required class="border-gray-300 rounded-md text-sm flex-1">
                <button type="submit" class="btn-primary text-sm">Upload</button>
            </form>
        </div>
    </div>
    <div id="createBrandModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Brand</h3>
            <form method="POST" action="<?php echo e(route('sponsor.brand-assets.brands.store')); ?>"><?php echo csrf_field(); ?>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Brand Name</label><input type="text" name="name" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Tagline</label><input type="text" name="tagline" class="w-full border-gray-300 rounded-md"></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createBrandModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/brand-assets/index.blade.php ENDPATH**/ ?>