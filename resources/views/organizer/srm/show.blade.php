<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Relationship: {{ $relationship->sponsor?->company_name ?? 'Unknown' }}</h2>
            <a href="{{ route('organizer.srm.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back</a>
        </div>
    </x-slot>
    <div class="container-page space-y-6">
        <div class="card p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div><span class="text-xs text-gray-500">Health Score</span><p class="text-2xl font-bold {{ $relationship->health_score >= 4 ? 'text-green-600' : ($relationship->health_score >= 3 ? 'text-yellow-600' : 'text-red-600') }}">{{ $relationship->health_score ?? 'N/A' }}</p></div>
                <div><span class="text-xs text-gray-500">Status</span><p class="text-sm font-semibold">{{ ucfirst($relationship->status ?? 'active') }}</p></div>
                <div><span class="text-xs text-gray-500">Last Engagement</span><p class="text-sm">{{ $relationship->last_engagement_at?->diffForHumans() ?? 'Never' }}</p></div>
            </div>
            <form method="POST" action="{{ route('organizer.srm.update-health', $relationship->id) }}" class="flex flex-wrap gap-3 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Update Health Score</label>
                    <input type="number" name="health_score" min="0" max="5" value="{{ $relationship->health_score }}" class="w-24 rounded-lg border-gray-300 text-sm">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                    <input type="text" name="notes" value="{{ $relationship->notes }}" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Add notes...">
                </div>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Contracts</h3>
            @if ($contracts->count())
                <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 border-b"><th class="pb-2">Amount</th><th class="pb-2">Status</th><th class="pb-2">Signed</th></tr></thead><tbody>
                    @foreach ($contracts as $c)
                        <tr class="border-b border-gray-100"><td class="py-2">₹{{ number_format($c->amount, 2) }}</td><td>{{ ucfirst($c->status) }}</td><td>{{ $c->signed_at?->format('M d, Y') ?? '-' }}</td></tr>
                    @endforeach
                </tbody></table>
            @else
                <p class="text-sm text-gray-400">No contracts.</p>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Renewals</h3>
            @if ($renewals->count())
                <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 border-b"><th class="pb-2">Value</th><th class="pb-2">Probability</th><th class="pb-2">Status</th></tr></thead><tbody>
                    @foreach ($renewals as $r)
                        <tr class="border-b border-gray-100"><td class="py-2">₹{{ number_format($r->proposed_value, 2) }}</td><td>{{ $r->probability }}%</td><td>{{ ucfirst($r->status) }}</td></tr>
                    @endforeach
                </tbody></table>
            @else
                <p class="text-sm text-gray-400">No renewals.</p>
            @endif
        </div>
    </div>
</x-app-layout>
