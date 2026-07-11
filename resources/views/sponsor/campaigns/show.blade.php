<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('sponsor.campaigns.index') }}" class="text-sm text-terracotta-500 hover:underline">&larr; Back to Campaigns</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">{{ $campaign->event?->title ?? 'Campaign' }}</h2>
            </div>
            <span class="badge badge-{{ $campaign->status === 'active' ? 'success' : 'gray' }} text-sm">{{ ucfirst($campaign->status) }}</span>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stat-card"><p class="text-sm text-gray-500">Budget</p><p class="text-2xl font-bold">₹{{ number_format($campaign->budget) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Spent</p><p class="text-2xl font-bold">₹{{ number_format($campaign->spent) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Reach</p><p class="text-2xl font-bold">{{ number_format($campaign->actual_reach ?? 0) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">ROI</p><p class="text-2xl font-bold {{ ($campaign->roi ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $campaign->roi ?? 'N/A' }}{{ $campaign->roi ? '%' : '' }}</p></div>
        </div>
        <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Deliverables</h3>
            <div class="divide-y divide-gray-100">
                @forelse($campaign->deliverables as $deliverable)
                    <div class="py-3 flex items-center justify-between">
                        <div><p class="font-medium">{{ $deliverable->title }}</p><p class="text-sm text-gray-500">{{ $deliverable->type ?? 'General' }}</p></div>
                        <span class="badge badge-{{ $deliverable->status === 'completed' ? 'success' : ($deliverable->status === 'in_progress' ? 'warning' : 'gray') }}">{{ ucfirst($deliverable->status) }}</span>
                    </div>
                @empty
                    <p class="py-4 text-center text-gray-500 text-sm">No deliverables yet.</p>
                @endforelse
            </div>
        </div>
        <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Milestones</h3>
            <div class="space-y-2">
                @forelse($campaign->milestones as $milestone)
                    <div class="flex items-center gap-3 py-2">
                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $milestone->completed_at ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                            @if($milestone->completed_at)<svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>@endif
                        </div>
                        <span class="{{ $milestone->completed_at ? 'line-through text-gray-400' : 'text-gray-700' }}">{{ $milestone->title }}</span>
                        @if($milestone->due_date)<span class="text-xs text-gray-400 ml-auto">{{ $milestone->due_date->format('M d') }}</span>@endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm py-4">No milestones yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
