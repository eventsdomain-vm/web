<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="linkedin-domain-verification" content="2d2f2b43-b1ae-4cb8-8d61-d250c749e174">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'EventsDomain - Your Event Dashboard'); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'EventsDomain')); ?> - Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo $__env->make('partials.tracking-head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>[x-cloak]{display:none!important}</style>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-gray-50/50">
    <div class="flex h-screen overflow-hidden">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex flex-col flex-1 min-w-0 lg:pl-[280px] transition-all duration-300 ease-in-out">
            
            <?php if (isset($component)) { $__componentOriginala073c8e31b5b2d3117a06e360164e919 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala073c8e31b5b2d3117a06e360164e919 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.dashboard-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.dashboard-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala073c8e31b5b2d3117a06e360164e919)): ?>
<?php $attributes = $__attributesOriginala073c8e31b5b2d3117a06e360164e919; ?>
<?php unset($__attributesOriginala073c8e31b5b2d3117a06e360164e919); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala073c8e31b5b2d3117a06e360164e919)): ?>
<?php $component = $__componentOriginala073c8e31b5b2d3117a06e360164e919; ?>
<?php unset($__componentOriginala073c8e31b5b2d3117a06e360164e919); ?>
<?php endif; ?>

            
            <?php if(isset($header)): ?>
            <div class="bg-white border-b border-gray-100 px-6 py-3 shrink-0">
                <?php echo e($header); ?>

            </div>
            <?php endif; ?>

            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/layouts/app.blade.php ENDPATH**/ ?>