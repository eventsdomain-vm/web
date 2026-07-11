<x-guest-layout>
    <x-slot name="title">{{ $sort === 'past' ? 'Past Events - EventsDomain' : 'Find Sponsorship Opportunities - EventsDomain' }}</x-slot>
    <x-slot name="meta_description">Connect with events seeking sponsors. Browse brand partnership opportunities across India.</x-slot>

    {{-- Hero Section — same background image as /partners --}}
    <section class="relative overflow-hidden text-white bg-cover bg-center" style="background-image: url('/images/partners-hero.jpg');">
        <div class="absolute inset-0 bg-gradient-to-br from-terracotta-900/85 via-terracotta-700/65 to-terracotta-500/50"></div>
        <div class="container-page py-14 lg:py-20 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white leading-tight mb-4">
                    Find Sponsorship Opportunities
                </h1>
                <p class="text-base sm:text-lg text-orange-100/80 mb-10 max-w-xl mx-auto">
                    Connect with events seeking sponsors. Browse brand partnership opportunities across India.
                </p>
                {{-- Clean pill search bar --}}
                <div class="relative max-w-2xl mx-auto">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        form="filter-form"
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search events..."
                        class="w-full rounded-full border-0 bg-white py-4 pl-14 pr-6 text-sm text-slate-800 shadow-xl outline-none focus:ring-2 focus:ring-white/40 placeholder:text-slate-400"
                    />
                </div>
            </div>
        </div>
    </section>


    {{-- Main Layout --}}
    <section class="bg-gray-50 min-h-screen py-8 lg:py-10">
        <div class="container-page">
            <div class="flex gap-6 lg:gap-8 items-start">

                {{-- ─── Left Sidebar ─────────────────────────────────────────────── --}}
                <aside class="w-[260px] shrink-0 sticky top-24 self-start hidden lg:block">
                    <form method="GET" action="{{ route('events.index') }}" id="filter-form">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                            {{-- Sidebar Header --}}
                            <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                                <h3 class="text-sm font-bold text-gray-900">Filters</h3>
                                @php
                                    $activeFilters = collect(['search', 'country', 'category', 'city', 'type', 'sponsorship_type', 'budget_range', 'featured'])
                                        ->filter(fn($f) => request()->filled($f))->count();
                                @endphp
                                @if($activeFilters)
                                    <a href="{{ route('events.index', ['sort' => $sort]) }}"
                                       class="text-xs font-semibold text-terracotta-500 hover:text-terracotta-600 transition">
                                        Clear all ({{ $activeFilters }})
                                    </a>
                                @endif
                            </div>

                            <div class="p-5 space-y-5 max-h-[calc(100vh-12rem)] overflow-y-auto">

                                {{-- Country --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Country</label>
                                    <div class="relative">
                                        <select name="country"
                                                class="w-full appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-3 pr-9 text-sm text-gray-700 focus:border-terracotta-400 focus:ring-2 focus:ring-terracotta-100 focus:outline-none cursor-pointer"
                                                onchange="this.form.submit()">
                                            <option value="">All Countries</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country }}" {{ request('country') === $country ? 'selected' : '' }}>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- City --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">City</label>
                                    <div class="relative">
                                        <select name="city"
                                                class="w-full appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-3 pr-9 text-sm text-gray-700 focus:border-terracotta-400 focus:ring-2 focus:ring-terracotta-100 focus:outline-none cursor-pointer"
                                                onchange="this.form.submit()">
                                            <option value="">All Cities</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                                    {{ $city }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100"></div>

                                {{-- Category radio list --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                    <div class="space-y-0.5 max-h-52 overflow-y-auto pr-1">
                                        {{-- All --}}
                                        <label class="flex items-center gap-3 py-1.5 cursor-pointer group">
                                            <input type="radio" name="category" value="" form="filter-form"
                                                   class="sr-only" onchange="document.getElementById('filter-form').submit()"
                                                   {{ !request('category') ? 'checked' : '' }}>
                                            <span class="flex-shrink-0 h-4 w-4 rounded-full border-2 flex items-center justify-center
                                                {{ !request('category') ? 'border-terracotta-500' : 'border-gray-300 group-hover:border-gray-400' }}">
                                                @if(!request('category'))
                                                    <span class="h-2 w-2 rounded-full bg-terracotta-500 block"></span>
                                                @endif
                                            </span>
                                            <span class="text-sm text-gray-700">All Categories</span>
                                        </label>
                                        @foreach($categories as $cat)
                                            <label class="flex items-center gap-3 py-1.5 cursor-pointer group">
                                                <input type="radio" name="category" value="{{ $cat->id }}" form="filter-form"
                                                       class="sr-only" onchange="document.getElementById('filter-form').submit()"
                                                       {{ request('category') == $cat->id ? 'checked' : '' }}>
                                                <span class="flex-shrink-0 h-4 w-4 rounded-full border-2 flex items-center justify-center
                                                    {{ request('category') == $cat->id ? 'border-terracotta-500' : 'border-gray-300 group-hover:border-gray-400' }}">
                                                    @if(request('category') == $cat->id)
                                                        <span class="h-2 w-2 rounded-full bg-terracotta-500 block"></span>
                                                    @endif
                                                </span>
                                                <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="border-t border-gray-100"></div>

                                {{-- Budget Range --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Budget Range</label>
                                    <div class="space-y-0.5">
                                        @foreach([
                                            '0-100000'        => 'Under ₹1 Lakh',
                                            '100000-500000'   => '₹1–5 Lakhs',
                                            '500000-1000000'  => '₹5–10 Lakhs',
                                            '1000000-2500000' => '₹10–25 Lakhs',
                                            '2500000-5000000' => '₹25–50 Lakhs',
                                            '5000000+'        => '₹50 Lakhs+',
                                        ] as $bVal => $bLabel)
                                            <label class="flex items-center gap-3 py-1.5 cursor-pointer group">
                                                <input type="radio" name="budget_range" value="{{ $bVal }}" form="filter-form"
                                                       class="sr-only" onchange="document.getElementById('filter-form').submit()"
                                                       {{ request('budget_range') === $bVal ? 'checked' : '' }}>
                                                <span class="flex-shrink-0 h-4 w-4 rounded-full border-2 flex items-center justify-center
                                                    {{ request('budget_range') === $bVal ? 'border-terracotta-500' : 'border-gray-300 group-hover:border-gray-400' }}">
                                                    @if(request('budget_range') === $bVal)
                                                        <span class="h-2 w-2 rounded-full bg-terracotta-500 block"></span>
                                                    @endif
                                                </span>
                                                <span class="text-sm text-gray-700">{{ $bLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="border-t border-gray-100"></div>

                                {{-- Sponsorship Type --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sponsorship Type</label>
                                    <div class="space-y-0.5">
                                        @foreach(['paid' => 'Paid', 'barter' => 'Barter', 'hybrid' => 'Paid + Barter'] as $stVal => $stLabel)
                                            <label class="flex items-center gap-3 py-1.5 cursor-pointer group">
                                                <input type="radio" name="sponsorship_type" value="{{ $stVal }}" form="filter-form"
                                                       class="sr-only" onchange="document.getElementById('filter-form').submit()"
                                                       {{ request('sponsorship_type') === $stVal ? 'checked' : '' }}>
                                                <span class="flex-shrink-0 h-4 w-4 rounded-full border-2 flex items-center justify-center
                                                    {{ request('sponsorship_type') === $stVal ? 'border-terracotta-500' : 'border-gray-300 group-hover:border-gray-400' }}">
                                                    @if(request('sponsorship_type') === $stVal)
                                                        <span class="h-2 w-2 rounded-full bg-terracotta-500 block"></span>
                                                    @endif
                                                </span>
                                                <span class="text-sm text-gray-700">{{ $stLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="border-t border-gray-100"></div>

                                {{-- Featured toggle --}}
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="featured" value="1"
                                           {{ request('featured') ? 'checked' : '' }}
                                           class="sr-only peer" onchange="this.form.submit()">
                                    <div class="relative w-9 h-5 rounded-full border-2 transition-colors duration-200
                                                peer-checked:bg-terracotta-500 peer-checked:border-terracotta-500
                                                border-gray-300 bg-gray-100">
                                        <div class="absolute top-0.5 left-0.5 w-3.5 h-3.5 rounded-full bg-white shadow-sm
                                                    transition-transform duration-200 peer-checked:translate-x-3.5"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Featured Events Only</span>
                                </label>

                            </div>{{-- /p-5 --}}
                        </div>
                    </form>
                </aside>

                {{-- ─── Main Content ──────────────────────────────────────────────── --}}
                <div class="flex-1 min-w-0">

                    {{-- Content Header: count + sort dropdown --}}
                    <div class="flex items-center justify-between mb-5">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-gray-900">{{ number_format($events->total()) }}</span>
                            event{{ $events->total() !== 1 ? 's' : '' }} found
                        </p>
                        <div class="relative">
                            <select name="sort" form="filter-form"
                                    class="appearance-none rounded-lg border border-gray-200 bg-white py-2 pl-4 pr-9 text-sm text-gray-700 font-medium shadow-sm focus:border-terracotta-400 focus:ring-2 focus:ring-terracotta-100 focus:outline-none cursor-pointer"
                                    onchange="this.form.submit()">
                                <option value="upcoming" {{ $sort === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="newest"   {{ $sort === 'newest'   ? 'selected' : '' }}>Newest</option>
                                <option value="popular"  {{ $sort === 'popular'  ? 'selected' : '' }}>Popular</option>
                                <option value="past"     {{ $sort === 'past'     ? 'selected' : '' }}>Past</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile filter bar (hidden on lg+) --}}
                    <div class="lg:hidden mb-5">
                        <form method="GET" action="{{ route('events.index') }}" id="filter-form-mobile" class="flex gap-2 flex-wrap">
                            <div class="relative flex-1 min-w-[140px]">
                                <select name="country" class="w-full appearance-none rounded-lg border border-gray-200 bg-white py-2 pl-3 pr-8 text-sm text-gray-700" onchange="this.form.submit()">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ request('country') === $country ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                            <div class="relative flex-1 min-w-[140px]">
                                <select name="city" class="w-full appearance-none rounded-lg border border-gray-200 bg-white py-2 pl-3 pr-8 text-sm text-gray-700" onchange="this.form.submit()">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                            <input type="hidden" name="sort" value="{{ $sort }}">
                        </form>
                    </div>

                    {{-- Event Cards Grid —— 3 per row on desktop --}}
                    @if($events->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
                            @foreach($events as $event)
                                <a href="{{ route('events.show', $event->slug) }}"
                                   class="group block bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden
                                          hover:shadow-lg hover:-translate-y-0.5 transition duration-200">

                                    {{-- Card Image --}}
                                    <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">

                                        @if($event->cover_image_url)
                                            <img src="{{ $event->cover_image_url }}"
                                                 alt="{{ $event->title }}"
                                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                                                 loading="lazy"
                                                 onerror="this.parentElement.querySelector('.img-fallback').classList.remove('hidden'); this.remove()">
                                        @endif
                                        <div class="img-fallback {{ $event->cover_image_url ? 'hidden' : '' }} w-full h-full absolute inset-0 bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900"></div>

                                        {{-- Top badges row --}}
                                        <div class="absolute top-3 left-3 right-3 flex justify-between items-start gap-2">
                                            {{-- Trending (left) --}}
                                            <div>
                                                @if($event->is_featured)
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-terracotta-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                                                        🔥 Trending
                                                    </span>
                                                @endif
                                            </div>
                                            {{-- Paid/Barter (right) --}}
                                            <div>
                                                @if($event->sponsorship_type)
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white shadow-sm">
                                                        💳 {{ $event->sponsorship_type === 'paid' ? 'Paid' : ($event->sponsorship_type === 'barter' ? 'Barter' : 'Paid+Barter') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Category semi-circle tag — bottom-left of image --}}
                                        <div class="absolute bottom-0 left-0">
                                            <span class="block bg-white px-4 py-1.5 rounded-tr-2xl text-xs font-semibold text-gray-700 border-t border-r border-gray-200/80 shadow-sm">
                                                {{ $event->category->name ?? 'General' }}
                                            </span>
                                        </div>
                                    </div>{{-- /image --}}

                                    {{-- Card Body --}}
                                    <div class="p-5">
                                        <h3 class="font-bold text-base text-gray-900 leading-snug line-clamp-2 mb-3">
                                            {{ $event->title }}
                                        </h3>

                                        {{-- 4 Detail rows --}}
                                        <div class="space-y-2 mb-4">

                                            {{-- Location --}}
                                            <div class="flex items-center gap-2 text-sm text-gray-500 min-w-0">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a2 2 0 00-2.828 0L6.343 16.657m11.314 0a8 8 0 11-11.314 0 8 8 0 0111.314 0z"/>
                                                </svg>
                                                <span class="truncate">{{ $event->city }}{{ $event->city && ($event->state ?? $event->country) ? ', ' : '' }}{{ $event->state ?? ($event->country ?? 'India') }}</span>
                                            </div>

                                            {{-- Date --}}
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $event->start_date->format('M j, Y') }}</span>
                                            </div>

                                            {{-- Expected Audience --}}
                                            @if($event->expected_audience)
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    <span>{{ number_format($event->expected_audience) }} expected</span>
                                                </div>
                                            @endif

                                            {{-- Budget --}}
                                            @if($event->budget_min || $event->budget_max)
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>
                                                        @php
                                                            $bMin = $event->budget_min ? (float)$event->budget_min : null;
                                                            $bMax = $event->budget_max ? (float)$event->budget_max : null;
                                                            $fmt = function($n) {
                                                                if ($n >= 10000000) return '₹' . round($n/10000000,1) . ' Cr';
                                                                if ($n >= 100000)   return '₹' . round($n/100000,1) . ' Lakhs';
                                                                if ($n >= 1000)     return '₹' . round($n/1000) . 'K';
                                                                return '₹' . number_format($n);
                                                            };
                                                        @endphp
                                                        @if($bMin && $bMax)
                                                            {{ $fmt($bMin) }} – {{ $fmt($bMax) }}
                                                        @elseif($bMin)
                                                            {{ $fmt($bMin) }}+
                                                        @else
                                                            Under {{ $fmt($bMax) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif

                                        </div>{{-- /detail rows --}}

                                        {{-- Card Footer --}}
                                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                            <span class="text-xs text-gray-400 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ $event->views_count ? number_format($event->views_count) . ' views' : '–' }}
                                            </span>
                                            <span class="inline-flex items-center justify-center rounded-full bg-terracotta-500 px-4 py-1.5 text-xs font-semibold text-white transition duration-200 group-hover:bg-terracotta-600 shadow-sm">
                                                View Details
                                            </span>
                                        </div>
                                    </div>{{-- /card body --}}

                                </a>
                            @endforeach
                        </div>{{-- /grid --}}

                        {{-- Pagination --}}
                        @if($events->hasPages())
                            <div class="mt-10">
                                {{ $events->withQueryString()->links() }}
                            </div>
                        @endif

                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-24 bg-white rounded-2xl border border-gray-200">
                            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400 text-lg font-medium mb-1">No events found</p>
                            <p class="text-gray-400 text-sm">Try adjusting your filters or search terms.</p>
                            <a href="{{ route('events.index') }}"
                               class="inline-flex mt-5 items-center gap-2 rounded-full bg-terracotta-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-terracotta-600 transition">
                                Clear Filters
                            </a>
                        </div>
                    @endif

                </div>{{-- /main content --}}
            </div>{{-- /flex --}}
        </div>{{-- /container --}}
    </section>

</x-guest-layout>
