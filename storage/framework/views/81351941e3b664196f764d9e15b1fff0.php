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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ROI & Performance Dashboard</h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('sponsor.reports.index')); ?>" class="btn-outline text-sm px-3 py-1.5">Reports</a>
                <a href="<?php echo e(route('sponsor.analytics.index')); ?>" class="btn-primary text-sm px-3 py-1.5">Refresh</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Invested</p>
                        <p class="text-2xl font-bold text-terracotta-500">₹<?php echo e(number_format($kpiSummary['total_invested'])); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-terracotta-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Campaigns</p>
                        <p class="text-2xl font-bold text-green-600"><?php echo e($kpiSummary['active_campaigns']); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Average ROI</p>
                        <p class="text-2xl font-bold <?php echo e(($kpiSummary['avg_roi'] ?? 0) >= 0 ? 'text-blue-600' : 'text-red-600'); ?>">
                            <?php echo e($kpiSummary['avg_roi'] ? number_format($kpiSummary['avg_roi'], 1) . '%' : 'N/A'); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Deliverable Completion</p>
                        <p class="text-2xl font-bold text-indigo-600">
                            <?php $pct = $kpiSummary['deliverable_total'] > 0 ? round(($kpiSummary['deliverable_completed'] / $kpiSummary['deliverable_total']) * 100) : 0; ?>
                            <?php echo e($pct); ?>%
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="card lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Spend Trend</h3>
                </div>
                <div class="p-6">
                    <?php if($kpiSummary['monthly_spend']->isNotEmpty()): ?>
                        <div class="space-y-3">
                            <?php $maxSpend = $kpiSummary['monthly_spend']->max(); ?>
                            <?php $__currentLoopData = $kpiSummary['monthly_spend']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600 w-20 shrink-0"><?php echo e($month); ?></span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden">
                                        <div class="bg-terracotta-500 h-4 rounded-full transition-all" style="width: <?php echo e($maxSpend > 0 ? ($total / $maxSpend) * 100 : 0); ?>%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 w-24 text-right">₹<?php echo e(number_format($total)); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm text-center py-8">No paid invoices yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Campaign Summary</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Campaigns</span>
                            <span class="font-semibold"><?php echo e($kpiSummary['total_campaigns']); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Active</span>
                            <span class="font-semibold text-green-600"><?php echo e($kpiSummary['active_campaigns']); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Completed</span>
                            <span class="font-semibold text-blue-600"><?php echo e($kpiSummary['completed_campaigns']); ?></span>
                        </div>
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Budgeted</span>
                                <span class="font-semibold">₹<?php echo e(number_format($kpiSummary['total_budgeted'])); ?></span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-gray-600">Total Spent</span>
                                <span class="font-semibold text-terracotta-500">₹<?php echo e(number_format($kpiSummary['total_spent'])); ?></span>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Active Contracts</span>
                                <span class="font-semibold text-indigo-600"><?php echo e($kpiSummary['active_contracts']); ?></span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-gray-600">Invoices Paid</span>
                                <span class="font-semibold text-green-600"><?php echo e($kpiSummary['paid_invoices']); ?>/<?php echo e($kpiSummary['total_invoices']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Top Performing Campaigns (by ROI)</h3>
            </div>
            <div class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $kpiSummary['top_campaigns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 truncate"><?php echo e($campaign->event?->title ?? 'Campaign #' . $campaign->id); ?></h4>
                            <p class="text-sm text-gray-500">Progress: <?php echo e($campaign->progress); ?>%</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-semibold text-green-600">+<?php echo e(number_format($campaign->roi, 1)); ?>% ROI</span>
                            <a href="<?php echo e(route('sponsor.campaigns.show', $campaign)); ?>" class="text-terracotta-500 hover:underline text-sm">View</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No campaign ROI data yet. Complete some campaigns to see performance here.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Budget Utilization</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $kpiSummary['budgets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium">FY<?php echo e($budget->fiscal_year); ?></span>
                                <span class="text-sm text-gray-500">₹<?php echo e(number_format($budget->remaining)); ?> remaining</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <?php $usedPct = $budget->total_budget > 0 ? (($budget->allocated + $budget->spent) / $budget->total_budget) * 100 : 0; ?>
                                <div class="bg-terracotta-500 h-2.5 rounded-full" style="width: <?php echo e(min($usedPct, 100)); ?>%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>Budget: ₹<?php echo e(number_format($budget->total_budget)); ?></span>
                                <span>Utilized: <?php echo e(number_format($usedPct, 1)); ?>%</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center text-gray-500 text-sm">No budgets configured.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Invoice Status</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $kpiSummary['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm"><?php echo e($invoice->invoice_number ?? 'Invoice #' . $invoice->id); ?></h4>
                                <p class="text-xs text-gray-500">₹<?php echo e(number_format($invoice->total)); ?> due <?php echo e($invoice->due_date?->format('M d, Y')); ?></p>
                            </div>
                            <span class="badge badge-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning')); ?> text-xs"><?php echo e(ucfirst($invoice->status)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center text-gray-500 text-sm">No invoices yet.</div>
                    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/analytics/index.blade.php ENDPATH**/ ?>