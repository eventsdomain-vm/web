<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Lead Details</h2><a href="{{ route('admin.partner-leads.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">{{ $lead->sponsor->name ?? 'N/A' }}</h1><p class="text-gray-600">Partner: {{ $lead->partner->name ?? 'N/A' }}</p></div><div class="text-right"><span class="badge badge-{{ $lead->stage === 'won' ? 'success' : ($lead->stage === 'lost' ? 'danger' : 'info') }} text-lg">{{ ucfirst($lead->stage) }}</span><p class="text-sm mt-1">{{ $lead->priority }} priority</p></div></div></div>
        <div class="grid grid-cols-3 gap-6"><div class="card p-6"><h3 class="font-semibold">Value</h3><p class="text-2xl font-bold">&#8377;{{ number_format($lead->value ?? 0) }}</p></div><div class="card p-6"><h3 class="font-semibold">Probability</h3><p class="text-2xl font-bold">{{ $lead->probability ?? 'N/A' }}%</p></div><div class="card p-6"><h3 class="font-semibold">Source</h3><p class="text-lg">{{ ucfirst($lead->source ?? 'N/A') }}</p></div></div>
        @if($lead->notes)<div class="card p-6"><h3 class="font-semibold mb-2">Notes</h3><p class="whitespace-pre-wrap">{{ $lead->notes }}</p></div>@endif
        @if($lead->expected_close_date)<div class="card p-6"><h3 class="font-semibold">Expected Close</h3><p>{{ $lead->expected_close_date->format('M d, Y') }}</p></div>@endif
    </div>
</x-app-layout>
