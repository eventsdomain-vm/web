<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->title }}</h2>
            <a href="{{ route('sponsor.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Events</a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Hero Card --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-terracotta-800 to-terracotta-950 min-h-[280px] flex items-end">
                @if($event->cover_image_url)
                    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover opacity-25">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-terracotta-950/90 to-transparent"></div>
                <div class="relative z-10 p-6 md:p-8 w-full">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="badge-dark">{{ $event->category->name ?? 'General' }}</span>
                        @if($event->sponsorship_type)
                            <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs px-2.5 py-0.5 rounded-full">{{ ucfirst($event->sponsorship_type) }}</span>
                        @endif
                        <span class="bg-green-500/20 text-green-300 border border-green-500/30 text-xs px-2.5 py-0.5 rounded-full">Open for Sponsorship</span>
                    </div>
                    <h1 class="text-2xl md:text-4xl font-bold text-white mb-2">{{ $event->title }}</h1>
                    @if($event->tagline)
                        <p class="text-white/60 text-lg">{{ $event->tagline }}</p>
                    @endif
                </div>
            </div>

            {{-- About This Event --}}
            <div class="card p-6 md:p-8">
                <h2 class="heading-3 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    About This Event
                </h2>
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            {{-- Event Details Grid --}}
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
                            <p class="font-semibold text-gray-900 capitalize">{{ $event->event_type ?? 'In-Person' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Start Date</p>
                            <p class="font-semibold text-gray-900">{{ $event->start_date->format('l, M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">End Date</p>
                            <p class="font-semibold text-gray-900">{{ $event->end_date->format('l, M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a4 4 0 11-8 0 4 4 0 018 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Expected Audience</p>
                            <p class="font-semibold text-gray-900">{{ number_format($event->expected_audience) }} attendees</p>
                        </div>
                    </div>
                    @if($event->venue)
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Venue</p>
                            <p class="font-semibold text-gray-900">{{ $event->venue }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-semibold text-gray-900">{{ $event->address ?? $event->city . ', ' . $event->state . ', ' . $event->country }}</p>
                        </div>
                    </div>
                    @if($event->category)
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Category</p>
                            <p class="font-semibold text-gray-900">{{ $event->category->name ?? 'General' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Target Audience --}}
            @if($event->audience_description || $event->expected_audience)
            <div class="card p-6 md:p-8">
                <h2 class="heading-3 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Target Audience
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-terracotta-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-terracotta-600">{{ number_format($event->expected_audience) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Expected Attendees</div>
                    </div>
                    <div class="bg-sky-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-sky-600">{{ number_format(ceil($event->expected_audience * 0.4)) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Target Demographics</div>
                    </div>
                    <div class="bg-emerald-50 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-emerald-600">{{ $event->city ?? 'Pan-India' }}</div>
                        <div class="text-sm text-gray-600 mt-1">Geographic Reach</div>
                    </div>
                </div>
                @if($event->audience_description)
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Audience Profile</p>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $event->audience_description }}</p>
                    </div>
                @endif
            </div>
            @endif

            {{-- Tags --}}
            @if($event->tags && count($event->tags))
                <div class="card p-6">
                    <h2 class="heading-3 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        Event Tags
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($event->tags as $tag)
                            <span class="badge-neutral">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Sponsorship Packages --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Sponsorship Packages
                </h3>
                @forelse($event->packages as $package)
                    <div class="border border-gray-200 rounded-2xl p-5 mb-4 last:mb-0 hover:border-terracotta-200 transition hover:shadow-sm">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <h4 class="font-bold text-gray-900">{{ $package->title }}</h4>
                            <span class="text-terracotta-500 font-bold text-lg">₹{{ number_format($package->price) }}</span>
                        </div>
                        @if($package->description)
                            <p class="text-sm text-gray-500 mb-3">{{ $package->description }}</p>
                        @endif
                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                {{ $package->slots_filled }}/{{ $package->slots_available }} slots
                            </span>
                            @if($package->benefitRecords->count())
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $package->benefitRecords->count() }} benefits</span>
                            @endif
                        </div>
                        @if($package->benefitRecords->count())
                            <div class="bg-gray-50 rounded-xl p-3 mb-4">
                                @foreach($package->benefitRecords as $benefit)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 py-0.5">
                                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                        {{ $benefit->benefit_text }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if($package->isAvailable())
                            <button onclick="openRequestModal({{ $package->id }}, '{{ $package->title }}', {{ $package->price }})" class="btn-primary w-full text-sm">
                                Request Sponsorship
                            </button>
                        @else
                            <button disabled class="w-full bg-gray-100 text-gray-400 py-3 rounded-xl text-sm font-semibold cursor-not-allowed">Sold Out</button>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-gray-500 text-sm">No packages available for this event.</p>
                    </div>
                @endforelse
            </div>

            {{-- Event at a Glance --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Event at a Glance</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Category</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $event->category->name ?? 'General' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Views</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($event->views_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Packages</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $event->packages->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Expected</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($event->expected_audience) }}</span>
                    </div>
                    @if($event->health_score)
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500">Health Score</span>
                        <span class="text-sm font-semibold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full {{ $event->health_score >= 75 ? 'bg-emerald-500' : ($event->health_score >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                            {{ number_format($event->health_score, 0) }}/100
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Save / Proposal Actions --}}
            <div class="card p-6">
                <div class="space-y-3">
                    @if($existingProposal)
                        <a href="{{ route('sponsor.proposals.show', $existingProposal) }}" class="btn-outline w-full block text-center text-sm">
                            View Your Proposal
                        </a>
                    @endif
                    <form action="{{ route('sponsor.events.toggle-save', $event) }}" method="POST" data-saved="@json($isSaved)">
                        @csrf
                        <button type="submit"
                                class="w-full py-3 px-4 rounded-xl text-sm font-semibold transition border text-center
                                {{ $isSaved ? 'bg-terracotta-500 text-white border-terracotta-500 hover:bg-terracotta-600' : 'bg-white text-gray-700 border-gray-200 hover:border-terracotta-300 hover:text-terracotta-600' }}">
                            <svg class="w-4 h-4 inline mr-1.5" fill="{{ $isSaved ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            {{ $isSaved ? 'Saved' : 'Save Event' }}
                        </button>
                    </form>
                    @if($event->health_score)
                    <div class="text-center">
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                            <div class="h-2 rounded-full transition-all duration-500 {{ $event->health_score >= 75 ? 'bg-emerald-500' : ($event->health_score >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                 style="width: {{ $event->health_score }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400">Event Health Score</p>
                    </div>
                    @endif
                    <p class="text-xs text-gray-400 text-center">{{ $savedCount }} {{ Str::plural('sponsor', $savedCount) }} saved this event</p>
                </div>
            </div>

            {{-- Organizer Info --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Organizer
                </h3>
                <div class="flex items-center gap-4">
                    <img src="{{ $event->organizer->avatar_url ?? '' }}" alt="{{ $event->organizer->name }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-100">
                    <div>
                        <p class="font-bold text-gray-900">{{ $event->organizer->name }}</p>
                        <p class="text-sm text-gray-500">Event Organizer</p>
                        <a href="{{ route('messages.index') }}" class="text-xs text-terracotta-500 hover:text-terracotta-600 font-medium mt-1 inline-block">Send Message</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Request Modal --}}
    <div x-data="{ showModal: false, packageId: 0, packageName: '', packagePrice: 0 }" x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @open-request.window="showModal = true; packageId = $event.detail.packageId; packageName = $event.detail.packageName; packagePrice = $event.detail.packagePrice;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="showModal = false">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            </div>

            <div class="relative bg-white rounded-2xl max-w-lg w-full mx-auto overflow-hidden shadow-xl transform transition-all sm:my-8">
                <form action="{{ route('sponsor.events.request', $event) }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" :value="packageId">

                    <div class="px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Request Sponsorship</h3>
                            <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="p-4 bg-terracotta-50 rounded-xl mb-4">
                            <p class="text-sm text-gray-500">Selected Package</p>
                            <p class="font-bold text-gray-900 text-lg" x-text="packageName"></p>
                            <p class="text-terracotta-500 font-bold">₹<span x-text="packagePrice.toLocaleString()"></span></p>
                        </div>

                        <div class="mb-4">
                            <label class="label">Your Message <span class="text-red-500">*</span></label>
                            <textarea name="message" class="input-field" rows="4" required placeholder="Explain why you want to sponsor this event and what value you bring..."></textarea>
                        </div>

                        <div class="mb-2">
                            <label class="label">Budget Offer (₹)</label>
                            <input type="number" name="budget_offer" class="input-field" min="0" placeholder="Optional: Your proposed sponsorship budget">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                        <button type="button" @click="showModal = false" class="btn-outline text-sm">Cancel</button>
                        <button type="submit" class="btn-primary text-sm">
                            <svg class="w-4 h-4 mr-1.5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRequestModal(packageId, packageName, packagePrice) {
            window.dispatchEvent(new CustomEvent('open-request', {
                detail: { packageId, packageName, packagePrice }
            }));
        }
    </script>
</x-app-layout>
