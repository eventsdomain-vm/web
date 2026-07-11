<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Deal Details</h2><a href="{{ route('admin.partner-deals.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">&#8377;{{ number_format($deal->deal_value ?? 0) }}</h1><p class="text-gray-600">Partner: {{ $deal->partner->name ?? 'N/A' }}<br>Sponsor: {{ $deal->sponsor->name ?? 'N/A' }}<br>Event: {{ $deal->event->title ?? 'N/A' }}</p></div><span class="badge badge-{{ $deal->stage === 'completed' ? 'success' : ($deal->stage === 'lost' ? 'danger' : 'info') }} text-lg">{{ ucfirst($deal->stage) }}</span></div></div>
        <div class="grid grid-cols-3 gap-6"><div class="card p-6"><h3 class="font-semibold">Deal Value</h3><p class="text-2xl font-bold">&#8377;{{ number_format($deal->deal_value ?? 0) }}</p></div><div class="card p-6"><h3 class="font-semibold">Commission Rate</h3><p class="text-2xl font-bold">{{ $deal->commission_rate ?? 'N/A' }}%</p></div><div class="card p-6"><h3 class="font-semibold">Close Date</h3><p class="text-lg">{{ $deal->expected_close_date?->format('M d, Y') ?? 'N/A' }}</p></div></div>
        @if($deal->notes)<div class="card p-6"><h3 class="font-semibold mb-2">Notes</h3><p class="whitespace-pre-wrap">{{ $deal->notes }}</p></div>@endif
    </div>
</x-app-layout>
