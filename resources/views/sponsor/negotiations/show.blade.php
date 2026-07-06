<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('sponsor.negotiations.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Negotiation: {{ $negotiation->request?->event?->title ?? 'Event N/A' }}</h2>
            </div>
            @if($negotiation->isOpen())
                <div class="flex gap-2">
                    <form action="{{ route('sponsor.negotiations.accept', $negotiation) }}" method="POST" onsubmit="return confirm('Accept this negotiation?')">
                        @csrf
                        <button type="submit" class="btn-primary text-sm px-3 py-1.5">Accept</button>
                    </form>
                    <form action="{{ route('sponsor.negotiations.decline', $negotiation) }}" method="POST" onsubmit="return confirm('Decline this negotiation?')">
                        @csrf
                        <button type="submit" class="btn-outline text-sm px-3 py-1.5 text-red-500 border-red-200">Decline</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            @forelse($negotiation->rounds as $round)
                <div class="card">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-sm text-gray-900">{{ $round->user?->name ?? 'Unknown' }}</span>
                            <span class="text-xs text-gray-400">{{ $round->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $round->message }}</p>
                        @if($round->offer)
                            <p class="text-sm font-semibold text-terracotta-500 mt-2">Offer: ₹{{ number_format($round->offer) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card p-8 text-center text-gray-500 text-sm">No rounds yet. Start the negotiation by sending a message.</div>
            @endforelse

            @if($negotiation->isOpen())
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Add Round</h3>
                    </div>
                    <form action="{{ route('sponsor.negotiations.rounds.store', $negotiation) }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="3" class="w-full rounded-lg border-gray-200 text-sm" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Offer Amount (optional)</label>
                                <input type="number" name="offer" step="0.01" min="0" class="w-full rounded-lg border-gray-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Terms (JSON, optional)</label>
                                <input type="text" name="terms" placeholder='{"duration":"12 months"}' class="w-full rounded-lg border-gray-200 text-sm font-mono">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary text-sm px-4 py-2">Submit Round</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="card h-fit">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Details</h3>
            </div>
            <div class="p-6 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-medium capitalize">{{ $negotiation->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Current Offer</span>
                    <span class="font-medium">₹{{ number_format($negotiation->current_offer ?? 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Rounds</span>
                    <span class="font-medium">{{ $negotiation->rounds->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Currency</span>
                    <span class="font-medium">{{ strtoupper($negotiation->currency ?? 'INR') }}</span>
                </div>
                @if($negotiation->expires_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Expires</span>
                        <span class="font-medium {{ $negotiation->expires_at->isPast() ? 'text-red-500' : '' }}">{{ $negotiation->expires_at->format('M d, Y') }}</span>
                    </div>
                @endif
                @if($negotiation->accepted_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Accepted</span>
                        <span class="font-medium text-green-600">{{ $negotiation->accepted_at->format('M d, Y') }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Initiated By</span>
                    <span class="font-medium">{{ $negotiation->initiator?->name ?? 'System' }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
