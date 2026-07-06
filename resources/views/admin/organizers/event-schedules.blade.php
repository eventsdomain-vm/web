<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Schedules &mdash; {{ $event->title }}</h2>
            <a href="{{ route('admin.events.show', $event) }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Add Schedule Item</h3>
                <form method="POST" action="{{ route('admin.events.schedules.store', $event) }}" class="grid grid-cols-2 gap-4">
                    @csrf
                    <div><label class="block text-sm font-medium mb-1">Title *</label><input type="text" name="title" required class="input-field w-full"></div>
                    <div><label class="block text-sm font-medium mb-1">Speaker</label><input type="text" name="speaker" class="input-field w-full"></div>
                    <div><label class="block text-sm font-medium mb-1">Start Time *</label><input type="time" name="start_time" required class="input-field w-full"></div>
                    <div><label class="block text-sm font-medium mb-1">End Time *</label><input type="time" name="end_time" required class="input-field w-full"></div>
                    <div><label class="block text-sm font-medium mb-1">Venue</label><input type="text" name="venue" class="input-field w-full"></div>
                    <div><label class="block text-sm font-medium mb-1">Sort Order</label><input type="number" name="sort_order" value="0" class="input-field w-full"></div>
                    <div class="col-span-2"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="input-field w-full"></textarea></div>
                    <div class="col-span-2"><button type="submit" class="btn-primary">Add Item</button></div>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Schedule Items ({{ $schedules->count() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($schedules as $schedule)
                        <div class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">{{ $schedule->title }}</p>
                                <p class="text-sm text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }} @if($schedule->speaker) &bull; {{ $schedule->speaker }} @endif</p>
                            </div>
                            <form method="POST" action="{{ route('admin.events.schedules.destroy', [$event, $schedule]) }}" onsubmit="return confirm('Delete this item?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                            </form>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-500">No schedule items.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
