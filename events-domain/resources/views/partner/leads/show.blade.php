<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.leads.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lead #{{ $lead->id }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><dt class="text-xs text-gray-500">Source</dt><dd class="text-gray-900 capitalize">{{ $lead->source }}</dd></div>
                <div><dt class="text-xs text-gray-500">Stage</dt><dd class="text-gray-900"><span class="badge badge-{{ $lead->stage === 'won' ? 'success' : ($lead->stage === 'lost' ? 'danger' : 'info') }} text-xs">{{ $lead->stage }}</span></dd></div>
                <div><dt class="text-xs text-gray-500">Priority</dt><dd class="text-gray-900">{{ ucfirst($lead->priority) }}</dd></div>
                <div><dt class="text-xs text-gray-500">Value</dt><dd class="text-gray-900">{{ $lead->value ? '₹'.number_format($lead->value) : '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Probability</dt><dd class="text-gray-900">{{ $lead->probability ? $lead->probability.'%' : '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Expected Close</dt><dd class="text-gray-900">{{ $lead->expected_close_date?->format('d M Y') ?? '—' }}</dd></div>
            </dl>
            @if($lead->notes)
                <div class="mt-4 pt-4 border-t border-gray-100"><dt class="text-xs text-gray-500 mb-1">Notes</dt><dd class="text-gray-700 text-sm">{{ $lead->notes }}</dd></div>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Stage</h3>
            <form method="POST" action="{{ route('partner.leads.update-stage', $lead->id) }}" class="flex items-end gap-3">
                @csrf
                <div>
                    <select name="stage" class="rounded-lg border-gray-300 text-sm">
                        <option value="new" {{ $lead->stage === 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ $lead->stage === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ $lead->stage === 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="proposal" {{ $lead->stage === 'proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="negotiation" {{ $lead->stage === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                        <option value="won" {{ $lead->stage === 'won' ? 'selected' : '' }}>Won</option>
                        <option value="lost" {{ $lead->stage === 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
                <div>
                    <input type="text" name="lost_reason" class="rounded-lg border-gray-300 text-sm" placeholder="Lost reason (if lost)">
                </div>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
