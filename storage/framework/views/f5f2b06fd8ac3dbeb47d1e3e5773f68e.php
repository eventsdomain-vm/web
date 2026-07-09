<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['items' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(count($items) > 0): ?>
    <nav aria-label="Breadcrumb" class="flex items-center min-w-0">
        <ol class="flex items-center space-x-1 text-sm min-w-0 overflow-hidden">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isLast = $index === array_key_last($items);
                    $isFirst = $index === 0;
                ?>

                
                <?php if(!$isFirst): ?>
                    <li class="flex items-center shrink-0" aria-hidden="true">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </li>
                <?php endif; ?>

                <li class="flex items-center min-w-0 <?php echo e($isLast ? '' : ''); ?>">
                    <?php if($item['href'] && !$isLast): ?>
                        <a
                            href="<?php echo e($item['href']); ?>"
                            class="text-gray-500 hover:text-gray-700 transition truncate max-w-[120px] sm:max-w-[200px]"
                            title="<?php echo e($item['title']); ?>"
                        >
                            <?php echo e($item['title']); ?>

                        </a>
                    <?php else: ?>
                        <span
                            class="text-gray-900 font-semibold truncate <?php echo e($isFirst ? 'text-[#F26C4F]' : ''); ?>"
                            aria-current="<?php echo e($isLast ? 'page' : 'false'); ?>"
                            title="<?php echo e($item['title']); ?>"
                        >
                            
                            <?php if($isFirst && count($items) > 2 && !$isLast): ?>
                                <span class="hidden sm:inline"><?php echo e($item['title']); ?></span>
                                <span class="sm:hidden"><?php echo e($item['title']); ?></span>
                            <?php else: ?>
                                <?php echo e($item['title']); ?>

                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/components/ui/breadcrumb.blade.php ENDPATH**/ ?>