<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saved Events</h2>
            <a href="{{ route('sponsor.events.index') }}" class="btn-primary text-sm">Browse Events</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($savedEvents->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($savedEvents as $saved)
                        <div class="card-hover group">
                            <div class="relative h-40 overflow-hidden">
                                @if($saved->event->cover_image_url)
                                    <img src="{{ $saved->event->cover_image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-terracotta-400 to-terracotta-700"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-3 left-3">
                                    <span class="badge-dark text-xs">{{ $saved->event->category->name ?? 'General' }}</span>
                                </div>
                                <form action="{{ route('sponsor.events.unsave', $saved->event) }}" method="POST" class="absolute top-3 right-3">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1">{{ $saved->event->title }}</h3>
                                <p class="text-sm text-gray-500 mb-1">{{ $saved->event->city }}, {{ $saved->event->state }}</p>
                                <p class="text-sm text-gray-400 mb-4">{{ $saved->event->start_date?->format('M d, Y') }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">{{ number_format($saved->event->expected_audience) }} attendees</span>
                                    <a href="{{ route('sponsor.events.show', $saved->event) }}" class="text-terracotta-500 font-semibold text-sm hover:underline">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $savedEvents->links() }}</div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                    <p class="text-gray-500 text-lg mb-2">No saved events yet</p>
                    <p class="text-gray-400 text-sm mb-6">Save events to your watchlist for quick access and comparison.</p>
                    <a href="{{ route('sponsor.events.index') }}" class="btn-primary">Browse Events</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
