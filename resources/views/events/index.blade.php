<x-guest-layout>
    <x-slot name="title">{{ isset($isPast) && $isPast ? 'Past Events - EventsDomain' : 'Browse Events - EventsDomain' }}</x-slot>

    <section class="relative overflow-hidden gradient-hero min-h-[40vh] flex items-center">
        <div class="absolute inset-0 bg-pattern opacity-5"></div>
        <div class="container-page relative z-10 text-center">
            @if(isset($isPast) && $isPast)
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Past Events</h1>
                <p class="text-xl text-white/70 max-w-2xl mx-auto">Explore events that have already taken place</p>
            @else
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Browse Events</h1>
                <p class="text-xl text-white/70 max-w-2xl mx-auto">Discover exciting events looking for sponsors and partners</p>
            @endif
        </div>
    </section>

    <section class="section">
        <div class="container-page">
            <div class="card p-5 mb-8">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div class="input-group mb-0 min-w-[160px]">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                        <select name="category" class="input-field">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-0 min-w-[140px]">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Event Type</label>
                        <select name="type" class="input-field">
                            <option value="">All Types</option>
                            <option value="physical" {{ request('type') === 'physical' ? 'selected' : '' }}>In-Person</option>
                            <option value="virtual" {{ request('type') === 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="hybrid" {{ request('type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
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
                    <div class="input-group mb-0 min-w-[150px]">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget Range</label>
                        <select name="budget_range" class="input-field">
                            <option value="">Any Budget</option>
                            <option value="0-50000" {{ request('budget_range') === '0-50000' ? 'selected' : '' }}>Under ₹50K</option>
                            <option value="50000-200000" {{ request('budget_range') === '50000-200000' ? 'selected' : '' }}>₹50K - ₹2L</option>
                            <option value="200000-500000" {{ request('budget_range') === '200000-500000' ? 'selected' : '' }}>₹2L - ₹5L</option>
                            <option value="500000-1000000" {{ request('budget_range') === '500000-1000000' ? 'selected' : '' }}>₹5L - ₹10L</option>
                            <option value="1000000+" {{ request('budget_range') === '1000000+' ? 'selected' : '' }}>₹10L+</option>
                        </select>
                    </div>
                    <div class="input-group mb-0 min-w-[200px] flex-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Search</label>
                        <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" class="input-field">
                    </div>
                    <button type="submit" class="btn-primary">Search</button>
                    @if(request()->anyFilled(['category', 'type', 'sponsorship_type', 'budget_range', 'search']))
                        <a href="{{ route('events.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
                    @endif
                </form>
            </div>

            @if($events->count())
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-500">{{ $events->total() }} event{{ $events->total() !== 1 ? 's' : '' }} found</p>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-500">Sort:</label>
                        <select name="sort" class="input-field text-sm py-1.5" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Viewed</option>
                            <option value="budget_high" {{ request('sort') === 'budget_high' ? 'selected' : '' }}>Budget: High to Low</option>
                            <option value="budget_low" {{ request('sort') === 'budget_low' ? 'selected' : '' }}>Budget: Low to High</option>
                        </select>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="card-hover group">
                        <div class="relative h-48 overflow-hidden">
                            @if($event->cover_image_url)
                                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.parentElement.innerHTML='<div class=&quot;w-full h-full bg-gradient-to-br from-terracotta-400 to-terracotta-700&quot;></div>'">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-terracotta-400 to-terracotta-700"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                <span class="badge-dark text-xs">{{ $event->category->name ?? 'General' }}</span>
                                @if($event->is_featured)
                                    <span class="bg-amber-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">Featured</span>
                                @endif
                                @if($event->sponsorship_type)
                                    <span class="bg-emerald-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">{{ ucfirst($event->sponsorship_type) }}</span>
                                @endif
                            </div>
                            @if($event->views_count > 0)
                                <div class="absolute top-3 right-3 bg-black/40 text-white text-xs px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    {{ number_format($event->views_count) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                @if(isset($isPast) && $isPast)
                                    <span class="bg-gray-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">Completed</span>
                                @else
                                    @if($event->event_type === 'virtual')
                                        <span class="badge-primary text-xs">Virtual</span>
                                    @elseif($event->event_type === 'hybrid')
                                        <span class="badge-warning text-xs">Hybrid</span>
                                    @else
                                        <span class="badge-success text-xs">In-Person</span>
                                    @endif
                                @endif
                            </div>
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
                                        <span class="text-sm text-terracotta-600 font-semibold">
                                            @if($event->budget_min && $event->budget_max)
                                                ₹{{ number_format($event->budget_min/1000, $event->budget_min >= 100000 ? 0 : 1) }}K-₹{{ number_format($event->budget_max/1000, $event->budget_max >= 100000 ? 0 : 1) }}K
                                            @elseif($event->budget_min)
                                                ₹{{ number_format($event->budget_min/1000, $event->budget_min >= 100000 ? 0 : 1) }}K+
                                            @else
                                                Up to ₹{{ number_format($event->budget_max/1000, $event->budget_max >= 100000 ? 0 : 1) }}K
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('events.show', $event->slug) }}" class="text-terracotta-500 font-semibold text-sm hover:text-terracotta-600 transition flex items-center gap-1">
                                    Details
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
                        <p class="text-gray-400 text-sm">Try adjusting your filters or search terms.</p>
                    </div>
                @endforelse
            </div>

            @if($events->hasPages())
                <div class="mt-10">
                    {{ $events->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>
</x-guest-layout>
