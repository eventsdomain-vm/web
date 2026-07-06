<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.deals.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Deal</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <form method="POST" action="{{ route('partner.deals.store') }}" class="card p-6 max-w-2xl">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Lead (optional)</label>
                    <select name="lead_id" class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="">— None —</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}">Lead #{{ $lead->id }} ({{ $lead->source }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stage</label>
                    <select name="stage" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="qualification">Qualification</option>
                        <option value="proposal">Proposal</option>
                        <option value="negotiation">Negotiation</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deal Value (₹)</label>
                    <input type="number" name="deal_value" step="0.01" min="0" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Commission Rate (%)</label>
                    <input type="number" name="commission_rate" step="0.01" min="0" max="100" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expected Close Date</label>
                    <input type="date" name="expected_close_date" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-sm">Create Deal</button>
            </div>
        </form>
    </div>
</x-app-layout>
