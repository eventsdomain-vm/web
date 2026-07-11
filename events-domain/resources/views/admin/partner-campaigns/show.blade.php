<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Campaign Details</h2><a href="{{ route('admin.partner-campaigns.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">{{ $campaign->name ?? 'N/A' }}</h1><p class="text-gray-600">Partner: {{ $campaign->partner->name ?? 'N/A' }} &bull; Sponsor: {{ $campaign->sponsor->name ?? 'N/A' }} &bull; Event: {{ $campaign->event->title ?? 'N/A' }}</p></div><span class="badge badge-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'completed' ? 'info' : 'warning') }} text-lg">{{ ucfirst($campaign->status) }}</span></div></div>
        @if($campaign->deal)<div class="card p-6"><h3 class="font-semibold">Deal</h3><p class="text-gray-700">{{ $campaign->deal->deal_value ?? 'N/A' }}</p></div>@endif
    </div>
</x-app-layout>
