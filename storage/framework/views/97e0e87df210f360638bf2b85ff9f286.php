<aside
    x-data="{
        isExpanded: true,
        isMobileOpen: false,
        expandedGroups: JSON.parse(localStorage.getItem('sidebarGroups') || '{}'),
        toggle() {
            if (window.innerWidth < 1024) {
                this.isMobileOpen = !this.isMobileOpen;
            } else {
                this.isExpanded = !this.isExpanded;
            }
        },
        setMobileOpen(val) { this.isMobileOpen = val; },
        toggleGroup(name) {
            this.expandedGroups[name] = !this.expandedGroups[name];
            localStorage.setItem('sidebarGroups', JSON.stringify(this.expandedGroups));
        }
    }"
    @toggle-sidebar.window="toggle()"
    :class="{
        'w-[280px]': isExpanded || isMobileOpen,
        'w-[72px]': !isExpanded && !isMobileOpen,
        'translate-x-0': isMobileOpen,
        '-translate-x-full lg:translate-x-0': !isMobileOpen,
    }"
    class="fixed inset-y-0 left-0 z-40 flex flex-col bg-white border-r border-gray-200 transition-all duration-300 ease-in-out overflow-hidden"
    style="background-color: #ffffff !important;"
>
    
    <div class="h-16 shrink-0 flex items-center px-5 border-b border-gray-200">
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3">
            <img src="<?php echo e(asset('logo.png')); ?>" alt="EventsDomain" class="h-8 w-auto shrink-0">
        </a>
    </div>

    <?php if(auth()->user()->hasRole('admin')): ?>
        <?php if (isset($component)) { $__componentOriginalbebe114f3ccde4b38d7462a3136be045 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbebe114f3ccde4b38d7462a3136be045 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $attributes = $__attributesOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $component = $__componentOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__componentOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
    <?php else: ?>
        <?php
        $groups = [];
        $role = auth()->user()->roles->pluck('name')->first();

        // === DASHBOARD ===
        $groups[] = [
            'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'items' => [['route' => 'dashboard', 'label' => 'Overview']],
        ];

        // === PLAN (sponsor) ===
        $groups[] = [
            'label' => 'Plan', 'icon' => 'M21 13l4-4a1 1 0 01-4 0v0 0-4a1 1 0 010 4m-2 2a1 1 0 012-2 2v4a1 1 0 012 2h4m-2 2a1 1 0 012-2 2v8a1 1 0 012 2h8a1 1 0 011-2v4a1 1 0 011-2m2 2v-2a1 1 0 00-2 2m-6 0a1 1 0 00-6 6', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.plan.objectives', 'label' => 'Objectives'],
                ['route' => 'sponsor.plan.preferences', 'label' => 'Targeting'],
                ['route' => 'sponsor.plan.budgets', 'label' => 'Budget'],
                ['route' => 'sponsor.plan.index', 'label' => 'Sponsor Plan'],
            ],
        ];

        // === PIPELINE (sponsor) ===
        $groups[] = [
            'label' => 'Pipeline', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.proposals.index', 'label' => 'Proposals'],
                ['route' => 'sponsor.pipeline.index', 'label' => 'Deal Pipeline'],
                ['route' => 'sponsor.negotiations.index', 'label' => 'Negotiations'],
            ],
        ];

        // === EXECUTION (sponsor) ===
        $groups[] = [
            'label' => 'Execution', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055zM20.488 9H15V3.512A9.025 9.025 0 0120.488 9z', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.campaigns.index', 'label' => 'Campaigns'],
                ['route' => 'sponsor.contracts.index', 'label' => 'Contracts'],
                ['route' => 'sponsor.budget.index', 'label' => 'Budget'],
                ['route' => 'sponsor.invoices.index', 'label' => 'Invoices'],
                ['route' => 'sponsor.tasks.index', 'label' => 'Tasks'],
                ['route' => 'sponsor.brand-assets.index', 'label' => 'Brand Assets'],
            ],
        ];

        // === COMMUNICATION (sponsor) ===
        $groups[] = [
            'label' => 'Communication', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.messages.index', 'label' => 'Message Center'],
                ['route' => 'sponsor.notifications.index', 'label' => 'Notifications'],
                ['route' => 'sponsor.announcements.index', 'label' => 'Announcements'],
            ],
        ];

        // === ANALYTICS (sponsor) ===
        $groups[] = [
            'label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.analytics.index', 'label' => 'ROI Dashboard'],
                ['route' => 'sponsor.reports.index', 'label' => 'Reports'],
            ],
        ];

        // === ADMINISTRATION (sponsor) ===
        $groups[] = [
            'label' => 'Administration', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z', 'roles' => ['sponsor'],
            'items' => [
                ['route' => 'sponsor.settings.index', 'label' => 'Settings'],
                ['route' => 'sponsor.teams.index', 'label' => 'Teams'],
                ['route' => 'sponsor.documents.index', 'label' => 'Documents'],
                ['route' => 'sponsor.audit-logs.index', 'label' => 'Audit Logs'],
            ],
        ];

        // === ORGANIZER (grouped accordion) ===
        $organizerGroups = [];

        if ($role === 'organizer') {
            $organizerGroups = [
                [
                    'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                    'items' => [['route' => 'organizer.dashboard', 'label' => 'Overview']],
                ],
                [
                    'label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'items' => [
                        ['route' => 'organizer.events.index', 'label' => 'My Events'],
                        ['route' => 'organizer.events.create', 'label' => 'Create Event'],
                        ['route' => 'organizer.post-event.index', 'label' => 'Post-Event Reports'],
                    ],
                ],
                [
                    'label' => 'Sponsors', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'items' => [
                        ['route' => 'organizer.srm.index', 'label' => 'Relationships'],
                        ['route' => 'organizer.renewals.index', 'label' => 'Renewals'],
                    ],
                ],
                [
                    'label' => 'Pipeline', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'items' => [
                        ['route' => 'organizer.acquisition.index', 'label' => 'Sponsor Acquisition'],
                        ['route' => 'organizer.contracts.index', 'label' => 'Contracts'],
                    ],
                ],
                [
                    'label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'items' => [
                        ['route' => 'organizer.reports.index', 'label' => 'Reports Dashboard'],
                    ],
                ],
                [
                    'label' => 'Social', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1',
                    'items' => [
                        ['route' => 'organizer.social.index', 'label' => 'Accounts'],
                        ['route' => 'organizer.posts.index', 'label' => 'Posts'],
                    ],
                ],
                [
                    'label' => 'Administration', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
                    'items' => [
                        ['route' => 'organizer.profile.index', 'label' => 'Organization Profile'],
                        ['route' => 'analytics', 'label' => 'Analytics'],
                        ['route' => 'settings', 'label' => 'Settings'],
                    ],
                ],
            ];
        }

        // === PARTNER (grouped accordion) ===
        $partnerGroups = [];

        // Dashboard
        $partnerGroups[] = [
            'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'items' => [['route' => 'partner.dashboard', 'label' => 'Overview']],
        ];

        // Clients
        $partnerGroups[] = [
            'label' => 'Clients', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
            'items' => [['route' => 'partner.clients.index', 'label' => 'Assigned Clients']],
        ];

        // Discovery
        $partnerGroups[] = [
            'label' => 'Discovery', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            'items' => [
                ['route' => 'partner.opportunities', 'label' => 'Browse Opportunities'],
                ['route' => 'partner.ai-copilot.index', 'label' => 'AI Copilot'],
            ],
        ];

        // Pipeline
        $partnerGroups[] = [
            'label' => 'Pipeline', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
            'items' => [
                ['route' => 'partner.leads.index', 'label' => 'Leads'],
                ['route' => 'partner.deals.index', 'label' => 'Deals'],
            ],
        ];

        // Services
        $partnerGroups[] = [
            'label' => 'Services', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'items' => [
                ['route' => 'partner.services.index', 'label' => 'My Services'],
                ['route' => 'partner.bids.index', 'label' => 'My Bids'],
            ],
        ];

        // Execution
        $partnerGroups[] = [
            'label' => 'Execution', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z',
            'items' => [
                ['route' => 'partner.campaigns.index', 'label' => 'Campaigns'],
                ['route' => 'partner.meetings.index', 'label' => 'Meetings'],
                ['route' => 'partner.tasks.index', 'label' => 'Tasks'],
            ],
        ];

        // Financials
        $partnerGroups[] = [
            'label' => 'Financials', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'items' => [
                ['route' => 'partner.commissions.index', 'label' => 'Commissions'],
                ['route' => 'partner.reports.index', 'label' => 'Reports'],
            ],
        ];

        // Social
        $partnerGroups[] = [
            'label' => 'Social', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1',
            'items' => [
                ['route' => 'partner.social.index', 'label' => 'Accounts'],
                ['route' => 'partner.posts.index', 'label' => 'Posts'],
            ],
        ];

        // Administration
        $partnerGroups[] = [
            'label' => 'Administration', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
            'items' => [
                ['route' => 'partner.settings.index', 'label' => 'Settings'],
                ['route' => 'partner.notifications.index', 'label' => 'Notifications'],
                ['route' => 'enquiries', 'label' => 'Enquiries'],
            ],
        ];

        if ($role === 'partner') {
            $filteredGroups = $partnerGroups;
        } elseif ($role === 'organizer') {
            $filteredGroups = $organizerGroups;
        } else {
            $filteredGroups = [];
        }

        if (!in_array($role, ['sponsor', 'organizer', 'partner'])) {
            $flatItems = [
                ['route' => 'enquiries', 'label' => 'Enquiries', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['route' => 'analytics', 'label' => 'Analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['route' => 'settings', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
        }
        ?>

        <?php
            $allGroups = in_array($role, ['partner', 'organizer']) ? $filteredGroups : $groups;
        ?>

        <nav class="flex-1 overflow-y-auto py-6 px-4 no-scrollbar">
            <div class="flex flex-col gap-0.5">
                <?php $__currentLoopData = $allGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($group['roles']) && !auth()->user()->hasRole($group['roles'])): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php
                        $anyActive = false;
                        foreach ($group['items'] as $gi) {
                            if (request()->routeIs($gi['route'])) { $anyActive = true; break; }
                        }
                    ?>
                    
                    <button type="button"
                        @click="toggleGroup('<?php echo e(addslashes($group['label'])); ?>')"
                        class="flex items-center justify-between w-full px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-600 hover:bg-gray-100 hover:text-gray-900 <?php echo e($anyActive ? 'text-gray-900' : ''); ?>"
                    >
                        <span class="flex items-center gap-3 min-w-0">
                            <svg class="w-5 h-5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($group['icon']); ?>"/>
                            </svg>
                            <span class="whitespace-nowrap"><?php echo e($group['label']); ?></span>
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': expandedGroups['<?php echo e($group['label']); ?>'] }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="expandedGroups['<?php echo e(addslashes($group['label'])); ?>'] ?? true" x-collapse.duration.200ms>
                        <div class="ml-3 pl-3 border-l-2 border-gray-100 space-y-0.5">
                            <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $active = request()->routeIs($item['route']); ?>
                                <a href="<?php echo e(route($item['route'])); ?>"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap <?php echo e($active ? 'bg-[#F26C4F] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'); ?>"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($active ? 'bg-white' : 'bg-gray-300'); ?> shrink-0"></span>
                                    <span class="whitespace-nowrap"><?php echo e($item['label']); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if(!in_array($role, ['sponsor', 'partner', 'organizer'])): ?>
                    <?php $__currentLoopData = $flatItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $active = request()->routeIs($item['route']); ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap <?php echo e($active ? 'bg-[#F26C4F] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'); ?>"
                        >
                            <svg class="w-5 h-5 shrink-0 <?php echo e($active ? 'text-white' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>"/>
                            </svg>
                            <span class="whitespace-nowrap"><?php echo e($item['label']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal8443becd9bc28abf0c54519162ef9c21 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8443becd9bc28abf0c54519162ef9c21 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.sidebar-footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.sidebar-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8443becd9bc28abf0c54519162ef9c21)): ?>
<?php $attributes = $__attributesOriginal8443becd9bc28abf0c54519162ef9c21; ?>
<?php unset($__attributesOriginal8443becd9bc28abf0c54519162ef9c21); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8443becd9bc28abf0c54519162ef9c21)): ?>
<?php $component = $__componentOriginal8443becd9bc28abf0c54519162ef9c21; ?>
<?php unset($__componentOriginal8443becd9bc28abf0c54519162ef9c21); ?>
<?php endif; ?>

    
    <div
        x-show="isMobileOpen"
        @click="setMobileOpen(false)"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-[-1] lg:hidden"
        x-cloak
    ></div>
</aside>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>