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
     <?php $__env->slot('title', null, []); ?> Event Sponsorship ROI Calculator | EventsDomain <?php $__env->endSlot(); ?>
     <?php $__env->slot('meta_description', null, []); ?> Calculate your event sponsorship ROI with our free tool — factor in celebrity presence, media coverage, and digital amplification. Free tool for sponsors. <?php $__env->endSlot(); ?>

    
    <section class="relative overflow-hidden text-white bg-cover bg-center" style="background-image: url('/images/partners-hero.jpg');">
        <div class="absolute inset-0 bg-gradient-to-br from-terracotta-900/85 via-terracotta-700/65 to-terracotta-500/50"></div>
        <div class="container-page py-16 lg:py-20 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-orange-100 mb-4 border border-white/10 backdrop-blur-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-semibold uppercase tracking-wider">Advanced ROI Calculator</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 tracking-tight">Sponsorship ROI Calculator</h1>
            <p class="text-base sm:text-lg text-orange-100/80 max-w-2xl mx-auto">
                Factor in celebrity presence, viral potential, media coverage, and 10+ amplification factors for accurate ROI estimates.
            </p>
        </div>
    </section>

    
    <section class="py-10 bg-white">
        <div class="container-page">
            <div class="grid lg:grid-cols-2 gap-8 items-start">

                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900">Enter Details</h2>
                        <p class="text-xs text-gray-500 mt-1">Complete all sections for accurate ROI calculation</p>
                    </div>

                    <div class="p-6 max-h-[75vh] overflow-y-auto space-y-6" id="inputs-container">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Investment Details</h3>

                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Currency</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" name="currency" value="INR" checked onchange="updateCurrency(); calculate()"
                                               class="h-4 w-4 text-terracotta-500 border-gray-300 focus:ring-terracotta-500">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-950">₹ INR</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" name="currency" value="USD" onchange="updateCurrency(); calculate()"
                                               class="h-4 w-4 text-terracotta-500 border-gray-300 focus:ring-terracotta-500">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-950">$ USD</span>
                                    </label>
                                </div>
                            </div>

                            
                            <div class="space-y-2">
                                <label for="investment" class="block text-sm font-semibold text-gray-700">Sponsorship Investment</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 sm:text-sm font-semibold" id="currency-symbol">₹</span>
                                    </div>
                                    <input type="number" id="investment" placeholder="100000" oninput="calculate()"
                                           class="block w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 pl-8 pr-4 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition">
                                </div>
                            </div>

                            
                            <div class="space-y-2">
                                <label for="audienceSize" class="block text-sm font-semibold text-gray-700">Expected Audience Size</label>
                                <input type="number" id="audienceSize" placeholder="5000" oninput="calculate()"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition">
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Event Details</h3>

                            
                            <div class="space-y-2">
                                <label for="eventType" class="block text-sm font-semibold text-gray-700">Event Type</label>
                                <div class="relative">
                                    <select id="eventType" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="">Select event type</option>
                                        <option value="conference">Conference / Summit</option>
                                        <option value="festival">Festival</option>
                                        <option value="sports">Sports Event</option>
                                        <option value="exhibition">Exhibition / Trade Show</option>
                                        <option value="concert">Concert / Music Event</option>
                                        <option value="workshop">Workshop / Seminar</option>
                                        <option value="networking">Networking Event</option>
                                        <option value="charity">Charity / Fundraiser</option>
                                        <option value="corporate">Corporate Event</option>
                                        <option value="cultural">Cultural Event</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="space-y-2">
                                <label for="eventDuration" class="block text-sm font-semibold text-gray-700">Event Duration</label>
                                <div class="relative">
                                    <select id="eventDuration" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="single">Single Day</option>
                                        <option value="multi" selected>2-3 Days</option>
                                        <option value="week">Week-long or More</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div class="space-y-2">
                                    <label for="cityTier" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">City Tier</label>
                                    <div class="relative">
                                        <select id="cityTier" onchange="calculate()"
                                                class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-2.5 px-3 pr-8 text-xs text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                            <option value="metro">Metro City (Mumbai, Delhi, Bangalore, etc.)</option>
                                            <option value="tier2" selected>Tier 2 City (Pune, Jaipur, Lucknow, etc.)</option>
                                            <option value="tier3">Tier 3 City (Smaller cities)</option>
                                            <option value="international">International (Dubai, Singapore, etc.)</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label for="venueType" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Venue Type</label>
                                    <div class="relative">
                                        <select id="venueType" onchange="calculate()"
                                                class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-2.5 px-3 pr-8 text-xs text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                            <option value="standard" selected>Standard Venue</option>
                                            <option value="convention">Convention Center</option>
                                            <option value="stadium">Stadium / Arena</option>
                                            <option value="outdoor">Outdoor / Public Space</option>
                                            <option value="iconic">Iconic / Landmark Venue</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sponsorship Package</h3>

                            
                            <div class="space-y-2">
                                <label for="sponsorshipLevel" class="block text-sm font-semibold text-gray-700">Sponsorship Level</label>
                                <div class="relative">
                                    <select id="sponsorshipLevel" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="">Select sponsorship level</option>
                                        <option value="title">Title Sponsor</option>
                                        <option value="gold">Gold / Presenting Sponsor</option>
                                        <option value="silver">Silver / Associate Sponsor</option>
                                        <option value="bronze">Bronze / Supporting Sponsor</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="space-y-3 pt-1">
                                <label class="block text-sm font-semibold text-gray-700">Sponsorship Benefits Included</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <?php $__currentLoopData = [
                                        'Branding' => [
                                            'logo_backdrop' => 'Logo on Stage Backdrop',
                                            'logo_print' => 'Logo on Print Materials',
                                            'stage_mention' => 'Stage Announcements'
                                        ],
                                        'Digital' => [
                                            'social_posts' => 'Social Media Posts',
                                            'email_mentions' => 'Email Newsletter Mentions',
                                            'website_logo' => 'Website Logo Placement',
                                            'video_branding' => 'Video/Stream Branding'
                                        ],
                                        'Engagement' => [
                                            'booth_stall' => 'Booth/Stall Space',
                                            'speaking_slot' => 'Speaking Opportunity',
                                            'product_sampling' => 'Product Sampling',
                                            'branded_merchandise' => 'Branded Merchandise'
                                        ],
                                        'Premium' => [
                                            'exclusive_category' => 'Category Exclusivity'
                                        ]
                                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="space-y-1.5">
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider"><?php echo e($category); ?></h4>
                                            <div class="space-y-1">
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition select-none">
                                                        <input type="checkbox" name="benefits" value="<?php echo e($val); ?>" onchange="calculate()"
                                                               class="rounded border-gray-300 text-terracotta-500 focus:ring-terracotta-500 h-4 w-4">
                                                        <span class="text-xs font-medium text-gray-700 leading-tight"><?php echo e($lbl); ?></span>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Digital Amplification
                            </h3>

                            <div class="space-y-3">
                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100">
                                    <div class="space-y-0.5">
                                        <span class="text-sm font-semibold text-gray-800 block">Live Streaming</span>
                                        <span class="text-xs text-gray-400">Broadcasting event sessions online</span>
                                    </div>
                                    <label class="relative flex items-center cursor-pointer select-none">
                                        <input type="checkbox" id="hasLiveStreaming" onchange="toggleStreaming(); calculate()" class="sr-only peer">
                                        <div class="w-9 h-5 rounded-full border-2 transition-colors duration-200 border-gray-300 bg-gray-100 peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>

                                
                                <div id="streaming-platforms-container" class="hidden pl-3 space-y-2">
                                    <label for="streamingPlatforms" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Number of Streaming Platforms</label>
                                    <input type="number" id="streamingPlatforms" min="1" max="10" value="1" oninput="calculate()"
                                           class="block w-full max-w-[120px] rounded-xl border border-gray-200 bg-gray-50/50 py-2 px-3 text-xs text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition">
                                </div>

                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100">
                                    <div class="space-y-0.5">
                                        <span class="text-sm font-semibold text-gray-800 block">Hashtag Campaign</span>
                                        <span class="text-xs text-gray-400">Event-specific tracking hashtag campaign</span>
                                    </div>
                                    <label class="relative flex items-center cursor-pointer select-none">
                                        <input type="checkbox" id="hasHashtagCampaign" onchange="calculate()" class="sr-only peer">
                                        <div class="w-9 h-5 rounded-full border-2 transition-colors duration-200 border-gray-300 bg-gray-100 peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>

                                
                                <div class="space-y-2">
                                    <label for="influencerTier" class="block text-sm font-semibold text-gray-700">Influencer Tier</label>
                                    <div class="relative">
                                        <select id="influencerTier" onchange="calculate()"
                                                class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                            <option value="none">No Influencer Partnership</option>
                                            <option value="micro">Micro Influencers (10K-100K followers)</option>
                                            <option value="macro">Macro Influencers (100K-1M followers)</option>
                                            <option value="mega">Mega Influencers (1M+ followers)</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100">
                                    <div class="space-y-0.5">
                                        <span class="text-sm font-semibold text-gray-800 block">Pre-Event Marketing Campaign</span>
                                        <span class="text-xs text-gray-400">Featured promotion before live event date</span>
                                    </div>
                                    <label class="relative flex items-center cursor-pointer select-none">
                                        <input type="checkbox" id="hasPreEventCampaign" onchange="calculate()" class="sr-only peer">
                                        <div class="w-9 h-5 rounded-full border-2 transition-colors duration-200 border-gray-300 bg-gray-100 peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Media Coverage</h3>
                            <div class="space-y-2">
                                <label for="mediaCoverage" class="block text-sm font-semibold text-gray-700">Expected Media Coverage</label>
                                <div class="relative">
                                    <select id="mediaCoverage" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="none">No Media Coverage Expected</option>
                                        <option value="local">Local Press Only</option>
                                        <option value="regional">Regional Media</option>
                                        <option value="national">National TV / News</option>
                                        <option value="international">International Media</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Organizer Credibility</h3>

                            <div class="space-y-3">
                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100">
                                    <div class="space-y-0.5">
                                        <span class="text-sm font-semibold text-gray-800 block">Verified Organizer Profile</span>
                                        <span class="text-xs text-gray-400">Identity verified by EventsDomain</span>
                                    </div>
                                    <label class="relative flex items-center cursor-pointer select-none">
                                        <input type="checkbox" id="isVerifiedOrganizer" onchange="calculate()" class="sr-only peer" checked>
                                        <div class="w-9 h-5 rounded-full border-2 transition-colors duration-200 border-gray-300 bg-gray-100 peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>

                                
                                <div class="space-y-2">
                                    <label for="pastEventsCount" class="block text-sm font-semibold text-gray-700">Past Events Conducted</label>
                                    <input type="number" id="pastEventsCount" placeholder="5" value="3" min="0" max="100" oninput="calculate()"
                                           class="block w-full rounded-xl border-gray-200 bg-gray-50/50 py-3 px-4 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition">
                                </div>

                                
                                <div class="space-y-2">
                                    <label for="organizerFollowers" class="block text-sm font-semibold text-gray-700">Organizer Social Following</label>
                                    <div class="relative">
                                        <select id="organizerFollowers" onchange="calculate()"
                                                class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                            <option value="none">No Social Following</option>
                                            <option value="small">1K - 10K Followers</option>
                                            <option value="medium" selected>10K - 50K Followers</option>
                                            <option value="large">50K+ Followers</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/80 border border-gray-100">
                                    <div class="space-y-0.5">
                                        <span class="text-sm font-semibold text-gray-800 block">Sponsor Testimonials</span>
                                        <span class="text-xs text-gray-400">Positive feedback from past corporate sponsors</span>
                                    </div>
                                    <label class="relative flex items-center cursor-pointer select-none">
                                        <input type="checkbox" id="hasSponsorTestimonials" onchange="calculate()" class="sr-only peer">
                                        <div class="w-9 h-5 rounded-full border-2 transition-colors duration-200 border-gray-300 bg-gray-100 peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500 relative">
                                            <div class="absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow-sm transition-transform duration-200 peer-checked:translate-x-4"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                <span>✨ Special Factors</span>
                            </h3>

                            
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="celebrityLevel" class="block text-sm font-semibold text-gray-700">Celebrity / VIP Presence</label>
                                    <span id="celebrity-boost" class="hidden text-xs px-2 py-0.5 rounded-full bg-terracotta-500/10 text-terracotta-500 font-bold"></span>
                                </div>
                                <div class="relative">
                                    <select id="celebrityLevel" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="none">No Special Guests</option>
                                        <option value="local">Local Celebrities / Influencers</option>
                                        <option value="national">National Celebrities (TV/Film/Sports)</option>
                                        <option value="international">International Celebrities</option>
                                        <option value="multiple">Multiple A-List Celebrities</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="viralPotential" class="block text-sm font-semibold text-gray-700">Viral Potential</label>
                                    <span id="viral-boost" class="hidden text-xs px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 font-bold"></span>
                                </div>
                                <div class="relative">
                                    <select id="viralPotential" onchange="calculate()"
                                            class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 py-3 px-4 pr-10 text-sm text-gray-900 font-medium focus:border-terracotta-500 focus:ring-terracotta-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="low">Low - Standard Event</option>
                                        <option value="medium" selected>Medium - Good Content Potential</option>
                                        <option value="high">High - High Engagement/Trending</option>
                                        <option value="viral">Viral - Expected National Buzz</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden lg:sticky lg:top-24">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900">Your ROI Analysis</h2>
                        <p class="text-xs text-gray-500 mt-1">Real-time calculation with all factors</p>
                    </div>

                    <div class="p-6 max-h-[75vh] overflow-y-auto space-y-6" id="results-container">

                        
                        <div id="results-placeholder" class="py-20 text-center flex flex-col items-center justify-center space-y-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Calculations Pending</h3>
                            <p class="text-sm text-gray-400 max-w-xs mx-auto">
                                Enter the investment amount, audience, event type, and sponsorship level to run the analysis.
                            </p>
                        </div>

                        
                        <div id="results-output" class="hidden space-y-6">

                            
                            <div class="p-6 rounded-2xl border text-center transition-colors duration-300" id="score-box">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3 shadow-sm" id="rating-badge">
                                    Good Project
                                </div>
                                <div class="text-4xl font-black tracking-tight mb-2">
                                    <span id="score-val">7</span><span class="text-lg text-gray-400 font-semibold">/10 Score</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 leading-snug mb-1" id="verdict-title">ROI Verdict</p>
                                <p class="text-xs text-gray-500 px-4 leading-relaxed" id="verdict-desc">Projected ROI looks positive based on exposure and audience conversion potentials.</p>
                            </div>

                            
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-center">
                                <p class="text-sm font-semibold text-gray-700">
                                    📈 <span id="return-percentage" class="text-terracotta-600">--%</span> potential return on investment
                                </p>
                            </div>

                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Brand Impressions
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-impressions">--</p>
                                    <p class="text-[11px] text-gray-400 mt-1">Total brand exposures</p>
                                </div>

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 10.742L19.907 2.224A1 1 0 0121.36 3.73l-8.518 11.224a1 1 0 01-1.458.125L8.7 12.3l-5.602 4.2a1 1 0 01-1.48-1.127l3.6-11.25A1 1 0 016.7 3.5l1.984 7.242z"/></svg>
                                        Social Reach
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-social-reach">--</p>
                                    <p class="text-[11px] text-gray-400 mt-1">Social media amplification</p>
                                </div>

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Lead Potential
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-leads">--</p>
                                    <p class="text-[11px] text-gray-400 mt-1">Qualified buyer leads</p>
                                </div>

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Equivalent Ad Value
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-ad-value">--</p>
                                    <p class="text-[11px] text-gray-400 mt-1">PR/Advertising value equivalent</p>
                                </div>

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        Cost Per Impression (CPM)
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-cpm">--</p>
                                    <p class="text-[10px] text-gray-400 mt-1" id="comparison-cpm">vs benchmark</p>
                                </div>

                                
                                <div class="p-4 rounded-xl border border-gray-100 bg-white hover:shadow-md transition">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                        Cost Per Lead (CPL)
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900" id="metric-cpl">--</p>
                                    <p class="text-[10px] text-gray-400 mt-1" id="comparison-cpl">vs benchmark</p>
                                </div>
                            </div>

                            
                            <div class="p-5 rounded-2xl border border-gray-200 bg-white space-y-3">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-bold text-gray-800">Estimated Brand Value</h4>
                                    <span id="brand-value-badge" class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Good Value</span>
                                </div>
                                <p class="text-3xl font-black text-gray-900" id="brand-value-val">--</p>
                                <p class="text-xs text-gray-400 leading-normal">
                                    Equivalent PR & advertising spend needed to achieve similar exposure.
                                </p>
                            </div>

                            
                            <div class="space-y-3 pt-2">
                                <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
                                    <svg class="w-4 h-4 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                                    Factor Contribution Breakdown
                                </div>
                                <div id="breakdown-list" class="space-y-3">
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    
    <script>
    // Lookup tables matching sponsorshipsearch.com exactly
    const EAe = { single: 1, multi: 2.5, week: 5 };
    const TAe = { title: 5, gold: 3, silver: 2, bronze: 1 };
    const AAe = {
        logo_backdrop: 2, logo_print: 1.5, stage_mention: 3,
        social_posts: 2.5, email_mentions: 1.5, booth_stall: 2,
        speaking_slot: 4, product_sampling: 2.5, branded_merchandise: 1.5,
        exclusive_category: 3, website_logo: 1.5, video_branding: 2
    };
    const PAe = {
        conference: 0.04, festival: 0.03, sports: 0.035,
        exhibition: 0.05, concert: 0.025, workshop: 0.06,
        networking: 0.07, charity: 0.04, corporate: 0.05,
        cultural: 0.03
    };
    const GP = { none: 1, local: 1.5, national: 3, international: 5, multiple: 7 };
    const OAe = { none: 1, local: 1.3, regional: 1.8, national: 3, international: 5 };
    const Nv = {
        liveStreaming: 1.5, multiPlatformStreaming: 0.3, hashtagCampaign: 1.3,
        influencer: { none: 1, micro: 1.3, macro: 1.6, mega: 2 },
        preEventCampaign: 1.4
    };
    const MAe = { metro: 1.5, tier2: 1.2, tier3: 1, international: 2 };
    const RAe = { standard: 1, convention: 1.2, stadium: 1.4, outdoor: 1.3, iconic: 1.5 };
    const YP = { low: 1, medium: 1.5, high: 2.5, viral: 4 };
    const Hf = {
        verified: 1.2,
        pastEvents: { 0: 1, 5: 1.15, 10: 1.25, 20: 1.35 },
        followers: { none: 1, small: 1.1, medium: 1.2, large: 1.4 },
        testimonials: 1.15
    };

    const IAe = 200;   // Base CPM INR
    const DAe = 2.5;   // Base CPM USD
    const $Ae = 1000;  // Base CPL INR
    const LAe = 12;    // Base CPL USD

    const avgCpm = { INR: 200, USD: 2.5 };
    const avgCpl = { INR: 1000, USD: 12 };

    function toggleStreaming() {
        const hasStreaming = document.getElementById('hasLiveStreaming').checked;
        const container = document.getElementById('streaming-platforms-container');
        if (hasStreaming) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    function updateCurrency() {
        const currency = document.querySelector('input[name="currency"]:checked').value;
        const symbol = document.getElementById('currency-symbol');
        const investment = document.getElementById('investment');
        if (currency === 'INR') {
            symbol.textContent = '₹';
            if (investment.placeholder === '5000') {
                investment.placeholder = '100000';
                if (investment.value === '5000') investment.value = '200000';
            }
        } else {
            symbol.textContent = '$';
            if (investment.placeholder === '100000') {
                investment.placeholder = '5000';
                if (investment.value === '200000') investment.value = '5000';
            }
        }
    }

    function fmt(val, cur) {
        const prefix = cur === 'INR' ? '₹' : '$';
        if (val >= 10000000 && cur === 'INR') return prefix + (val / 10000000).toFixed(2) + ' Cr';
        if (val >= 100000 && cur === 'INR') return prefix + (val / 100000).toFixed(2) + ' L';
        if (val >= 1000) return prefix + (val / 1000).toFixed(1) + 'K';
        return prefix + Math.round(val).toLocaleString();
    }

    function fmtNum(val) {
        if (val >= 10000000) return (val / 10000000).toFixed(2) + ' Cr';
        if (val >= 100000) return (val / 100000).toFixed(2) + ' L';
        if (val >= 1000) return (val / 1000).toFixed(1) + 'K';
        return val.toLocaleString();
    }

    function calculate() {
        // Required Fields
        const investment = parseFloat(document.getElementById('investment').value);
        const audienceSize = parseFloat(document.getElementById('audienceSize').value);
        const eventType = document.getElementById('eventType').value;
        const sponsorshipLevel = document.getElementById('sponsorshipLevel').value;

        const placeholder = document.getElementById('results-placeholder');
        const output = document.getElementById('results-output');

        if (!investment || !audienceSize || !eventType || !sponsorshipLevel) {
            placeholder.classList.remove('hidden');
            output.classList.add('hidden');
            return;
        }

        placeholder.classList.add('hidden');
        output.classList.remove('hidden');

        // All Inputs
        const currency = document.querySelector('input[name="currency"]:checked').value;
        const eventDuration = document.getElementById('eventDuration').value;
        const cityTier = document.getElementById('cityTier').value;
        const venueType = document.getElementById('venueType').value;
        const hasLiveStreaming = document.getElementById('hasLiveStreaming').checked;
        const streamingPlatforms = parseFloat(document.getElementById('streamingPlatforms').value) || 1;
        const hasHashtagCampaign = document.getElementById('hasHashtagCampaign').checked;
        const influencerTier = document.getElementById('influencerTier').value;
        const hasPreEventCampaign = document.getElementById('hasPreEventCampaign').checked;
        const mediaCoverage = document.getElementById('mediaCoverage').value;
        const isVerifiedOrganizer = document.getElementById('isVerifiedOrganizer').checked;
        const pastEventsCount = parseFloat(document.getElementById('pastEventsCount').value) || 0;
        const organizerFollowers = document.getElementById('organizerFollowers').value;
        const hasSponsorTestimonials = document.getElementById('hasSponsorTestimonials').checked;
        const celebrityLevel = document.getElementById('celebrityLevel').value;
        const viralPotential = document.getElementById('viralPotential').value;

        // Selected Benefits
        const benefitsCheckboxes = document.querySelectorAll('input[name="benefits"]:checked');
        const benefits = Array.from(benefitsCheckboxes).map(cb => cb.value);

        // Core logic replication
        const S = EAe[eventDuration] || 1;
        const _ = TAe[sponsorshipLevel] || 1;
        const C = benefits.reduce((sum, item) => sum + (AAe[item] || 1), 1);
        const k = MAe[cityTier] || 1;
        const E = RAe[venueType] || 1;
        const T = k * E;

        let A = 1;
        if (hasLiveStreaming) {
            A *= Nv.liveStreaming;
            A += (streamingPlatforms - 1) * Nv.multiPlatformStreaming;
        }
        if (hasHashtagCampaign) {
            A *= Nv.hashtagCampaign;
        }
        A *= Nv.influencer[influencerTier] || 1;
        if (hasPreEventCampaign) {
            A *= Nv.preEventCampaign;
        }

        const $ = OAe[mediaCoverage] || 1;

        let M = 1;
        if (isVerifiedOrganizer) {
            M *= Hf.verified;
        }
        if (pastEventsCount >= 20) {
            M *= Hf.pastEvents[20];
        } else if (pastEventsCount >= 10) {
            M *= Hf.pastEvents[10];
        } else if (pastEventsCount >= 5) {
            M *= Hf.pastEvents[5];
        }
        M *= Hf.followers[organizerFollowers] || 1;
        if (hasSponsorTestimonials) {
            M *= Hf.testimonials;
        }

        const B = GP[celebrityLevel] || 1;
        const I = YP[viralPotential] || 1;

        // Total Multiplier
        const R = S * _ * (C / 2) * T * A * $ * M * B * I;

        // Visual feedback for boosts
        const celebBoost = document.getElementById('celebrity-boost');
        if (B > 1) {
            celebBoost.textContent = '+' + Math.round((B - 1) * 100) + '% boost';
            celebBoost.classList.remove('hidden');
        } else {
            celebBoost.classList.add('hidden');
        }

        const viralBoost = document.getElementById('viral-boost');
        if (I > 1) {
            viralBoost.textContent = I + 'x reach';
            viralBoost.classList.remove('hidden');
        } else {
            viralBoost.classList.add('hidden');
        }

        // Calculation Metrics
        const O = Math.round(audienceSize * R);
        const D = Math.round(hasLiveStreaming ? audienceSize * A * 2 : audienceSize * 0.3);
        const Y = Math.round((O + D) * 0.4 * I);

        const Z = currency === "INR" ? IAe : DAe;
        const z = Math.round(O / 1000 * Z * $);
        const J = B > 1 ? Math.round(investment * (B - 1) * 0.5) : 0;
        const U = O > 0 ? (investment / O) * 1000 : 0;

        const W = PAe[eventType] || 0.04;
        const he = Math.round(audienceSize * W * _ * M * 0.5);
        const se = he > 0 ? investment / he : 0;
        const xe = Math.round(O / 1000 * Z * 1.5);
        const ne = xe + z + J + Math.round(D * Z / 1000);

        // ROI Score
        const X = currency === "INR" ? $Ae : LAe;
        let score = 5;

        if (U < Z * 0.5) score += 2;
        else if (U < Z) score += 1;
        else if (U > Z * 2) score -= 2;
        else if (U > Z * 1.5) score -= 1;

        if (se < X * 0.5) score += 2;
        else if (se < X) score += 1;
        else if (se > X * 2) score -= 2;
        else if (se > X * 1.5) score -= 1;

        const exposureRatio = ne / investment;
        if (exposureRatio > 5) score += 2;
        else if (exposureRatio > 3) score += 1;
        else if (exposureRatio < 1) score -= 1;

        if (B >= 5) score += 1;
        if (I >= 2.5) score += 1;

        score = Math.max(1, Math.min(10, score));

        // Rating
        let rating = "poor";
        let ratingLabel = "Poor Match";
        let ratingBg = "bg-rose-500/10 border-rose-500/20 text-rose-600";
        let scoreBoxBorder = "border-rose-100 bg-rose-50/10";
        let verdictTitle = "Negative ROI Projected";
        let verdictDesc = "The exposure value or lead potential is low relative to the cost. We recommend reviewing pricing or negotiating additional benefits.";

        if (score >= 8) {
            rating = "excellent";
            ratingLabel = "Excellent Match";
            ratingBg = "bg-emerald-500/10 border-emerald-500/20 text-emerald-600";
            scoreBoxBorder = "border-emerald-100 bg-emerald-50/10";
            verdictTitle = "Outstanding Opportunity!";
            verdictDesc = "This event sponsorship offers exceptionally high exposure, low CPM/CPL costs, and viral amplification potential. Highly recommended.";
        } else if (score >= 6) {
            rating = "good";
            ratingLabel = "Good Match";
            ratingBg = "bg-orange-500/10 border-orange-500/20 text-orange-600";
            scoreBoxBorder = "border-orange-100 bg-orange-50/10";
            verdictTitle = "Solid Partnership";
            verdictDesc = "Good projected ROI with sound numbers. This sponsorship aligns well with media and digital amplification opportunities.";
        } else if (score >= 4) {
            rating = "average";
            ratingLabel = "Average Match";
            ratingBg = "bg-amber-500/10 border-amber-500/20 text-amber-600";
            scoreBoxBorder = "border-amber-100 bg-amber-50/10";
            verdictTitle = "Moderate Potential";
            verdictDesc = "ROI is average. Consider bargaining for category exclusivity or additional digital branding items to improve performance.";
        }

        // Update DOM
        document.getElementById('score-val').textContent = score;
        const ratingBadge = document.getElementById('rating-badge');
        ratingBadge.textContent = ratingLabel;
        ratingBadge.className = "inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3 shadow-sm " + ratingBg;

        const scoreBox = document.getElementById('score-box');
        scoreBox.className = "p-6 rounded-2xl border text-center transition-colors duration-300 " + scoreBoxBorder;

        document.getElementById('verdict-title').textContent = verdictTitle;
        document.getElementById('verdict-desc').textContent = verdictDesc;

        // Return ROI %
        const roiPct = ((ne / investment - 1) * 100);
        document.getElementById('return-percentage').textContent = (roiPct > 0 ? '+' : '') + roiPct.toFixed(0) + '%';

        // Grid Metrics
        document.getElementById('metric-impressions').textContent = fmtNum(O);
        document.getElementById('metric-social-reach').textContent = fmtNum(Y);
        document.getElementById('metric-leads').textContent = fmtNum(he);
        document.getElementById('metric-ad-value').textContent = fmt(xe, currency);

        // CPM & CPL Comparison labels
        const cpmEl = document.getElementById('metric-cpm');
        const cpmLabel = document.getElementById('comparison-cpm');
        cpmEl.textContent = U > 0 ? fmt(U, currency) : '—';
        const cpmDiff = ((U - avgCpm[currency]) / avgCpm[currency] * 100);
        cpmLabel.innerHTML = cpmDiff <= 0
            ? `<span class="text-emerald-600 font-semibold">${Math.abs(cpmDiff).toFixed(0)}% cheaper</span> than avg`
            : `<span class="text-rose-500 font-semibold">${cpmDiff.toFixed(0)}% higher</span> than avg`;

        const cplEl = document.getElementById('metric-cpl');
        const cplLabel = document.getElementById('comparison-cpl');
        cplEl.textContent = se > 0 ? fmt(se, currency) : '—';
        const cplDiff = ((se - avgCpl[currency]) / avgCpl[currency] * 100);
        cplLabel.innerHTML = cplDiff <= 0
            ? `<span class="text-emerald-600 font-semibold">${Math.abs(cplDiff).toFixed(0)}% cheaper</span> than avg`
            : `<span class="text-rose-500 font-semibold">${cplDiff.toFixed(0)}% higher</span> than avg`;

        // Brand Value Card
        document.getElementById('brand-value-val').textContent = fmt(brandValue, currency);
        const bvBadge = document.getElementById('brand-value-badge');
        if (brandValue > investment * 3) {
            bvBadge.textContent = 'Excellent Value';
            bvBadge.className = 'text-[10px] px-2 py-0.5 rounded-full font-bold uppercase bg-emerald-500/10 text-emerald-600';
        } else if (brandValue > investment) {
            bvBadge.textContent = 'Good Value';
            bvBadge.className = 'text-[10px] px-2 py-0.5 rounded-full font-bold uppercase bg-orange-500/10 text-orange-600';
        } else {
            bvBadge.textContent = 'High Cost';
            bvBadge.className = 'text-[10px] px-2 py-0.5 rounded-full font-bold uppercase bg-rose-500/10 text-rose-600';
        }

        // Factor Breakdown Rendering
        const breakdownList = document.getElementById('breakdown-list');
        breakdownList.innerHTML = '';

        const factorData = [
            { factor: "Base Event Size", multiplier: 1, contribution: audienceSize },
            { factor: "Sponsorship Level multiplier", multiplier: _, contribution: Math.round(audienceSize * (_ - 1)) },
            { factor: "Event Duration multiplier", multiplier: S, contribution: Math.round(audienceSize * (S - 1)) },
            { factor: "Benefits Package scale", multiplier: C / 2, contribution: Math.round(audienceSize * (C / 2 - 1)) },
            { factor: "Location & Venue premium", multiplier: T, contribution: Math.round(audienceSize * (T - 1)) },
            { factor: "Digital Amplification", multiplier: A, contribution: Math.round(audienceSize * (A - 1)) },
            { factor: "Media Coverage scale", multiplier: $, contribution: Math.round(audienceSize * ($ - 1)) },
            { factor: "Organizer Trust profile", multiplier: M, contribution: Math.round(audienceSize * (M - 1)) },
            { factor: "Celebrity / VIP attraction", multiplier: B, contribution: Math.round(audienceSize * (B - 1)) },
            { factor: "Organic Viral potential", multiplier: I, contribution: Math.round(audienceSize * (I - 1)) }
        ].filter(item => item.multiplier > 1);

        const maxContrib = Math.max(...factorData.map(d => d.contribution), 1);
        const barColor = (name) => {
            if (name.includes("Celebrity")) return "bg-terracotta-500";
            if (name.includes("Viral")) return "bg-emerald-500";
            if (name.includes("Media")) return "bg-blue-500";
            if (name.includes("Digital")) return "bg-purple-500";
            if (name.includes("Location")) return "bg-amber-500";
            if (name.includes("Sponsorship")) return "bg-indigo-500";
            if (name.includes("Duration")) return "bg-teal-500";
            if (name.includes("Benefits")) return "bg-pink-500";
            return "bg-cyan-500";
        };

        factorData.forEach(item => {
            const barPct = Math.min(100, (item.contribution / maxContrib) * 100);
            const row = document.createElement('div');
            row.className = 'space-y-1.5';
            row.innerHTML = `
                <div class="flex justify-between items-center text-xs">
                    <span class="font-medium text-gray-700">${item.factor}</span>
                    <span class="font-semibold text-gray-900">${item.multiplier.toFixed(1)}x boost</span>
                </div>
                <div class="relative h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="${barColor(item.factor)} h-full rounded-full transition-all duration-300" style="width: ${barPct}%"></div>
                </div>
            `;
            breakdownList.appendChild(row);
        });
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/pages/roi-calculator.blade.php ENDPATH**/ ?>