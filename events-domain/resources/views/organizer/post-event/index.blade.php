<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Post-Event Reports</h2></x-slot>
    <div class="container-page space-y-6">
        <div class="card p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-gray-600">
            Create post-event intelligence reports to track ROI, sponsor satisfaction, attendance, and deliverables.
        </div>

        @if ($events->count())
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Create Report for Completed Event</h3>
            <div class="flex flex-wrap gap-3">
                @foreach ($events as $event)
                    <a href="{{ route('organizer.post-event.create', ['event_id' => $event->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm hover:bg-indigo-100 transition">
                        {{ $event->title }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="text-left bg-gray-50 text-gray-600"><th class="p-3">Event</th><th class="p-3">Attendance</th><th class="p-3">ROI</th><th class="p-3">Satisfaction</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse ($reports as $r)
                        <tr class="border-t border-gray-100">
                            <td class="p-3 font-medium">{{ $r->event?->title ?? 'Event #'.$r->event_id }}</td>
                            <td class="p-3">{{ $r->total_attendance ?? '-' }}</td>
                            <td class="p-3">{{ $r->roi_percentage !== null ? $r->roi_percentage.'%' : '-' }}</td>
                            <td class="p-3">{{ $r->sponsor_satisfaction ?? '-' }}/5</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="p-3"><a href="{{ route('organizer.post-event.show', $r->id) }}" class="text-indigo-600 hover:underline text-xs">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No post-event reports yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $reports->links() }}
    </div>
</x-app-layout>
