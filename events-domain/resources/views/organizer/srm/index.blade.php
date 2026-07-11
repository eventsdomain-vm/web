<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Relationships</h2></x-slot>
    <div class="container-page">
        <div class="card p-4 mb-4 text-sm text-gray-600 bg-blue-50 border border-blue-200 rounded-lg">
            Track and manage sponsor health scores, engagement, and retention.
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($relationships as $rel)
                <a href="{{ route('organizer.srm.show', $rel->id) }}" class="card p-4 block hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-900">{{ $rel->sponsor?->company_name ?? 'Unknown' }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $rel->health_score >= 4 ? 'bg-green-100 text-green-800' : ($rel->health_score >= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $rel->health_score ?? 'N/A' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">Status: <span class="font-medium">{{ ucfirst($rel->status ?? 'active') }}</span></p>
                    @if ($rel->last_engagement_at)
                        <p class="text-xs text-gray-500">Last engagement: {{ $rel->last_engagement_at->diffForHumans() }}</p>
                    @endif
                </a>
            @empty
                <div class="md:col-span-3 text-center py-12 text-gray-400"><p>No sponsor relationships yet.</p></div>
            @endforelse
        </div>
        {{ $relationships->links() }}
    </div>
</x-app-layout>
