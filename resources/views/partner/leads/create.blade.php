<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.leads.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Lead</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <form method="POST" action="{{ route('partner.leads.store') }}" class="card p-6 max-w-2xl">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                    <select name="source" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="marketplace">Marketplace</option>
                        <option value="ai">AI Match</option>
                        <option value="organizer">Organizer Invitation</option>
                        <option value="referral">Referral</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stage</label>
                    <select name="stage" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="qualified">Qualified</option>
                        <option value="proposal">Proposal</option>
                        <option value="negotiation">Negotiation</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value (₹)</label>
                    <input type="number" name="value" step="0.01" min="0" class="w-full rounded-lg border-gray-300 text-sm" placeholder="50000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Probability (%)</label>
                    <input type="number" name="probability" min="0" max="100" class="w-full rounded-lg border-gray-300 text-sm" placeholder="50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expected Close Date</label>
                    <input type="date" name="expected_close_date" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Lead details..."></textarea>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-sm">Create Lead</button>
            </div>
        </form>
    </div>
</x-app-layout>
