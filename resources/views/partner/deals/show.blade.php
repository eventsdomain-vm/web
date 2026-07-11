<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.deals.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deal #{{ $deal->id }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><dt class="text-xs text-gray-500">Stage</dt><dd class="text-gray-900"><span class="badge badge-{{ $deal->stage === 'completed' ? 'success' : ($deal->stage === 'lost' ? 'danger' : 'info') }} text-xs">{{ $deal->stage }}</span></dd></div>
                <div><dt class="text-xs text-gray-500">Value</dt><dd class="text-gray-900">{{ $deal->deal_value ? '₹'.number_format($deal->deal_value) : '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Commission Rate</dt><dd class="text-gray-900">{{ $deal->commission_rate ? $deal->commission_rate.'%' : '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Expected Close</dt><dd class="text-gray-900">{{ $deal->expected_close_date?->format('d M Y') ?? '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Closed At</dt><dd class="text-gray-900">{{ $deal->closed_at?->format('d M Y H:i') ?? '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Lead Source</dt><dd class="text-gray-900">{{ $deal->lead?->source ?? 'Direct' }}</dd></div>
            </dl>
            @if($deal->notes)
                <div class="mt-4 pt-4 border-t border-gray-100"><dt class="text-xs text-gray-500 mb-1">Notes</dt><dd class="text-gray-700 text-sm">{{ $deal->notes }}</dd></div>
            @endif
        </div>

        <div class="card p-6 mb-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Commissions</h3>
            @forelse($deal->commissions as $c)
                <div class="flex justify-between py-2 border-b border-gray-50 text-sm">
                    <span class="text-gray-600">₹{{ number_format($c->amount) }} @ {{ $c->rate }}%</span>
                    <span class="badge badge-{{ $c->status === 'paid' ? 'success' : 'info' }} text-xs">{{ $c->status }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No commissions recorded.</p>
            @endforelse
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Stage</h3>
            <form method="POST" action="{{ route('partner.deals.update-stage', $deal->id) }}" class="flex items-end gap-3">
                @csrf
                <div>
                    <select name="stage" class="rounded-lg border-gray-300 text-sm">
                        <option value="qualification" {{ $deal->stage === 'qualification' ? 'selected' : '' }}>Qualification</option>
                        <option value="proposal" {{ $deal->stage === 'proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="negotiation" {{ $deal->stage === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                        <option value="contract" {{ $deal->stage === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="payment" {{ $deal->stage === 'payment' ? 'selected' : '' }}>Payment</option>
                        <option value="active" {{ $deal->stage === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $deal->stage === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="lost" {{ $deal->stage === 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
