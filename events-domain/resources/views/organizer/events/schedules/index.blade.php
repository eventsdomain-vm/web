<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Schedule: {{ $event->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('organizer.events.schedules.create', $event) }}" class="btn-primary text-sm">+ Add Item</a>
                <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Event</a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-6 md:p-8">
        @forelse($schedules as $schedule)
            <div class="flex items-start gap-4 py-4 border-b border-gray-100 last:border-0">
                <div class="flex-shrink-0 w-20 text-right">
                    <span class="text-sm font-bold text-terracotta-500">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                    <span class="text-xs text-gray-400 block">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-900">{{ $schedule->title }}</h4>
                    @if($schedule->description)
                        <p class="text-sm text-gray-500 mt-1">{{ $schedule->description }}</p>
                    @endif
                    <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-400">
                        @if($schedule->speaker)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                {{ $schedule->speaker }}
                            </span>
                        @endif
                        @if($schedule->venue)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                {{ $schedule->venue }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('organizer.events.schedules.edit', [$event, $schedule]) }}" class="text-terracotta-500 hover:text-terracotta-700 text-sm">Edit</a>
                    <form action="{{ route('organizer.events.schedules.destroy', [$event, $schedule]) }}" method="POST" onsubmit="return confirm('Delete this schedule item?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                <p class="text-gray-500">No schedule items yet.</p>
                <a href="{{ route('organizer.events.schedules.create', $event) }}" class="btn-primary text-sm mt-4 inline-block">Add Schedule Item</a>
            </div>
        @endforelse
    </div>
</x-app-layout>
