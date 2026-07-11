<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Events</h2>
            <p class="text-sm text-gray-500">{{ method_exists($events, 'total') ? $events->total() : $events->count() }} event{{ (method_exists($events, 'total') ? $events->total() : $events->count()) !== 1 ? 's' : '' }} available</p>
        </div>
    </x-slot>

    <div class="card p-5 mb-6" x-data="{ advanced: {{ request()->anyFilled(['budget_min','budget_max','audience_min','audience_max','target_age_group','target_gender','venue_type','ticket_price_min','ticket_price_max','has_celebrity','has_govt_support','has_media_coverage','instagram_reach_min','youtube_reach_min','website_traffic_min','start_from','start_to', 'city']) ? 'true' : 'false' }} }">
        <form method="GET">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="input-group mb-0 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                    <select name="category" class="input-field">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[140px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sponsorship</label>
                    <select name="sponsorship_type" class="input-field">
                        <option value="">All Types</option>
                        <option value="paid" {{ request('sponsorship_type') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="barter" {{ request('sponsorship_type') === 'barter' ? 'selected' : '' }}>Barter / In-Kind</option>
                        <option value="hybrid" {{ request('sponsorship_type') === 'hybrid' ? 'selected' : '' }}>Paid + Barter</option>
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">City</label>
                    <select name="city" class="input-field">
                        <option value="">All Cities</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}" {{ request('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-0 min-w-[200px] flex-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Search</label>
                    <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" class="input-field">
                </div>
                <button type="submit" class="btn-primary">Search</button>
                <button type="button" @click="advanced = !advanced" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    <svg class="w-4 h-4" :class="{ 'rotate-180': advanced }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Filters
                </button>
                @if(request()->anyFilled(['category', 'sponsorship_type', 'search', 'budget_min', 'budget_max', 'audience_min', 'audience_max', 'city']))
                    <a href="{{ route('sponsor.events.index') }}" class="text-sm text-red-500 hover:text-red-700">Clear All</a>
                @endif
            </div>

            <div x-show="advanced" x-collapse class="mt-4 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Age Group</label>
                        <select name="target_age_group" class="input-field">
                            <option value="">Any Age</option>
                            <option value="children" {{ request('target_age_group') === 'children' ? 'selected' : '' }}>Children (0-12)</option>
                            <option value="teens" {{ request('target_age_group') === 'teens' ? 'selected' : '' }}>Teens (13-19)</option>
                            <option value="young_adults" {{ request('target_age_group') === 'young_adults' ? 'selected' : '' }}>Young Adults (20-30)</option>
                            <option value="adults" {{ request('target_age_group') === 'adults' ? 'selected' : '' }}>Adults (31-50)</option>
                            <option value="seniors" {{ request('target_age_group') === 'seniors' ? 'selected' : '' }}>Seniors (50+)</option>
                            <option value="all" {{ request('target_age_group') === 'all' ? 'selected' : '' }}>All Ages</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Gender</label>
                        <select name="target_gender" class="input-field">
                            <option value="">Any</option>
                            <option value="male" {{ request('target_gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('target_gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="all" {{ request('target_gender') === 'all' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Venue Type</label>
                        <select name="venue_type" class="input-field">
                            <option value="">Any Venue</option>
                            <option value="indoor" {{ request('venue_type') === 'indoor' ? 'selected' : '' }}>Indoor</option>
                            <option value="outdoor" {{ request('venue_type') === 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                            <option value="hybrid" {{ request('venue_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="virtual" {{ request('venue_type') === 'virtual' ? 'selected' : '' }}>Virtual</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date From</label>
                        <input type="date" name="start_from" value="{{ request('start_from') }}" class="input-field">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget Min (₹)</label>
                        <input type="number" name="budget_min" min="0" step="0.01" value="{{ request('budget_min') }}" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget Max (₹)</label>
                        <input type="number" name="budget_max" min="0" step="0.01" value="{{ request('budget_max') }}" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Audience Min</label>
                        <input type="number" name="audience_min" min="0" value="{{ request('audience_min') }}" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Audience Max</label>
                        <input type="number" name="audience_max" min="0" value="{{ request('audience_max') }}" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ticket Price Min (₹)</label>
                        <input type="number" name="ticket_price_min" min="0" step="0.01" value="{{ request('ticket_price_min') }}" class="input-field" placeholder="Min">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ticket Price Max (₹)</label>
                        <input type="number" name="ticket_price_max" min="0" step="0.01" value="{{ request('ticket_price_max') }}" class="input-field" placeholder="Max">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Instagram Reach Min</label>
                        <input type="number" name="instagram_reach_min" min="0" value="{{ request('instagram_reach_min') }}" class="input-field" placeholder="Min followers">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">YouTube Reach Min</label>
                        <input type="number" name="youtube_reach_min" min="0" value="{{ request('youtube_reach_min') }}" class="input-field" placeholder="Min subscribers">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Website Traffic Min</label>
                        <input type="number" name="website_traffic_min" min="0" value="{{ request('website_traffic_min') }}" class="input-field" placeholder="Min monthly visits">
                    </div>
                    <div class="input-group mb-0">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date To</label>
                        <input type="date" name="start_to" value="{{ request('start_to') }}" class="input-field">
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4 mt-3">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_celebrity" value="1" {{ request('has_celebrity') ? 'checked' : '' }} class="rounded text-terracotta-500">
                        Celebrity Appearance
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_govt_support" value="1" {{ request('has_govt_support') ? 'checked' : '' }} class="rounded text-terracotta-500">
                        Govt. Support
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="has_media_coverage" value="1" {{ request('has_media_coverage') ? 'checked' : '' }} class="rounded text-terracotta-500">
                        Media Coverage
                    </label>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="card-hover group">
                <div class="relative h-48 overflow-hidden">
                    @if($event->cover_image_url)
                        <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-terracotta-400 to-terracotta-700"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="badge-dark text-xs">{{ $event->category->name ?? 'General' }}</span>
                        @if($event->sponsorship_type)
                            <span class="bg-emerald-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">{{ ucfirst($event->sponsorship_type) }}</span>
                        @endif
                    </div>
                    <div class="absolute top-3 right-3 bg-green-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">Open</div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1.5 line-clamp-1">{{ $event->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $event->tagline ?? Str::limit(strip_tags($event->description), 100) }}</p>
                    <div class="flex items-center text-sm text-gray-400 mb-1.5">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ $event->start_date->format('M d, Y') }}
                    </div>
                    <div class="flex items-center text-sm text-gray-400 mb-4">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        {{ $event->city }}, {{ $event->state }}
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="text-terracotta-500 font-bold text-sm">{{ number_format($event->expected_audience) }} <span class="text-gray-400 font-normal">attendees</span></span>
                            @if($event->budget_min || $event->budget_max)
                                <span class="w-px h-4 bg-gray-200"></span>
                                <span class="text-sm text-terracotta-600 font-semibold">₹{{ number_format(($event->budget_min ?? $event->budget_max)/1000, 0) }}K</span>
                            @endif
                        </div>
                        <a href="{{ route('sponsor.events.show', $event) }}" class="text-terracotta-500 font-semibold text-sm hover:text-terracotta-600 transition flex items-center gap-1">
                            View
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-400 text-lg font-medium mb-1">No events found</p>
                <p class="text-gray-400 text-sm">Check back later for new sponsorship opportunities.</p>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="mt-8">
            @if(method_exists($events, 'links')){{ $events->withQueryString()->links() }}@endif
        </div>
    @endif
</x-app-layout>
