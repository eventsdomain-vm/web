<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Negotiation Center</h2>
            @if($openCount > 0)
                <span class="badge badge-warning text-sm">{{ $openCount }} open</span>
            @endif
        </div>
    </x-slot>

    <div class="space-y-4">
        @forelse($negotiations as $negotiation)
            <div class="card hover:shadow-md transition">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-gray-900">{{ $negotiation->request?->event?->title ?? 'Event N/A' }}</h3>
                                <span class="badge badge-{{ $negotiation->status === 'open' ? 'warning' : ($negotiation->status === 'accepted' ? 'success' : 'danger') }} text-xs capitalize">{{ $negotiation->status }}</span>
                            </div>
                            <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                                <span>Initiated by {{ $negotiation->initiator?->name ?? 'System' }}</span>
                                @if($negotiation->current_offer)
                                    <span class="font-medium text-gray-700">₹{{ number_format($negotiation->current_offer) }}</span>
                                @endif
                                <span>{{ $negotiation->rounds->count() }} round(s)</span>
                                @if($negotiation->expires_at)
                                    <span>Expires {{ $negotiation->expires_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('sponsor.negotiations.show', $negotiation) }}" class="btn-outline text-sm px-3 py-1.5 ml-3">View Negotiation</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <p class="text-gray-500">No negotiations yet.</p>
                <p class="text-sm text-gray-400 mt-1">Negotiations appear here once an organizer responds to your sponsorship request.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
