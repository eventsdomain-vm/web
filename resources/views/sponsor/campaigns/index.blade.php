<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Campaigns</h2>
            <span class="text-sm text-gray-500">{{ method_exists($campaigns, 'total') ? $campaigns->total() : $campaigns->count() }} total</span>
        </div>
    </x-slot>
    <div class="container-page py-6">
        @forelse($campaigns as $campaign)
            <div class="card mb-4 p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('sponsor.campaigns.show', $campaign) }}" class="font-semibold text-gray-900 hover:text-terracotta-500">{{ $campaign->event?->title ?? 'Untitled Campaign' }}</a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>Budget: ₹{{ number_format($campaign->budget) }}</span>
                            <span>Spent: ₹{{ number_format($campaign->spent) }}</span>
                            <span>Reach: {{ number_format($campaign->actual_reach ?? 0) }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 rounded-full h-2 max-w-[200px]">
                                <div class="bg-terracotta-500 h-2 rounded-full" style="width: {{ $campaign->progress }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $campaign->progress }}%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'paused' ? 'warning' : 'gray') }}">{{ ucfirst($campaign->status) }}</span>
                        <a href="{{ route('sponsor.campaigns.show', $campaign) }}" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">
                <p class="mb-2">No campaigns yet.</p>
                <a href="{{ route('sponsor.events.index') }}" class="text-terracotta-500 hover:underline">Browse events to start a sponsorship</a>
            </div>
        @endforelse
        @if(method_exists($campaigns, 'links')){{ $campaigns->links() }}@endif
    </div>
</x-app-layout>
