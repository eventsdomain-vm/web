<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->title }}</h2>
            <div class="flex items-center gap-3" x-data="{ showShareModal: false }">
                @if(auth()->user()->hasRole('organizer'))
                    <button @click="showShareModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition hover:opacity-90" style="background-color: #F26C4F;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                        Share on Social
                    </button>
                @endif
                <a href="{{ route('organizer.events.edit', $event) }}" class="btn-outline text-sm">Edit Event</a>
                <a href="{{ route('organizer.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back</a>
            </div>
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
                        @if($event->is_featured)
                            <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs px-2.5 py-0.5 rounded-full">Featured</span>
                        @endif
                        @if($event->sponsorship_type)
                            <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs px-2.5 py-0.5 rounded-full">{{ ucfirst($event->sponsorship_type) }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl md:text-4xl font-bold text-white mb-2">{{ $event->title }}</h1>
                            @if($event->tagline)
                                <p class="text-white/60 text-lg">{{ $event->tagline }}</p>
                            @endif
                        </div>
                        <span class="badge-{{ $event->status_color }}">{{ $event->status_label }}</span>
                    </div>
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
                    @if($event->website_url)
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Website</p>
                            <a href="{{ $event->website_url }}" target="_blank" class="font-semibold text-terracotta-500 hover:underline">{{ $event->website_url }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sponsorship Packages --}}
            <div class="card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="heading-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Sponsorship Packages
                    </h2>
                    <a href="#" class="text-sm text-terracotta-500 font-semibold hover:text-terracotta-600 transition">Add Package</a>
                </div>
                @forelse($event->packages as $package)
                    <div class="border border-gray-200 rounded-2xl p-6 mb-4 last:mb-0 hover:border-terracotta-200 transition hover:shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $package->title }}</h3>
                                @if($package->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-terracotta-500">₹{{ number_format($package->price) }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">One-time fee</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                Slots: {{ $package->slots_filled }}/{{ $package->slots_available }}
                            </span>
                            @if($package->benefitRecords->count())
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $package->benefitRecords->count() }} benefits included</span>
                            @endif
                        </div>
                        @if($package->benefitRecords->count())
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Package Benefits:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($package->benefitRecords as $benefit)
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                            {{ $benefit->benefit_text }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-gray-500">No packages created yet.</p>
                        <p class="text-sm text-gray-400 mt-1">Sponsorship packages help sponsors understand the available opportunities.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Statistics --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Statistics
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Total Views</span>
                        <span class="font-bold text-gray-900">{{ number_format($event->views_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Sponsorship Requests</span>
                        <span class="font-bold text-gray-900">{{ $event->sponsorshipRequests->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500">Gallery Images</span>
                        <span class="font-bold text-gray-900">{{ $event->gallery->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Sponsorship Requests --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Sponsorship Requests
                </h3>
                @forelse($event->sponsorshipRequests as $request)
                    <div class="border-b border-gray-100 last:border-0 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-medium text-gray-900">{{ $request->sponsor->name }}</span>
                            <span class="badge-{{ $request->status_color }} text-xs">{{ $request->status_label }}</span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $request->package->title ?? 'N/A' }}</p>
                        @if($request->budget_offer)
                            <p class="text-sm text-terracotta-500 font-medium mt-1">Offered: ₹{{ number_format($request->budget_offer) }}</p>
                        @endif
                        @if($request->message)
                            <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $request->message }}</p>
                        @endif
                        @if($request->status === 'pending')
                            <div class="flex items-center gap-2 mt-2">
                                <form action="{{ route('organizer.requests.accept', [$event, $request]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition">Accept</button>
                                </form>
                                <form action="{{ route('organizer.requests.reject', [$event, $request]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">Reject</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        <p class="text-gray-500 text-sm">No requests yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Partner Bids --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    Partner Bids
                </h3>
                @forelse($event->partnerBids as $bid)
                    <div class="border-b border-gray-100 last:border-0 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-medium text-gray-900">{{ $bid->partner->name }}</span>
                            <span class="badge-{{ $bid->status_color }} text-xs">{{ $bid->status_label }}</span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $bid->service->title ?? 'N/A' }}</p>
                        @if($bid->quote_amount)
                            <p class="text-sm text-terracotta-500 font-medium mt-1">Quote: ₹{{ number_format($bid->quote_amount) }}</p>
                        @endif
                        @if($bid->quote_note)
                            <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $bid->quote_note }}</p>
                        @endif
                        @if($bid->status === 'pending')
                            <div class="flex items-center gap-2 mt-2">
                                <form action="{{ route('organizer.bids.accept', [$event, $bid]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition">Accept</button>
                                </form>
                                <form action="{{ route('organizer.bids.reject', [$event, $bid]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">Reject</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <p class="text-gray-500 text-sm">No bids yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Sponsor Proposals --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Sponsor Proposals ({{ $event->sponsorProposals->count() }})
                </h3>
                @forelse($event->sponsorProposals as $proposal)
                    <div class="border-b border-gray-100 last:border-0 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <span class="font-medium text-gray-900">{{ $proposal->sponsor->name }}</span>
                                <p class="text-sm text-gray-500">{{ $proposal->package->title ?? 'N/A' }} • ₹{{ number_format($proposal->budget_offer ?? $proposal->package->price ?? 0) }}</p>
                            </div>
                            <span class="badge badge-{{ $proposal->status_color }} text-xs">{{ $proposal->status_label }}</span>
                        </div>
                        @if($proposal->message)
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($proposal->message, 100) }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-3 flex-wrap">
                            @if($proposal->status === 'submitted')
                                <form action="{{ route('organizer.proposals.shortlist', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100">Shortlist</button>
                                </form>
                                <form action="{{ route('organizer.proposals.negotiate', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="organizer_note" value="">
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-yellow-50 text-yellow-600 hover:bg-yellow-100">Negotiate</button>
                                </form>
                                <form action="{{ route('organizer.proposals.accept', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100">Accept</button>
                                </form>
                                <button type="button" class="text-xs px-3 py-1 rounded-full bg-red-50 text-red-600 hover:bg-red-100" onclick="confirmReject('{{ $proposal->id }}', '{{ $event->id }}')">Reject</button>
                            @elseif($proposal->status === 'viewed' || $proposal->status === 'shortlisted')
                                <form action="{{ route('organizer.proposals.negotiate', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="organizer_note" value="">
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-yellow-50 text-yellow-600 hover:bg-yellow-100">Start Negotiation</button>
                                </form>
                                <form action="{{ route('organizer.proposals.accept', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100">Accept</button>
                                </form>
                            @elseif($proposal->status === 'negotiating')
                                <button type="button" class="text-xs px-3 py-1 rounded-full bg-purple-50 text-purple-600 hover:bg-purple-100" onclick="openCounterModal('{{ $proposal->id }}', '{{ $event->id }}')">Send Counter</button>
                                <form action="{{ route('organizer.proposals.accept', [$event, $proposal]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100">Accept</button>
                                </form>
                            @elseif($proposal->status === 'counter_offer')
                                <p class="text-xs text-gray-500">Waiting for sponsor response to counter offer</p>
                            @elseif($proposal->status === 'agreed')
                                <p class="text-xs text-emerald-600 font-medium">✓ Accepted - Ready for contract</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <p class="text-gray-500 text-sm">No proposals yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Management --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Management</h3>
                <div class="space-y-2">
                    <a href="{{ route('organizer.events.schedules.index', $event) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-terracotta-600 transition">Schedule</p>
                            <p class="text-xs text-gray-500">{{ $event->schedule->count() }} items</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <a href="{{ route('organizer.events.packages.index', $event) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-terracotta-600 transition">Packages</p>
                            <p class="text-xs text-gray-500">{{ $event->packages->count() }} packages</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <a href="{{ route('organizer.events.gallery.index', $event) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-terracotta-600 transition">Gallery</p>
                            <p class="text-xs text-gray-500">{{ $event->gallery->count() }} images</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <a href="{{ route('organizer.events.team.index', $event) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                        <div class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-terracotta-600 transition">Team</p>
                            <p class="text-xs text-gray-500">{{ $event->team->count() }} members</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn-outline w-full block text-center text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        View Public Page
                    </a>
                    <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger w-full text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Delete Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Proposal Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="font-semibold text-lg mb-4">Reject Proposal</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Rejection Note (Optional)</label>
                    <textarea name="rejection_note" class="w-full border-gray-300 rounded-md" rows="3" placeholder="Provide feedback to the sponsor..."></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="btn-outline">Cancel</button>
                    <button type="submit" class="btn-danger">Reject Proposal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Counter Offer Modal --}}
    <div id="counterModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="font-semibold text-lg mb-4">Send Counter Offer</h3>
            <form id="counterForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Counter Amount (₹)</label>
                    <input type="number" name="counter_amount" class="w-full border-gray-300 rounded-md" placeholder="0.00" min="0" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Message (Optional)</label>
                    <textarea name="counter_message" class="w-full border-gray-300 rounded-md" rows="3" placeholder="Add any notes for the sponsor..."></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('counterModal').classList.add('hidden')" class="btn-outline">Cancel</button>
                    <button type="submit" class="btn-primary">Send Counter Offer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmReject(proposalId, eventId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `{{ route('organizer.proposals.reject', ['event' => ':event', 'proposal' => ':proposal']) }}`
                .replace(':event', eventId)
                .replace(':proposal', proposalId);
            modal.classList.remove('hidden');
        }

        function openCounterModal(proposalId, eventId) {
            const modal = document.getElementById('counterModal');
            const form = document.getElementById('counterForm');
            form.action = `{{ route('organizer.proposals.counter', ['event' => ':event', 'proposal' => ':proposal']) }}`
                .replace(':event', eventId)
                .replace(':proposal', proposalId);
            modal.classList.remove('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const rejectModal = document.getElementById('rejectModal');
            const counterModal = document.getElementById('counterModal');
            
            if (event.target === rejectModal) {
                rejectModal.classList.add('hidden');
            }
            if (event.target === counterModal) {
                counterModal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
