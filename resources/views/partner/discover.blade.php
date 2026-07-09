<x-app-layout>
    <x-slot name="title">Discover Events - Partner</x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Discover Events</h1>
                <p class="text-gray-500 text-sm mt-1">Events matching your interests and preferences.</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <span>{{ $partner->company_name }}</span>
                @if($partner->city)
                    <span class="text-gray-300">|</span>
                    <span>{{ $partner->city }}, {{ $partner->country }}</span>
                @endif
            </div>
        </div>

        {{-- Partner Preferences Summary --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">Industries:</span>
                    @forelse($partner->industries as $industry)
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $industry->label }}</span>
                    @empty
                        <span class="text-gray-400">All</span>
                    @endforelse
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">Categories:</span>
                    @forelse($partner->categories as $category)
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $category->name }}</span>
                    @empty
                        <span class="text-gray-400">All</span>
                    @endforelse
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">Cities:</span>
                    @forelse($partner->preferredCities as $pc)
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $pc->city }}</span>
                    @empty
                        <span class="text-gray-400">All</span>
                    @endforelse
                </div>
                @if($partner->budget_range)
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">Budget:</span>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">{{ ucwords(str_replace('_', ' ', $partner->budget_range)) }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Events Grid --}}
        @if($events->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">No events found</h3>
                <p class="text-sm text-gray-500">No live events match your current preferences. Try adjusting your filters or check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition">
                        {{-- Cover Image --}}
                        <div class="h-40 bg-gradient-to-br from-[#F26C4F] to-orange-300 flex items-center justify-center">
                            @if($event->cover_image)
                                <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="p-5 space-y-3">
                            {{-- Title & Category --}}
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $event->title }}</h3>
                                <p class="text-xs text-[#F26C4F] font-medium mt-1">{{ $event->category->name ?? '' }}</p>
                            </div>

                            {{-- Date & Location --}}
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                @if($event->start_date)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $event->start_date->format('M d, Y') }}
                                    </span>
                                @endif
                                @if($event->city)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $event->city }}
                                    </span>
                                @endif
                            </div>

                            {{-- Audience --}}
                            @if($event->expected_audience)
                                <p class="text-xs text-gray-500">Expected audience: <span class="font-medium text-gray-700">{{ number_format($event->expected_audience) }}</span></p>
                            @endif

                            {{-- Sponsorship Levels --}}
                            @if($event->sponsorshipLevels->count())
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($event->sponsorshipLevels as $level)
                                        <span class="px-2 py-0.5 bg-orange-50 text-[#F26C4F] text-[10px] font-medium rounded-full border border-orange-200">
                                            {{ ucfirst(str_replace('_', ' ', $level->level)) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Plan Badge --}}
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                    {{ $event->plan === 'homepage' ? 'bg-purple-100 text-purple-700' : ($event->plan === 'featured' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($event->plan) }}
                                </span>
                                <span class="text-xs text-gray-400">{{ ucfirst($event->sponsorship_type ?? '') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $events->withQueryString()->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
