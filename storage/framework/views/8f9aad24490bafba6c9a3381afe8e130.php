<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e($meta_description ?? 'EventsDomain - India\'s B2B Event Sponsorship & Partnership Marketplace'); ?>">
    <title><?php echo e($title ?? config('app.name', 'EventsDomain')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
    <?php echo $__env->make('partials.tracking-head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>[x-cloak]{display:none!important}</style>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen flex flex-col">
        <?php if (isset($component)) { $__componentOriginal2669d93ac3865159955b6d09c48349b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2669d93ac3865159955b6d09c48349b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2669d93ac3865159955b6d09c48349b9)): ?>
<?php $attributes = $__attributesOriginal2669d93ac3865159955b6d09c48349b9; ?>
<?php unset($__attributesOriginal2669d93ac3865159955b6d09c48349b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2669d93ac3865159955b6d09c48349b9)): ?>
<?php $component = $__componentOriginal2669d93ac3865159955b6d09c48349b9; ?>
<?php unset($__componentOriginal2669d93ac3865159955b6d09c48349b9); ?>
<?php endif; ?>

        <main class="flex-1 pt-16 lg:pt-18">
            <?php echo e($slot); ?>

        </main>

        <?php if (isset($component)) { $__componentOriginal2702f386a0a6c0cb365c22db0bdb7e06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2702f386a0a6c0cb365c22db0bdb7e06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public-footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2702f386a0a6c0cb365c22db0bdb7e06)): ?>
<?php $attributes = $__attributesOriginal2702f386a0a6c0cb365c22db0bdb7e06; ?>
<?php unset($__attributesOriginal2702f386a0a6c0cb365c22db0bdb7e06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2702f386a0a6c0cb365c22db0bdb7e06)): ?>
<?php $component = $__componentOriginal2702f386a0a6c0cb365c22db0bdb7e06; ?>
<?php unset($__componentOriginal2702f386a0a6c0cb365c22db0bdb7e06); ?>
<?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/layouts/guest.blade.php ENDPATH**/ ?>