<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Renewal Pipeline</h2>
            <button onclick="document.getElementById('create-renewal').classList.toggle('hidden')" class="btn-primary px-4 py-2 rounded-lg text-sm">+ New Renewal</button>
        </div>
    </x-slot>
    <div class="container-page space-y-6">
        <div id="create-renewal" class="hidden card p-6 max-w-2xl">
            <form method="POST" action="{{ route('organizer.renewals.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Sponsor ID</label>
                        <input type="number" name="sponsor_id" class="w-full rounded-lg border-gray-300 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Contract ID (optional)</label>
                        <input type="number" name="contract_id" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 text-sm" required>
                            <option value="negotiation">Negotiation</option>
                            <option value="proposal_sent">Proposal Sent</option>
                            <option value="approved">Approved</option>
                            <option value="renewed">Renewed</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Proposed Value (₹)</label>
                        <input type="number" name="proposed_value" min="0" step="0.01" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Probability (%)</label>
                        <input type="number" name="probability" min="0" max="100" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Expected Close Date</label>
                        <input type="date" name="expected_close_date" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-4 flex justify-end"><button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Create Renewal</button></div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="text-left bg-gray-50 text-gray-600"><th class="p-3">Sponsor</th><th class="p-3">Value</th><th class="p-3">Probability</th><th class="p-3">Status</th><th class="p-3">Close Date</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse ($renewals as $r)
                        <tr class="border-t border-gray-100">
                            <td class="p-3 font-medium">{{ $r->sponsor?->company_name ?? 'ID:'.$r->sponsor_id }}</td>
                            <td class="p-3">₹{{ number_format($r->proposed_value ?? 0, 2) }}</td>
                            <td class="p-3">{{ $r->probability }}%</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ match($r->status) { 'renewed' => 'bg-green-100 text-green-800', 'lost' => 'bg-red-100 text-red-800', 'approved' => 'bg-blue-100 text-blue-800', default => 'bg-yellow-100 text-yellow-800' } }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $r->expected_close_date?->format('M d, Y') ?? '-' }}</td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('organizer.renewals.update-stage', $r->id) }}" class="flex gap-1">
                                    @csrf
                                    <select name="status" class="text-xs rounded border-gray-300">
                                        <option value="negotiation" {{ $r->status === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                        <option value="proposal_sent" {{ $r->status === 'proposal_sent' ? 'selected' : '' }}>Proposal Sent</option>
                                        <option value="approved" {{ $r->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="renewed" {{ $r->status === 'renewed' ? 'selected' : '' }}>Renewed</option>
                                        <option value="lost" {{ $r->status === 'lost' ? 'selected' : '' }}>Lost</option>
                                    </select>
                                    <button type="submit" class="text-xs text-indigo-600 hover:underline">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No renewals.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $renewals->links() }}
    </div>
</x-app-layout>
