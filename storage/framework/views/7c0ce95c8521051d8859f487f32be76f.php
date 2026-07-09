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
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Proposals</h2>
            <p class="text-sm text-gray-500 mt-1">Track and manage your sponsorship proposals with full event context.</p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="space-y-5">
            <?php $__empty_1 = true; $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $event = $proposal->event;
                    $currency = ($event->currency ?? 'INR') === 'INR' ? '₹' : ($event->currency ?? '₹');
                    $start = $event->start_date ? $event->start_date->format('M d, Y') : 'TBA';
                    $end = $event->end_date ? $event->end_date->format('M d, Y') : null;
                    $location = collect([$event->city, $event->state, $event->country])->filter()->implode(', ');
                    $range = ($event->minimum_sponsorship || $event->maximum_sponsorship)
                        ? $currency . number_format($event->minimum_sponsorship ?? 0) . ' – ' . $currency . number_format($event->maximum_sponsorship ?? 0)
                        : '—';
                ?>
                <div class="card overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        
                        <div class="md:w-60 shrink-0 bg-gradient-to-br from-terracotta-500 to-terracotta-700 text-white p-6 flex flex-col justify-between">
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/15 text-xs font-medium capitalize">
                                    <?php echo e(str_replace('_', ' ', $event->event_type ?? 'event')); ?>

                                </span>
                                <?php if($event->category): ?>
                                    <p class="mt-3 text-sm text-white/80"><?php echo e($event->category->name); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="mt-6">
                                <p class="text-xs uppercase tracking-wide text-white/70">Event Date</p>
                                <p class="text-lg font-semibold"><?php echo e($start); ?></p>
                                <?php if($end): ?>
                                    <p class="text-sm text-white/80"><?php echo e($end); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="flex-1 p-6">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate"><?php echo e($event->title ?? 'N/A'); ?></h3>
                                    <?php if($event->tagline): ?>
                                        <p class="text-sm text-gray-500 mt-0.5"><?php echo e($event->tagline); ?></p>
                                    <?php endif; ?>
                                    <?php if($location): ?>
                                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <?php echo e($location); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                                <span class="badge badge-<?php echo e($proposal->status_color); ?> text-xs shrink-0"><?php echo e($proposal->status_label); ?></span>
                            </div>

                            <dl class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4 mt-5">
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Package</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($proposal->package->title ?? 'N/A'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Your Offer</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($currency); ?><?php echo e(number_format($proposal->budget_offer ?? $proposal->package->price ?? 0)); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Sponsorship Range</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($range); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Expected Audience</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($event->expected_audience ? number_format($event->expected_audience) : '—'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Sponsorship Type</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900 capitalize"><?php echo e(str_replace('_', ' ', $event->sponsorship_type ?? '—')); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Submitted</dt>
                                    <dd class="mt-0.5 text-sm font-medium text-gray-900"><?php echo e($proposal->created_at->format('M d, Y')); ?></dd>
                                </div>
                            </dl>

                            <div class="flex items-center justify-end mt-5 pt-4 border-t border-gray-100">
                                <a href="<?php echo e(route('sponsor.proposals.show', $proposal)); ?>" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-1.5">
                                    View Proposal
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="card p-12 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-terracotta-50 text-terracotta-500 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-gray-700 font-medium">No proposals yet</p>
                    <p class="text-sm text-gray-400 mt-1 mb-5">Browse events and submit your first sponsorship proposal.</p>
                    <a href="<?php echo e(route('sponsor.events.index')); ?>" class="btn-primary text-sm px-4 py-2 inline-flex items-center gap-1.5">
                        Browse Events to Sponsor
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if(method_exists($proposals, 'links')): ?>
            <div class="mt-6"><?php echo e($proposals->links()); ?></div>
        <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/proposals/index.blade.php ENDPATH**/ ?>