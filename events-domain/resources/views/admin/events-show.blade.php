<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Event Details') }}
            </h2>
            <a href="{{ route('admin.events') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Events
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Header --}}
            <div class="card p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                        @if($event->tagline)
                            <p class="text-gray-500 mt-1">{{ $event->tagline }}</p>
                        @endif
                        <div class="flex items-center gap-3 mt-3">
                            <span class="badge badge-{{ $event->status_color }}">{{ $event->status_label }}</span>
                            @if($event->category)
                                <span class="badge badge-info">{{ $event->category->name }}</span>
                            @endif
                            @if($event->is_featured)
                                <span class="badge badge-warning">Featured</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($event->status === 'pending')
                            <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                                    Approve
                                </button>
                            </form>
                            <button
                                x-data="{ open: false }"
                                @click="open = true"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                                Reject
                            </button>
                            {{-- Reject Modal --}}
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                <div @click.away="open = false" class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Event</h3>
                                    <form action="{{ route('admin.events.reject', $event) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection *</label>
                                            <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent"
                                                placeholder="Please provide a reason for rejecting this event..."></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3">
                                            <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                                                Reject Event
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Description --}}
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                        <div class="prose prose-sm max-w-none text-gray-600">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    {{-- Event Details --}}
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm text-gray-500">Start Date</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->start_date->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($event->end_date)
                            <div>
                                <dt class="text-sm text-gray-500">End Date</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->end_date->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm text-gray-500">Event Type</dt>
                                <dd class="text-sm font-medium text-gray-900 capitalize">{{ $event->event_type }}</dd>
                            </div>
                            @if($event->venue)
                            <div>
                                <dt class="text-sm text-gray-500">Venue</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->venue }}</dd>
                            </div>
                            @endif
                            @if($event->city)
                            <div>
                                <dt class="text-sm text-gray-500">Location</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->city }}, {{ $event->state }}, {{ $event->country }}</dd>
                            </div>
                            @endif
                            @if($event->expected_audience)
                            <div>
                                <dt class="text-sm text-gray-500">Expected Audience</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ number_format($event->expected_audience) }}</dd>
                            </div>
                            @endif
                            @if($event->budget_min || $event->budget_max)
                            <div>
                                <dt class="text-sm text-gray-500">Budget Range</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    @if($event->budget_min)₹{{ number_format($event->budget_min) }}@endif
                                    @if($event->budget_min && $event->budget_max) - @endif
                                    @if($event->budget_max)₹{{ number_format($event->budget_max) }}@endif
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Gallery --}}
                    @if($event->gallery->count())
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($event->gallery as $image)
                                <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? 'Gallery image' }}"
                                    class="w-full h-32 object-cover rounded-lg">
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Schedule --}}
                    @if($event->schedule->count())
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule</h3>
                        <div class="space-y-3">
                            @foreach($event->schedule as $item)
                                <div class="flex items-start gap-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm font-medium text-[#E35336]">
                                        {{ $item->start_time }} - {{ $item->end_time }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->title }}</div>
                                        @if($item->description)
                                            <div class="text-sm text-gray-500">{{ $item->description }}</div>
                                        @endif
                                        @if($item->speaker)
                                            <div class="text-sm text-gray-500">Speaker: {{ $item->speaker }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Organizer --}}
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Organizer</h3>
                        @if($event->organizer)
                            <div class="flex items-center gap-3">
                                <img src="{{ $event->organizer->avatar_url }}" alt="{{ $event->organizer->name }}"
                                    class="w-12 h-12 rounded-full object-cover">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $event->organizer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->organizer->email }}</div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No organizer assigned</p>
                        @endif
                    </div>

                    {{-- Packages --}}
                    @if($event->packages->count())
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sponsorship Packages</h3>
                        <div class="space-y-3">
                            @foreach($event->packages as $package)
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="font-medium text-gray-900">{{ $package->title }}</div>
                                    <div class="text-sm text-[#E35336] font-semibold">₹{{ number_format($package->price) }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $package->slots_filled }}/{{ $package->slots_available }} slots filled
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Rejection Reason --}}
                    @if($event->status === 'rejected' && $event->rejection_reason)
                    <div class="card p-6 border-l-4 border-red-500">
                        <h3 class="text-lg font-semibold text-red-700 mb-2">Rejection Reason</h3>
                        <p class="text-sm text-gray-600">{{ $event->rejection_reason }}</p>
                    </div>
                    @endif

                    {{-- Stats --}}
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Views</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ number_format($event->views_count) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Created</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Last Updated</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $event->updated_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
