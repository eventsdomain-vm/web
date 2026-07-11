<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Schedule Item</h2>
            <a href="{{ route('organizer.events.schedules.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Schedule</a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <form action="{{ route('organizer.events.schedules.update', [$event, $schedule]) }}" method="POST" class="card p-6 md:p-8 space-y-6">
            @csrf @method('PUT')

            <div class="input-group">
                <label class="label">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $schedule->title) }}" class="input-field input-lg" required>
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="input-group">
                <label class="label">Description</label>
                <textarea name="description" class="input-field" rows="3">{{ old('description', $schedule->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="input-group">
                    <label class="label">Start Time <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" class="input-field input-lg" required>
                </div>
                <div class="input-group">
                    <label class="label">End Time <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" class="input-field input-lg" required>
                </div>
            </div>

            <div class="input-group">
                <label class="label">Speaker</label>
                <input type="text" name="speaker" value="{{ old('speaker', $schedule->speaker) }}" class="input-field input-lg">
            </div>

            <div class="input-group">
                <label class="label">Venue / Room</label>
                <input type="text" name="venue" value="{{ old('venue', $schedule->venue) }}" class="input-field input-lg">
            </div>

            <div class="input-group">
                <label class="label">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $schedule->sort_order ?? 0) }}" class="input-field input-lg" min="0">
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('organizer.events.schedules.index', $event) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Update Schedule Item</button>
            </div>
        </form>
    </div>
</x-app-layout>
