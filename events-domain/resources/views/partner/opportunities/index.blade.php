<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Opportunities</h2>
            <p class="text-sm text-gray-500">{{ $events->total() }} event{{ $events->total() !== 1 ? 's' : '' }} available</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-5 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="input-group mb-0 min-w-[160px]">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-0 min-w-[200px] flex-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Search</label>
                <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" class="input-field">
            </div>
            <button type="submit" class="btn-primary">Search</button>
            @if(request()->anyFilled(['category', 'search']))
                <a href="{{ route('partner.opportunities') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
            @endif
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
                    <div class="absolute top-3 left-3">
                        <span class="badge-dark text-xs">{{ $event->category->name ?? 'General' }}</span>
                    </div>
                    <div class="absolute top-3 right-3 bg-blue-500/80 text-white text-xs px-2 py-0.5 rounded-full font-medium">Open for Bids</div>
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
                        </div>
                        <a href="#" @click.prevent="$dispatch('open-bid-modal', { eventId: {{ $event->id }}, eventTitle: '{{ addslashes($event->title) }}' })"
                           class="text-terracotta-500 font-semibold text-sm hover:text-terracotta-600 transition flex items-center gap-1">
                            Submit Bid
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-500">No opportunities available right now.</p>
                <p class="text-sm text-gray-400 mt-1">Check back later for new events needing partners.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>

    {{-- Bid Modal --}}
    <div x-data="{ open: false, eventId: null, eventTitle: '', serviceId: '', quoteAmount: '', quoteNote: '' }"
         @open-bid-modal.window="open = true; eventId = $event.detail.eventId; eventTitle = $event.detail.eventTitle"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 z-10"
             @click.outside="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Submit Bid</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mb-4" x-text="'Submitting a bid for: ' + eventTitle"></p>
            <form :action="'{{ route('partner.bids.store') }}'" method="POST">
                @csrf
                <input type="hidden" name="event_id" x-model="eventId">

                <div class="mb-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Service</label>
                    <select name="service_id" x-model="serviceId" required class="input-field w-full">
                        <option value="">Select a service...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->title }} ({{ $service->formatted_price }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Quote Amount (₹)</label>
                    <input type="number" name="quote_amount" x-model="quoteAmount" min="0" step="0.01" required class="input-field w-full" placeholder="0.00">
                </div>

                <div class="mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Notes (Optional)</label>
                    <textarea name="quote_note" x-model="quoteNote" rows="3" class="input-field w-full" placeholder="Describe your offer..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="open = false" class="btn-outline text-sm">Cancel</button>
                    <button type="submit" class="btn-primary text-sm">Submit Bid</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
