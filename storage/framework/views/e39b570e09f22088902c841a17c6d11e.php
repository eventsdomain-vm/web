<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> <?php echo e($event->title); ?> - EventsDomain <?php $__env->endSlot(); ?>
     <?php $__env->slot('meta_description', null, []); ?> <?php echo e($event->tagline ?? Str::limit(strip_tags($event->description), 160)); ?> <?php $__env->endSlot(); ?>

    <?php
        $galleryImages = $event->gallery->pluck('image_url')->filter(fn($p) => !empty($p))->map(function ($p) {
            if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) return $p;
            try {
                if (Storage::disk('public')->exists($p)) return Storage::url($p);
            } catch (\Throwable) {}
            return null;
        })->filter()->values();
        $heroImages = $galleryImages->isNotEmpty() ? $galleryImages : collect([$event->cover_image_url])->filter()->values();
    ?>

    
    <section class="relative h-[50vh] md:h-[65vh] min-h-[420px] overflow-hidden bg-gray-900"
        x-data="{
            current: 0,
            images: <?php echo e(Js::from($heroImages->values()->toArray())); ?>,
            get total() { return this.images.length },
            get currentImage() { return this.images[this.current] },
            prev() { this.current = this.current > 0 ? this.current - 1 : this.total - 1; $dispatch('gallery-change', { index: this.current }) },
            next() { this.current = this.current < this.total - 1 ? this.current + 1 : 0; $dispatch('gallery-change', { index: this.current }) },
            goTo(i) { this.current = i; $dispatch('gallery-change', { index: i }) }
        }"
        @gallery-change.window="current = $event.detail.index"
    >
        
        <template x-for="(img, i) in images" :key="i">
            <img
                :src="img"
                :alt="'<?php echo e($event->title); ?>'"
                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                :class="i === current ? 'opacity-100' : 'opacity-0'"
                onerror="this.outerHTML='<div class=\'absolute inset-0 bg-gradient-to-br from-terracotta-700 to-terracotta-900\'></div>'"
            >
        </template>

        
        <?php if($heroImages->isEmpty()): ?>
            <div class="absolute inset-0 bg-gradient-to-br from-terracotta-700 to-terracotta-900"></div>
        <?php endif; ?>

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>

        
        <button @click="prev" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center transition group" :class="{ 'hidden': total <= 1 }">
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>

        
        <button @click="next" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center transition group" :class="{ 'hidden': total <= 1 }">
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        
        <div class="absolute top-4 right-4 z-20 bg-black/40 backdrop-blur-sm text-white text-xs font-medium px-3 py-1.5 rounded-full" x-show="total > 1" x-cloak>
            <span x-text="current + 1"></span>/<span x-text="total"></span>
        </div>

        
        <div class="absolute bottom-0 left-0 right-0 z-10 pb-8 md:pb-12 pt-24">
            <div class="container-page">
                <div class="max-w-4xl">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="bg-white/15 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm"><?php echo e($event->category->name ?? 'General'); ?></span>
                        <?php if($event->is_featured): ?>
                            <span class="bg-amber-500/20 text-amber-300 text-xs px-3 py-1 rounded-full font-medium border border-amber-500/30">Featured</span>
                        <?php endif; ?>
                        <?php if($event->sponsorship_type): ?>
                            <span class="bg-emerald-500/20 text-emerald-300 text-xs px-3 py-1 rounded-full font-medium border border-emerald-500/30"><?php echo e(ucfirst($event->sponsorship_type)); ?></span>
                        <?php endif; ?>
                        <span class="text-white/50 text-xs flex items-center ml-auto">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <?php echo e(number_format($event->views_count)); ?> views
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight"><?php echo e($event->title); ?></h1>

                    <?php if($event->tagline): ?>
                        <p class="text-base md:text-lg text-white/70 mb-5 max-w-2xl"><?php echo e($event->tagline); ?></p>
                    <?php endif; ?>

                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-white/60">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <?php echo e($event->start_date->format('M d, Y')); ?> <?php if($event->end_date && $event->end_date != $event->start_date): ?> - <?php echo e($event->end_date->format('M d, Y')); ?><?php endif; ?>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <?php echo e($event->city); ?>, <?php echo e($event->state); ?>

                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            <?php echo e(number_format($event->expected_audience)); ?> Expected
                        </span>
                        <?php if($event->budget_min || $event->budget_max): ?>
                            <span class="flex items-center gap-1.5 text-terracotta-300 font-semibold">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <?php if($event->budget_min && $event->budget_max): ?>
                                    ₹<?php echo e(number_format($event->budget_min)); ?> - ₹<?php echo e(number_format($event->budget_max)); ?>

                                <?php elseif($event->budget_min): ?>
                                    From ₹<?php echo e(number_format($event->budget_min)); ?>

                                <?php else: ?>
                                    Up to ₹<?php echo e(number_format($event->budget_max)); ?>

                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <?php if($galleryImages->isNotEmpty() && $galleryImages->count() > 1): ?>
        <section class="bg-white border-b border-gray-100"
            x-data="{ active: 0 }"
            @gallery-change.window="active = $event.detail.index"
        >
            <div class="container-page py-4">
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-thin">
                    <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $imgUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            @click="$dispatch('gallery-change', { index: <?php echo e($i); ?> })"
                            class="flex-shrink-0 w-28 h-20 rounded-lg overflow-hidden bg-gray-100 hover:ring-2 transition focus:outline-none"
                            :class="active === <?php echo e($i); ?> ? 'ring-2 ring-terracotta-500' : 'ring-0 hover:ring-1 hover:ring-gray-300'"
                        >
                            <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-full object-cover" loading="lazy" onerror="this.outerHTML='<div class=\'w-full h-full bg-gray-200\'></div>'">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <nav class="bg-white border-b border-gray-100">
        <div class="container-page py-3">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="/" class="hover:text-terracotta-600 transition">Home</a></li>
                <li><svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><a href="<?php echo e(route('events.index')); ?>" class="hover:text-terracotta-600 transition">Explore Events</a></li>
                <li><svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-gray-900 font-medium truncate max-w-[200px] md:max-w-xs"><?php echo e($event->title); ?></li>
            </ol>
        </div>
    </nav>

    
    <section class="section bg-gray-50/50">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">

                    
                    <div class="card p-6 md:p-8">
                        <h2 class="heading-3 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            About This Event
                        </h2>
                        <div class="prose prose-gray max-w-none prose-headings:font-bold prose-a:text-terracotta-500">
                            <?php echo nl2br(e($event->description)); ?>

                        </div>
                    </div>

                    
                    <div class="card p-6 md:p-8">
                        <h2 class="heading-3 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            Event Details
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-terracotta-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Event Type</p>
                                    <p class="font-semibold text-gray-900 capitalize"><?php echo e($event->event_type ?? 'In-Person'); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Start Date</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->start_date->format('l, M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">End Date</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->end_date->format('l, M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Expected Audience</p>
                                    <p class="font-semibold text-gray-900"><?php echo e(number_format($event->expected_audience)); ?> attendees</p>
                                </div>
                            </div>
                            <?php if($event->venue): ?>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Venue</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->venue); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if($event->city): ?>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->address ?? $event->city . ', ' . $event->state . ', ' . $event->country); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if($event->category): ?>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Category</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->category->name ?? 'General'); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="card p-6 md:p-8">
                        <h2 class="heading-3 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            Target Audience
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="bg-terracotta-50 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-terracotta-600"><?php echo e(number_format($event->expected_audience)); ?></div>
                                <div class="text-sm text-gray-600 mt-1">Expected Attendees</div>
                            </div>
                            <div class="bg-sky-50 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-sky-600"><?php echo e($event->expected_audience ? number_format(ceil($event->expected_audience * 0.4)) : 'N/A'); ?></div>
                                <div class="text-sm text-gray-600 mt-1">Target Demographics</div>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-emerald-600"><?php echo e($event->city ?? 'Pan-India'); ?></div>
                                <div class="text-sm text-gray-600 mt-1">Geographic Reach</div>
                            </div>
                        </div>
                        <?php if($event->audience_description): ?>
                            <div class="bg-gray-50 rounded-xl p-5">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Audience Profile</p>
                                <p class="text-gray-600 text-sm leading-relaxed"><?php echo e($event->audience_description); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="bg-gray-50 rounded-xl p-5">
                                <p class="text-sm text-gray-500 italic">No detailed audience profile provided. Contact the organizer for more information.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="card p-6 md:p-8">
                        <h2 class="heading-3 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Sponsorship Opportunities
                        </h2>
                        <?php $__empty_1 = true; $__currentLoopData = $event->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border border-gray-200 rounded-2xl p-6 mb-4 last:mb-0 hover:border-terracotta-200 transition hover:shadow-sm">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900"><?php echo e($package->title); ?></h3>
                                        <?php if($package->description): ?>
                                            <p class="text-sm text-gray-500 mt-1"><?php echo e($package->description); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-terracotta-500">₹<?php echo e(number_format($package->price)); ?></div>
                                        <div class="text-xs text-gray-400 mt-0.5">One-time fee</div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        Slots: <?php echo e($package->slots_filled); ?>/<?php echo e($package->slots_available); ?>

                                    </span>
                                    <?php if($package->benefitRecords->count()): ?>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span><?php echo e($package->benefitRecords->count()); ?> benefits included</span>
                                    <?php endif; ?>
                                    <?php if($package->slots_available > $package->slots_filled): ?>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-emerald-600 font-medium"><?php echo e($package->slots_available - $package->slots_filled); ?> slots left</span>
                                    <?php else: ?>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-red-500 font-medium">Sold Out</span>
                                    <?php endif; ?>
                                </div>

                                <?php if($package->benefitRecords->count()): ?>
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-sm font-semibold text-gray-700 mb-3">Package Benefits:</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <?php $__currentLoopData = $package->benefitRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                    <?php echo e($benefit->benefit_text); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($package->slots_available > $package->slots_filled): ?>
                                    <div class="mt-5">
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(auth()->user()->hasRole('sponsor')): ?>
                                                <a href="<?php echo e(route('sponsor.events.show', $event)); ?>" class="btn-primary text-sm">Sponsor This Package</a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('login')); ?>" class="btn-primary text-sm">Login to Sponsor</a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('register')); ?>" class="btn-primary text-sm">Create Account to Sponsor</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p class="text-gray-500">Sponsorship packages are not yet available for this event. Contact the organizer directly.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($event->tags && count($event->tags)): ?>
                        <div class="card p-6">
                            <h2 class="heading-3 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                Event Tags
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $event->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge-neutral"><?php echo e($tag); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-6">
                    <div class="card p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4">Interested in Sponsoring?</h3>
                        <p class="text-sm text-gray-500 mb-5">Connect with the organizer and explore sponsorship opportunities for this event.</p>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->hasRole('sponsor')): ?>
                                <a href="<?php echo e(route('sponsor.events.show', $event)); ?>" class="btn-primary w-full text-center block">
                                    <svg class="w-4 h-4 mr-1.5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    View Sponsorship Options
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn-primary w-full text-center block">Login to Sponsor</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('register')); ?>" class="btn-primary w-full text-center block">Create Account to Sponsor</a>
                        <?php endif; ?>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Event at a Glance</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <span class="text-sm text-gray-500">Category</span>
                                <span class="text-sm font-semibold text-gray-900"><?php echo e($event->category->name ?? 'General'); ?></span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <span class="text-sm text-gray-500">Views</span>
                                <span class="text-sm font-semibold text-gray-900"><?php echo e(number_format($event->views_count)); ?></span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <span class="text-sm text-gray-500">Packages</span>
                                <span class="text-sm font-semibold text-gray-900"><?php echo e($event->packages->count()); ?></span>
                            </div>
                            <?php if($galleryImages->isNotEmpty()): ?>
                            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                                <span class="text-sm text-gray-500">Gallery</span>
                                <span class="text-sm font-semibold text-gray-900"><?php echo e($galleryImages->count()); ?> images</span>
                            </div>
                            <?php endif; ?>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-500">Expected</span>
                                <span class="text-sm font-semibold text-gray-900"><?php echo e(number_format($event->expected_audience)); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Organizer
                        </h3>
                        <div class="flex items-center gap-4">
                            <img src="<?php echo e($event->organizer->avatar_url ?? ''); ?>" alt="<?php echo e($event->organizer->name); ?>" class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-100">
                            <div>
                                <p class="font-bold text-gray-900"><?php echo e($event->organizer->name); ?></p>
                                <p class="text-sm text-gray-500">Event Organizer</p>
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('messages.index')); ?>" class="text-xs text-terracotta-500 hover:text-terracotta-600 font-medium mt-1 inline-block">Send Message</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Share This Event</h3>
                        <div class="flex gap-3">
                            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(request()->fullUrl())); ?>&text=<?php echo e(urlencode($event->title)); ?>" target="_blank" class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center hover:bg-blue-100 transition" title="Share on X">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(request()->fullUrl())); ?>" target="_blank" class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center hover:bg-blue-100 transition" title="Share on Facebook">
                                <svg class="w-5 h-5 text-blue-800" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="https://wa.me/?text=<?php echo e(urlencode($event->title . ' - ' . request()->fullUrl())); ?>" target="_blank" class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center hover:bg-green-100 transition" title="Share on WhatsApp">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                            <button onclick="navigator.clipboard.writeText('<?php echo e(request()->fullUrl()); ?>'); this.innerHTML='<svg class=\'w-5 h-5 text-emerald-600\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'/></svg>'" class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center hover:bg-gray-100 transition" title="Copy Link">
                                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": "<?php echo e($event->title); ?>",
        "description": "<?php echo e(Str::limit(strip_tags($event->description), 200)); ?>",
        "startDate": "<?php echo e($event->start_date->toIso8601String()); ?>",
        "endDate": "<?php echo e($event->end_date->toIso8601String()); ?>",
        "location": {
            "@type": "Place",
            "name": "<?php echo e($event->venue ?? $event->city); ?>",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "<?php echo e($event->city); ?>",
                "addressRegion": "<?php echo e($event->state); ?>",
                "addressCountry": "<?php echo e($event->country); ?>"
            }
        },
        "organizer": {
            "@type": "Person",
            "name": "<?php echo e($event->organizer->name ?? 'Event Organizer'); ?>"
        }
    }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\resources\views/events/show.blade.php ENDPATH**/ ?>