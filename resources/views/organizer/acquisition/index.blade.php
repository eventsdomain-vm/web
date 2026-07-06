<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Acquisition</h2></x-slot>
    <div class="container-page space-y-6">
        @if ($events->count())
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Your Events & Request Summary</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($events as $event)
                <div class="border rounded-lg p-3 text-sm">
                    <p class="font-medium truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-500">{{ $event->sponsorship_requests_count }} requests ({{ $event->pending_requests_count }} pending)</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Recent Requests</h3>
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="pb-2">Sponsor</th><th class="pb-2">Event</th><th class="pb-2">Package</th><th class="pb-2">Status</th><th class="pb-2">Date</th></tr></thead>
                <tbody>
                    @forelse ($recentRequests as $r)
                        <tr class="border-b border-gray-100">
                            <td class="py-2">{{ $r->sponsor?->company_name ?? 'ID:'.$r->sponsor_id }}</td>
                            <td class="py-2">{{ $r->event?->title ?? '-' }}</td>
                            <td class="py-2">{{ $r->package?->name ?? '-' }}</td>
                            <td class="py-2"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($r->status) }}</span></td>
                            <td class="py-2">{{ $r->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-center text-gray-400">No requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
