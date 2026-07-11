<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.meetings.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $meeting->title }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><dt class="text-xs text-gray-500">Type</dt><dd class="text-gray-900 capitalize">{{ $meeting->type }}</dd></div>
                <div><dt class="text-xs text-gray-500">Status</dt><dd class="text-gray-900"><span class="badge badge-{{ $meeting->status === 'completed' ? 'success' : ($meeting->status === 'cancelled' ? 'danger' : 'info') }} text-xs">{{ $meeting->status }}</span></dd></div>
                <div><dt class="text-xs text-gray-500">Start</dt><dd class="text-gray-900">{{ $meeting->start_time->format('d M Y H:i') }}</dd></div>
                <div><dt class="text-xs text-gray-500">End</dt><dd class="text-gray-900">{{ $meeting->end_time->format('d M Y H:i') }}</dd></div>
                @if($meeting->meeting_link)
                    <div class="md:col-span-2"><dt class="text-xs text-gray-500">Link</dt><dd class="text-gray-900"><a href="{{ $meeting->meeting_link }}" target="_blank" class="text-blue-600 hover:underline text-sm">{{ $meeting->meeting_link }}</a></dd></div>
                @endif
            </dl>
            @if($meeting->description)
                <div class="mt-4 pt-4 border-t border-gray-100"><dt class="text-xs text-gray-500 mb-1">Description</dt><dd class="text-gray-700 text-sm">{{ $meeting->description }}</dd></div>
            @endif
        </div>

        <div class="card p-6 mb-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Status</h3>
            <form method="POST" action="{{ route('partner.meetings.update-status', $meeting->id) }}" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <select name="status" class="rounded-lg border-gray-300 text-sm">
                        <option value="scheduled" {{ $meeting->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="confirmed" {{ $meeting->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $meeting->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $meeting->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Minutes</label>
                    <textarea name="minutes" rows="5" class="w-full rounded-lg border-gray-300 text-sm">{{ $meeting->minutes }}</textarea>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
