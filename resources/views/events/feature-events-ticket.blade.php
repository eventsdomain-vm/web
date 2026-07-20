<x-guest-layout>
    <x-slot name="title">Featured Events - EventsDomain</x-slot>
    <x-slot name="meta_description">Discover exciting opportunities and featured events with professional ticket-style layouts.</x-slot>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden text-white" style="background: linear-gradient(135deg, #4A6362 0%, #3e5053 100%);">
        <div class="absolute inset-0 bg-black/20" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"80\" height=\"80\" viewBox=\"0 0 80 80\"><rect width=\"1\" height=\"1\" fill=\"rgba(255,255,255,0.08)\"/><path d=\"M0 0 L40 40 L0 80 Z\" fill=\"rgba(255,255,255,0.06)\"/></svg>') ; background-size: 40px 40px;"></div>
        <div class="container-page py-16 lg:py-24 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6 tracking-tight">Discover Exciting Opportunities</h1>
                <p class="text-lg lg:text-xl text-white/80 mb-8 leading-relaxed">Explore events looking for sponsors and partners in cities across India</p>
                <div class="inline-flex items-center bg-white/10 backdrop-blur-md rounded-full px-6 py-3 border border-white/20">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
                    <span class="text-white text-sm font-medium">Live Opportunities Available</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Events Grid with Ticket-Style Layouts --}}
    <section class="section bg-gradient-to-b from-gray-50 to-white">
        <div class="container-page">
            <div class="text-center mb-12">
                <span class="section-label">Featured Events</span>
                <h2 class="section-title mt-3">Live Opportunities</h2>
                <p class="section-subtitle mt-4 mx-auto">Professional event listings with detailed information and sponsorship opportunities</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                @forelse($featuredEvents as $event)
                    <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="group block">
                        <div class="relative overflow-hidden rounded-3xl bg-white shadow-elegant hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-gray-200">
                            {{-- Ticket-style Ribbon --}}
                            <div class="absolute top-0 right-0 z-20 p-6">
                                <div class="bg-gradient-to-r from-terracotta-500 to-terracotta-600 rounded-2xl px-4 py-2 transform rotate-3 shadow-lg">
                                    <span class="text-white text-sm font-bold uppercase tracking-wide">
                                        @if($event->sponsorship_type)
                                            {{ $event->sponsorship_type === 'paid' ? '💳 PAID' : ($event->sponsorship_type === 'barter' ? '🔄 BARTER' : '💎 HYBRID') }}
                                        @else
                                            SOLVE PARTNER
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Event Image Section (Right Side) --}}
                            <div class="relative h-64 lg:h-72 overflow-hidden rounded-t-3xl bg-gradient-to-br from-gray-900 to-gray-800">
                                @if($event->cover_image_url)
                                    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="hidden w-full h-full items-center justify-center text-white/40 absolute inset-0">
                                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14v3a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707L20 8.586V20a2 2 0 01-2 2h-3a2 2 0 01-2-2V16z"/>
                                    </svg>
                                </div>

                                {{-- Featured Badge --}}
                                @if($event->is_featured)
                                    <div class="absolute top-4 left-4">
                                        <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-full px-4 py-2 shadow-lg">
                                            <span class="text-white text-xs font-bold uppercase tracking-wider">🌟 Featured</span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Category Tag --}}
                                <div class="absolute bottom-4 right-4">
                                    <div class="bg-white/95 backdrop-blur-md rounded-full px-4 py-2 shadow-lg">
                                        <span class="text-gray-800 text-sm font-semibold">{{ $event->category->name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Ticket Content (Left Side) --}}
                            <div class="p-8 lg:p-10">
                                {{-- Event Name & Basic Info --}}
                                <div class="mb-6">
                                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 group-hover:text-terracotta-600 transition-colors leading-tight line-clamp-2">
                                        {{ $event->title }}
                                    </h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>{{ $event->city ?? 'India' }}, {{ $event->state ?? '' }}{{ $event->state ? ', ' : '' }}{{ $event->country ?? '' }}</span>
                                        </div>
                                        @if($event->start_date)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $event->start_date->format('M d, Y') }}</span>
                                            </div>
                                        @endif
                                        @if($event->start_date && $event->end_date)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>{{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Event Description --}}
                                <div class="mb-8">
                                    <p class="text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit($event->description, 180) }}
                                    </p>
                                </div>

                                {{-- Event Details Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    {{-- Attendees (Left Side) --}}
                                    <div class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 font-medium">Expected Audience</div>
                                            <div class="text-2xl font-bold text-blue-600">
                                                @if($event->expected_audience)
                                                    {{ number_format($event->expected_audience) }}+
                                                @else
                                                    500+
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Ticket Cost (Right Side) --}}
                                    <div class="flex items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100">
                                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 font-medium">Sponsorship Level</div>
                                            <div class="text-xl font-bold text-green-600">
                                                @if($event->budget_min || $event->budget_max)
                                                    @php
                                                        $bMin = $event->budget_min ? (float)$event->budget_min : null;
                                                        $bMax = $event->budget_max ? (float)$event->budget_max : null;
                                                        $fmt = function($n) {
                                                            if ($n >= 10000000) return '₹' . round($n/10000000,1) . ' Cr';
                                                            if ($n >= 100000) return '₹' . round($n/100000,1) . ' Lakhs';
                                                            if ($n >= 1000) return '₹' . round($n/1000) . 'K';
                                                            return '₹' . number_format($n);
                                                        };
                                                    @endphp
                                                    {{ $bMin && $bMax ? $fmt($bMin) . ' - ' . $fmt($bMax) : ($bMin ? $fmt($bMin) . '+' : ($bMax ? 'Under ' . $fmt($bMax) : 'Custom')) }}
                                                @else
                                                    Custom
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- View Event Button --}}
                                <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                    <div class="text-sm text-gray-500">
                                        @if($event->approval_status === 'approved' && $event->is_published)
                                            <span class="inline-flex items-center gap-2 text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Live Now
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                                Processing
                                            </span>
                                        @endif
                                    </div>
                                    <button onclick="event.preventDefault(); window.location='{{ route('events.show', $event->slug ?? $event->id) }}'" 
                                            class="group/btn inline-flex items-center gap-2 bg-terracotta-500 hover:bg-terracotta-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <span>View Event Details</span>
                                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Empty State with Skeleton Loaders --}}
                    <div class="col-span-full">
                        <div class="text-center py-16 bg-white rounded-3xl shadow-elegant border border-gray-100">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No events found</h3>
                            <p class="text-gray-600 mb-6">Try adjusting your filters or check back later for new opportunities.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 bg-terracotta-500 hover:bg-terracotta-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                Browse All Events
                            </a>
                        </div>
                    </div>
                    
                    {{-- Skeleton loaders for better UX --}}
                    @for($i = 0; $i < 4; $i++)
                        <div class="hidden lg:block">
                            <div class="bg-white rounded-3xl shadow-elegant p-8 border border-gray-100">
                                <div class="animate-pulse">
                                    <div class="h-64 bg-gray-200 rounded-2xl mb-6"></div>
                                    <div class="h-6 bg-gray-200 rounded w-3/4 mb-4"></div>
                                    <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                                    <div class="h-4 bg-gray-200 rounded w-5/6 mb-6"></div>
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="h-20 bg-gray-200 rounded-2xl"></div>
                                        <div class="h-20 bg-gray-200 rounded-2xl"></div>
                                    </div>
                                    <div class="h-12 bg-gray-200 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>

    {{-- Pagination --}}
    @if($featuredEvents->hasPages())
        <div class="mt-16 flex justify-center">
            <nav class="inline-flex rounded-2xl shadow-lg bg-white border border-gray-200 p-2">
                {{ $featuredEvents->links() }}
            </nav>
        </div>
    @endif
        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="section bg-gradient-to-r from-terracotta-500 to-terracotta-600 text-white">
        <div class="container-page">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="heading-2 text-white mb-6">Ready to Find Your Perfect Partnership?</h2>
                <p class="text-xl text-white/90 mb-10 leading-relaxed">Join thousands of organizers and sponsors already connecting through EventsDomain to create memorable events together.</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="btn-white btn-lg group">
                        Start Free Today
                        <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#events" class="btn-outline-white btn-lg">
                        Browse Events
                        <svg class="w-5 h-5 ml-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>