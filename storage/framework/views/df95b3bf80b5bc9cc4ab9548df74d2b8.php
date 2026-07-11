<?php
    $currentRoute = request()->route()->getName();

    function isActiveRoute($route): bool {
        if (request()->routeIs($route)) return true;
        if (request()->routeIs($route . '.*')) return true;
        return false;
    }

    function isSubmenuActive($items): bool {
        foreach ($items as $item) {
            if (isset($item['route']) && isActiveRoute($item['route'])) {
                if (!isset($item['query'])) return true;
                $expectedQuery = [];
                parse_str($item['query'], $expectedQuery);
                foreach ($expectedQuery as $k => $v) {
                    if ((request()->query($k) ?? '') !== $v) continue 2;
                }
                return true;
            }
        }
        return false;
    }

    function isSubItemActive($item): bool {
        if (!isset($item['route']) || !request()->routeIs($item['route'])) return false;
        if (!isset($item['query'])) return true;
        $expectedQuery = [];
        parse_str($item['query'], $expectedQuery);
        foreach ($expectedQuery as $k => $v) {
            if ((request()->query($k) ?? '') !== $v) return false;
        }
        return true;
    }

    $adminNavItems = [
        [
            'group' => 'Main',
            'items' => [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ],
        ],
        [
            'group' => 'Management',
            'items' => [
                ['route' => 'admin.events', 'label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route' => 'admin.organizers.index', 'label' => 'Organizers', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['route' => 'admin.users', 'label' => 'Users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'admin.categories', 'label' => 'Categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['route' => 'admin.sponsorships', 'label' => 'Sponsorships', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route' => 'admin.contracts.index', 'label' => 'Contracts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['route' => 'admin.payments', 'label' => 'Payments', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ['route' => 'admin.srm.index', 'label' => 'Sponsor Relations', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['route' => 'admin.renewals.index', 'label' => 'Renewals', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                ['route' => 'admin.post-events.index', 'label' => 'Post-Event Reports', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ],
        ],
        [
            'group' => 'Partners',
            'items' => [
                ['route' => 'admin.partners', 'label' => 'Partners', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['route' => 'admin.partner-services.index', 'label' => 'Services', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['route' => 'admin.partner-bids.index', 'label' => 'Bids', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'admin.partner-leads.index', 'label' => 'Leads', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055zM17 5h-2l-1.5 2-1-2H8l2 3-2 3h3.5l1 2H14l-1-2 2-3h-2.5l-1-2h3l1 2 1-2z'],
                ['route' => 'admin.partner-deals.index', 'label' => 'Deals', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route' => 'admin.partner-campaigns.index', 'label' => 'Campaigns', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                ['route' => 'admin.partner-meetings.index', 'label' => 'Meetings', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route' => 'admin.partner-tasks.index', 'label' => 'Tasks', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ['route' => 'admin.partner-commissions.index', 'label' => 'Commissions', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route' => 'admin.partner-clients.index', 'label' => 'Client Assignments', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ],
        ],
        [
            'group' => 'Social',
            'items' => [
                ['route' => 'admin.social.accounts', 'label' => 'Social Accounts', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                ['route' => 'admin.social.posts', 'label' => 'Social Posts', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ],
        ],
        [
            'group' => 'Content',
            'items' => [
                ['route' => 'admin.cms', 'label' => 'CMS Pages', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['route' => 'admin.roles', 'label' => 'Roles & Permissions', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                [
                    'label' => 'SEO',
                    'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                    'submenu' => [
                        ['route' => 'admin.seo.dashboard', 'label' => 'Dashboard'],
                        ['route' => 'admin.seo.settings', 'label' => 'Settings'],
                        ['route' => 'admin.seo.audit', 'label' => 'Audit'],
                        ['route' => 'admin.seo.sitemap', 'label' => 'Sitemap'],
                        ['route' => 'admin.seo.robots', 'label' => 'Robots.txt'],
                        ['route' => 'admin.seo.redirects', 'label' => 'Redirects'],
                        ['route' => 'admin.seo.schema', 'label' => 'Schema Markup'],
                    ],
                ],
            ],
        ],
        [
            'group' => 'Security & Integrations',
            'items' => [
                ['route' => 'admin.roles', 'label' => 'Roles & Permissions', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                [
                    'label' => 'Access & Configuration',
                    'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                    'submenu' => [
                        ['route' => 'admin.settings', 'label' => 'Security', 'query' => 'tab=security'],
                        ['route' => 'admin.settings', 'label' => 'Integrations', 'query' => 'tab=integrations'],
                        ['route' => 'admin.settings', 'label' => 'Social Login', 'query' => 'tab=social-login'],
                        ['route' => 'admin.settings', 'label' => 'API Keys', 'query' => 'tab=api-keys'],
                        ['route' => 'admin.settings', 'label' => 'SMS & WhatsApp', 'query' => 'tab=sms'],
                    ],
                ],
            ],
        ],
        [
            'group' => 'System',
            'items' => [
                ['route' => 'admin.reports', 'label' => 'Reports', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['route' => 'admin.logs', 'label' => 'Activity Logs', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                [
                    'label' => 'Settings',
                    'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
                    'route' => 'admin.settings',
                    'submenu' => [
                        ['route' => 'admin.settings', 'label' => 'General', 'query' => 'tab=general'],
                        ['route' => 'admin.settings', 'label' => 'Branding', 'query' => 'tab=branding'],
                        ['route' => 'admin.settings', 'label' => 'Social Links', 'query' => 'tab=social'],
                        ['route' => 'admin.settings', 'label' => 'Social Login', 'query' => 'tab=social-login'],
                        ['route' => 'admin.settings', 'label' => 'Integrations', 'query' => 'tab=integrations'],
                        ['route' => 'admin.settings', 'label' => 'AI Config', 'query' => 'tab=ai'],
                        ['route' => 'admin.settings', 'label' => 'Email', 'query' => 'tab=email'],
                        ['route' => 'admin.settings', 'label' => 'Sponsorship', 'query' => 'tab=sponsorship'],
                        ['route' => 'admin.settings', 'label' => 'Maintenance', 'query' => 'tab=maintenance'],
                        ['route' => 'admin.settings', 'label' => 'SMS & WhatsApp', 'query' => 'tab=sms'],
                        ['route' => 'admin.settings', 'label' => 'Backup', 'query' => 'tab=backup'],
                        ['route' => 'admin.settings', 'label' => 'Notifications', 'query' => 'tab=notifications'],
                        ['route' => 'admin.settings', 'label' => 'Feature Flags', 'query' => 'tab=features'],
                        ['route' => 'admin.settings', 'label' => 'Performance', 'query' => 'tab=performance'],
                        ['route' => 'admin.settings', 'label' => 'Security', 'query' => 'tab=security'],
                        ['route' => 'admin.settings', 'label' => 'Cache', 'query' => 'tab=cache'],
                        ['route' => 'admin.settings', 'label' => 'API Keys', 'query' => 'tab=api-keys'],
                        ['route' => 'admin.settings', 'label' => 'Payment', 'query' => 'tab=payment'],
                        ['route' => 'admin.settings', 'label' => 'GST', 'query' => 'tab=gst'],
                        ['route' => 'admin.settings', 'label' => 'Storage', 'query' => 'tab=storage'],
                    ],
                ],
            ],
        ],
    ];
?>

<nav class="flex-1 overflow-y-auto py-6 px-4 no-scrollbar">
    <div class="flex flex-col gap-6">
        <?php $__currentLoopData = $adminNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <h3 class="mb-3 px-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    <?php echo e($group['group']); ?>

                </h3>
                <ul class="flex flex-col gap-0.5">
                    <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $hasSubmenu = isset($item['submenu']) && isSubmenuActive($item['submenu']); ?>
                        <li x-data="{ open: <?php echo \Illuminate\Support\Js::from($hasSubmenu)->toHtml() ?> }">
                            <?php if(isset($item['submenu'])): ?>
                                <button
                                    @click="open = !open"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition group <?php echo e(isSubmenuActive($item['submenu']) ? 'bg-[#F26C4F]/10 text-[#E35336]' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'); ?>"
                                >
                                    <svg class="w-5 h-5 shrink-0 <?php echo e(isSubmenuActive($item['submenu']) ? 'text-[#E35336]' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>"/>
                                    </svg>
                                    <span class="flex-1 text-left"><?php echo e($item['label']); ?></span>
                                    <svg class="w-4 h-4 transition-transform duration-200 <?php echo e(isSubmenuActive($item['submenu']) ? 'text-[#E35336]' : 'text-gray-400'); ?>" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <ul x-show="open" x-collapse.duration.200ms class="mt-0.5 space-y-0.5 ml-4">
                                    <?php $__currentLoopData = $item['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $subActive = isSubItemActive($subItem); ?>
                                        <li>
                                                <a
                                                    href="<?php echo e(route($subItem['route'])); ?><?php echo e(isset($subItem['query']) ? '?' . $subItem['query'] : ''); ?>"
                                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition <?php echo e($subActive ? 'bg-[#F26C4F] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900'); ?>"
                                            >
                                                <span class="w-1.5 h-1.5 rounded-full <?php echo e($subActive ? 'bg-white' : 'bg-gray-300'); ?>"></span>
                                                <?php echo e($subItem['label']); ?>

                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <?php $active = isActiveRoute($item['route']); ?>
                                <a
                                    href="<?php echo e(route($item['route'])); ?>"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?php echo e($active ? 'bg-[#F26C4F] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'); ?>"
                                >
                                    <svg class="w-5 h-5 shrink-0 <?php echo e($active ? 'text-white' : 'text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>"/>
                                    </svg>
                                    <?php echo e($item['label']); ?>

                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/components/admin/sidebar.blade.php ENDPATH**/ ?>