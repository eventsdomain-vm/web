<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Schedule Item</h2>
            <a href="{{ route('organizer.events.schedules.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Schedule</a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <form action="{{ route('organizer.events.schedules.store', $event) }}" method="POST" class="card p-6 md:p-8 space-y-6">
            @csrf

            <div class="input-group">
                <label class="label">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="input-field input-lg" required placeholder="e.g., Opening Ceremony">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="input-group">
                <label class="label">Description</label>
                <textarea name="description" class="input-field" rows="3" placeholder="Describe this session...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="input-group">
                    <label class="label">Start Time <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="input-field input-lg" required>
                    @error('start_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="input-group">
                    <label class="label">End Time <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="input-field input-lg" required>
                    @error('end_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="input-group">
                <label class="label">Speaker</label>
                <input type="text" name="speaker" value="{{ old('speaker') }}" class="input-field input-lg" placeholder="e.g., John Doe, CEO at TechCorp">
            </div>

            <div class="input-group">
                <label class="label">Venue / Room</label>
                <input type="text" name="venue" value="{{ old('venue') }}" class="input-field input-lg" placeholder="e.g., Main Hall, Room 101">
            </div>

            <div class="input-group">
                <label class="label">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', '0') }}" class="input-field input-lg" min="0">
                <p class="input-hint">Lower numbers appear first.</p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('organizer.events.schedules.index', $event) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Add Schedule Item</button>
            </div>
        </form>
    </div>
</x-app-layout>
