<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user' => null, 'size' => 'w-10 h-10', 'fontSize' => 'text-sm']));

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

foreach (array_filter((['user' => null, 'size' => 'w-10 h-10', 'fontSize' => 'text-sm']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $displayUser = $user ?? auth()->user();
    $hasAvatar = $displayUser && !empty($displayUser->avatar);
    $initials = '';
    if ($displayUser && $displayUser->name) {
        $words = explode(' ', trim($displayUser->name));
        if (count($words) >= 2) {
            $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(mb_substr($displayUser->name, 0, 2));
        }
    }
?>

<?php if($hasAvatar): ?>
    <img
        src="<?php echo e($displayUser->avatar); ?>"
        alt="<?php echo e($displayUser->name ?? 'User'); ?>"
        <?php echo e($attributes->merge(['class' => "$size rounded-full object-cover ring-2 ring-white shadow-sm"])); ?>

    >
<?php elseif($initials): ?>
    <div
        <?php echo e($attributes->merge(['class' => "$size rounded-full bg-gradient-to-br from-[#F26C4F] to-[#E35336] text-white flex items-center justify-center font-bold $fontSize ring-2 ring-white shadow-sm"])); ?>

        aria-hidden="true"
    >
        <?php echo e($initials); ?>

    </div>
<?php else: ?>
    <img
        src="<?php echo e(asset('images/default-avatar.png')); ?>"
        alt="<?php echo e($displayUser->name ?? 'User'); ?>"
        <?php echo e($attributes->merge(['class' => "$size rounded-full object-cover ring-2 ring-white shadow-sm"])); ?>

    >
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/components/ui/user-avatar.blade.php ENDPATH**/ ?>