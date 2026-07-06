<x-app-layout>
    <x-slot name="title">Overview - EventsDomain</x-slot>

    <div class="space-y-6">
        {{-- Welcome --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-500 mt-1">{{ now()->format('l, F j, Y') }}</p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Events</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalEvents) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#F26C4F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Live Events</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($liveEvents) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Views</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalViews) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Unread Enquiries</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($unreadEnquiries) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit New Event --}}
        @if(auth()->user()->hasRole('organizer'))
            <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center gap-2 bg-[#F26C4F] text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-[#E05A3D] transition shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Submit New Event
            </a>
        @endif

        {{-- Recent Events + Recent Enquiries --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Events --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Recent Events</h2>
                    <a href="{{ route('organizer.events.index') }}" class="text-sm text-[#F26C4F] hover:underline">View All</a>
                </div>
                @if($recentEvents->count())
                    <div class="divide-y divide-gray-100">
                        @foreach($recentEvents as $event)
                            <div class="px-5 py-3.5 flex items-center justify-between">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $event->start_date->format('M d, Y') }}</p>
                                </div>
                                <span class="ml-3 text-xs font-medium px-2.5 py-1 rounded-full
                                    @switch($event->status)
                                        @case('live') bg-emerald-50 text-emerald-600 @break
                                        @case('draft') bg-gray-100 text-gray-500 @break
                                        @case('completed') bg-blue-50 text-blue-600 @break
                                        @default bg-gray-100 text-gray-500
                                    @endswitch
                                ">{{ ucfirst($event->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-5 py-8 text-center text-gray-400 text-sm">No events yet.</div>
                @endif
            </div>

            {{-- Recent Enquiries --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Recent Enquiries</h2>
                    <a href="{{ route('enquiries') }}" class="text-sm text-[#F26C4F] hover:underline">View All</a>
                </div>
                <div class="px-5 py-8 text-center text-gray-400 text-sm">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    No enquiries yet. When sponsors reach out, they'll appear here.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
