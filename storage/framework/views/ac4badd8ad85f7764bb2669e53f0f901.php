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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Events</h2>
            <p class="text-sm text-gray-500"><?php echo e(method_exists($events, 'total') ? $events->total() : $events->count()); ?> event<?php echo e((method_exists($events, 'total') ? $events->total() : $events->count()) !== 1 ? 's' : ''); ?> available</p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card p-5 mb-6" x-data="{ advanced: <?php echo e(request()->anyFilled(['budget_min','budget_max','audience_min','audience_max','target_age_group','target_gender','venue_type','ticket_price_min','ticket_price_max','has_celebrity','has_govt_support','has_media_coverage','instagram_reach_min','youtube_reach_min','website_traffic_min','start_from','start_to', 'city']) ? 'true' : 'false'); ?> }">
        <form method="GET">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="input-group mb-0 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                    <select name="category" class="input-field">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[140px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sponsorship</label>
                    <select name="sponsorship_type" class="input-field">
                        <option value="">All Types</option>
                        <option value="paid" <?php echo e(request('sponsorship_type') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="barter" <?php echo e(request('sponsorship_type') === 'barter' ? 'selected' : ''); ?>>Barter / In-Kind</option>
                        <option value="hybrid" <?php echo e(request('sponsorship_type') === 'hybrid' ? 'selected' : ''); ?>>Paid + Barter</option>
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">City</label>
                    <select name="city" class="input-field">
                        <option value="">All Cities</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c); ?>" <?php echo e(request('city') === $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[200px] flex-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Search</label>
                    <input type="text" name="search" placeholder="Search events..." value="<?php echo e(request('search')); ?>" class="input-field">
                </div>
                <button type="submit" class="btn-primary">Search</button>
                <button type="button" @click="advanced = !advanced" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    <svg class="w-4 h-4" :class="{ 'rotate-180': advanced }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Filters
                </button>
                <?php if(request()->anyFilled(['category', 'sponsorship_type', 'search', 'budget_min', 'budget_max', 'audience_min', 'audience_max', 'city'])): ?>
                    <a href="<?php echo e(route('sponsor.events.index')); ?>" class="text-sm text-red-500 hover:text-red-700">Clear All</a>
                <?php endif; ?>
            </div>

            <div x-show="advanced" x-collapse class="mt-4 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Age Group</label>
                        <select name="target_age_group" class="input-field">
                            <option value="">Any Age</option>
                            <option value="children" <?php echo e(request('target_age_group') === 'children' ? 'selected' : ''); ?>>Children (0-12)</option>
                            <option value="teens" <?php echo e(request('target_age_group') === 'teens' ? 'selected' : ''); ?>>Teens (13-19)</option>
                            <option value="young_adults" <?php echo e(request('target_age_group') === 'young_adults' ? 'selected' : ''); ?>>Young Adults (20-30)</option>
                            <option value="adults" <?php echo e(request('target_age_group') === 'adults' ? 'selected' : ''); ?>>Adults (31-50)</option>
                            <option value="seniors" <?php echo e(request('target_age_group') === 'seniors' ? 'selected' : ''); ?>>Seniors (50+)</option>
                            <option value="all" <?php echo e(request('target_age_group') === 'all' ? 'selected' : ''); ?>>All Ages</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Gender</label>
                        <select name="target_gender" class="input-field">
                            <option value="">Any</option>
                            <option value="male" <?php echo e(request('target_gender') === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(request('target_gender') === 'female' ? 'selected' : ''); ?>>Female</option>
                            <option value="all" <?php echo e(request('target_gender') === 'all' ? 'selected' : ''); ?>>All</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Venue Type</label>
                        <select name="venue_type" class="input-field">
                            <option value="">Any Venue</option>
                            <option value="indoor" <?php echo e(request('venue_type') === 'indoor' ? 'selected' : ''); ?>>Indoor</option>
                            <option value="outdoor" <?php echo e(request('venue_type') === 'outdoor' ? 'selected' : ''); ?>>Outdoor</option>
                            <option value="hybrid" <?php echo e(request('venue_type') === 'hybrid' ? 'selected' : ''); ?>>Hybrid</option>
                            <option value="virtual" <?php echo e(request('venue_type') === 'virtual' ? 'selected' : ''); ?>>Virtual</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date From</label>
                        <input type="date" name="start_from" value="<?php echo e(request('start_from')); ?>" class="input-field">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget Min (₹)</label>
                        <input type="number" name="budget_min" min="0" step="0.01" value="<?php echo e(request('budget_min')); ?>" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget Max (₹)</label>
                        <input type="number" name="budget_max" min="0" step="0.01" value="<?php echo e(request('budget_max')); ?>" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Audience Min</label>
                        <input type="number" name="audience_min" min="0" value="<?php echo e(request('audience_min')); ?>" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Audience Max</label>
                        <input type="number" name="audience_max" min="0" value="<?php echo e(request('audience_max')); ?>" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ticket Price Min (₹)</label>
                        <input type="number" name="ticket_price_min" min="0" step="0.01" value="<?php echo e(request('ticket_price_min')); ?>" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ticket Price Max (₹)</label>
                        <input type="number" name="ticket_price_max" min="0" step="0.01" value="<?php echo e(request('ticket_price_max')); ?>" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Instagram Reach Min</label>
                        <input type="number" name="instagram_reach_min" min="0" value="<?php echo e(request('instagram_reach_min')); ?>" class="input-field" placeholder="Min followers">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">YouTube Reach Min</label>
                        <input type="number" name="youtube_reach_min" min="0" value="<?php echo e(request('youtube_reach_min')); ?>" class="input-field" placeholder="Min subscribers">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Website Traffic Min</label>
                        <input type="number" name="website_traffic_min" min="0" value="<?php echo e(request('website_traffic_min')); ?>" class="input-field" placeholder="Min monthly visits">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date To</label>
                        <input type="date" name="start_to" value="<?php echo e(request('start_to')); ?>" class="input-field">
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4 mt-3">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_celebrity" value="1" <?php echo e(request('has_celebrity') ? 'checked' : ''); ?> class="rounded text-terracotta-500">
                        Celebrity Appearance
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_govt_support" value="1" <?php echo e(request('has_govt_support') ? 'checked' : ''); ?> class="rounded text-terracotta-500">
                        Govt. Support
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_media_coverage" value="1" <?php echo e(request('has_media_coverage') ? 'checked' : ''); ?> class="rounded text-terracotta-500">
                        Media Coverage
                    </label>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card-hover group">
                <div class="relative h-48 overflow-hidden">
                    <?php if($event->cover_image_url): ?>
                        <img src="<?php echo e($event->cover_image_url); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-terracotta-400 to-terracotta-700"></div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="badge-dark text-xs"><?php echo e($event->category->name ?? 'General'); ?></span>
                        <?php if($event->sponsorship_type): ?>
                            <span class="bg-emerald-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium"><?php echo e(ucfirst($event->sponsorship_type)); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="absolute top-3 right-3 bg-green-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">Open</div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 line-clamp-1"><?php echo e($event->title); ?></h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2"><?php echo e($event->tagline ?? Str::limit(strip_tags($event->description), 100)); ?></p>
                    <div class="flex items-center text-sm text-gray-400 mb-1.5">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <?php echo e($event->start_date->format('M d, Y')); ?>

                    </div>
                    <div class="flex items-center text-sm text-gray-400 mb-4">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <?php echo e($event->city); ?>, <?php echo e($event->state); ?>

                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="text-terracotta-500 font-bold text-sm"><?php echo e(number_format($event->expected_audience)); ?> <span class="text-gray-400 font-normal">attendees</span></span>
                            <?php if($event->budget_min || $event->budget_max): ?>
                                <span class="w-px h-4 bg-gray-200"></span>
                                <span class="text-sm text-terracotta-600 font-semibold">₹<?php echo e(number_format(($event->budget_min ?? $event->budget_max)/1000, 0)); ?>K</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('sponsor.events.show', $event)); ?>" class="text-terracotta-500 font-semibold text-sm hover:text-terracotta-600 transition flex items-center gap-1">
                            View
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-400 text-lg font-medium mb-1">No events found</p>
                <p class="text-gray-400 text-sm">Check back later for new sponsorship opportunities.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if($events->hasPages()): ?>
        <div class="mt-8">
            <?php if(method_exists($events, 'links')): ?><?php echo e($events->withQueryString()->links()); ?><?php endif; ?>
        </div>
    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/events/index.blade.php ENDPATH**/ ?>