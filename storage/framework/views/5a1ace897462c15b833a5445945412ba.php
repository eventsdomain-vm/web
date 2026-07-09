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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Welcome back, <?php echo e(auth()->user()->company_name ?? auth()->user()->name); ?>

            </h2>
            <p class="text-sm text-gray-500">Sponsor Dashboard</p>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if($budget): ?>
    <div class="card p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">FY<?php echo e($budget->fiscal_year); ?> Budget</span>
            <span class="text-sm font-bold text-gray-900">₹<?php echo e(number_format($budget->remaining)); ?> remaining</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2.5">
            <?php $used = $budget->total_budget > 0 ? (($budget->allocated + $budget->spent) / $budget->total_budget) * 100 : 0; ?>
            <div class="bg-terracotta-500 h-2.5 rounded-full transition-all" style="width: <?php echo e(min($used, 100)); ?>%"></div>
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-1">
            <span>Budget: ₹<?php echo e(number_format($budget->total_budget)); ?></span>
            <span>Utilized: <?php echo e(number_format($used, 1)); ?>%</span>
        </div>
    </div>
    <?php endif; ?>

    <div class="space-y-6">
        <div class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Sponsorships</p>
                            <p class="text-3xl font-bold text-green-600"><?php echo e($stats['active_sponsorships']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Proposals</p>
                            <p class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending_requests']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Negotiating</p>
                            <p class="text-3xl font-bold text-blue-600"><?php echo e($stats['negotiating']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Invested</p>
                            <p class="text-3xl font-bold text-terracotta-500">₹<?php echo e(number_format($stats['total_invested'])); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-terracotta-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Active Contracts</p>
                            <p class="text-3xl font-bold text-indigo-600"><?php echo e($stats['active_contracts']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Upcoming Payments</p>
                            <p class="text-3xl font-bold text-blue-600">₹<?php echo e(number_format($stats['upcoming_payments'])); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Overdue Invoices</p>
                            <p class="text-3xl font-bold text-red-600"><?php echo e($stats['overdue_invoices']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Tasks</p>
                            <p class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending_tasks']); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Saved Events</h3>
                        <a href="<?php echo e(route('sponsor.saved.index')); ?>" class="text-sm text-terracotta-500 hover:underline">View All (<?php echo e($stats['saved_count']); ?>)</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $savedEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate"><?php echo e($saved->event->title); ?></h4>
                                        <p class="text-sm text-gray-500 truncate"><?php echo e($saved->event->city); ?>, <?php echo e($saved->event->start_date?->format('M d, Y')); ?></p>
                                    </div>
                                    <a href="<?php echo e(route('sponsor.events.show', $saved->event)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium ml-3 shrink-0">View</a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-6 py-8 text-center text-gray-500 text-sm">No saved events yet. <a href="<?php echo e(route('sponsor.events.index')); ?>" class="text-terracotta-500 hover:underline">Browse events</a></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Active Campaigns</h3>
                        <?php if($stats['active_campains'] ?? 0): ?>
                            <span class="text-sm text-gray-500"><?php echo e($stats['active_campaigns'] ?? 0); ?> running</span>
                        <?php endif; ?>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentCampaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate"><?php echo e($campaign->event->title); ?></h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 max-w-[120px]">
                                                <div class="bg-terracotta-500 h-1.5 rounded-full" style="width: <?php echo e($campaign->progress); ?>%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500"><?php echo e($campaign->progress); ?>%</span>
                                        </div>
                                    </div>
                                    <span class="badge badge-<?php echo e($campaign->status === 'active' ? 'success' : 'gray'); ?> text-xs"><?php echo e(ucfirst($campaign->status)); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-6 py-8 text-center text-gray-500 text-sm">No active campaigns.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Proposals</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentProposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate"><?php echo e($proposal->event->title ?? 'Event'); ?></h4>
                                        <p class="text-sm text-gray-500"><?php echo e($proposal->package->title ?? 'No package'); ?> • ₹<?php echo e(number_format($proposal->budget_offer ?? 0)); ?></p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="badge badge-<?php echo e($proposal->status_color); ?> text-xs"><?php echo e($proposal->status_label); ?></span>
                                        <a href="<?php echo e(route('sponsor.proposals.show', $proposal)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-6 py-8 text-center text-gray-500 text-sm">No proposals yet.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Requests</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate"><?php echo e($request->event->title ?? 'Event N/A'); ?></h4>
                                        <p class="text-sm text-gray-500"><?php echo e($request->package->title ?? 'N/A'); ?> • ₹<?php echo e(number_format($request->package->price ?? 0)); ?></p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="badge badge-<?php echo e($request->status_color); ?> text-xs"><?php echo e($request->status_label); ?></span>
                                        <a href="<?php echo e(route('sponsor.requests.show', $request)); ?>" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="px-6 py-8 text-center text-gray-500 text-sm">No requests yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo e(route('sponsor.events.index')); ?>" class="btn-primary inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Browse Events
                    </a>
                    <a href="<?php echo e(route('sponsor.campaigns.index')); ?>" class="btn-outline inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                        Campaigns
                    </a>
                    <a href="<?php echo e(route('sponsor.contracts.index')); ?>" class="btn-outline inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Contracts
                    </a>
                    <a href="<?php echo e(route('sponsor.invoices.index')); ?>" class="btn-outline inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        Invoices
                    </a>
                    <a href="<?php echo e(route('sponsor.tasks.index')); ?>" class="btn-outline inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        Tasks
                    </a>
                    <a href="<?php echo e(route('sponsor.teams.index')); ?>" class="btn-outline inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                        Teams
                    </a>
                </div>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/dashboard.blade.php ENDPATH**/ ?>