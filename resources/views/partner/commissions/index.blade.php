<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Commissions</h2></x-slot>
    <div class="container-page">
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="card p-4 text-center"><p class="text-xs text-gray-500">Pending</p><p class="text-xl font-bold text-amber-600 mt-1">₹{{ number_format($totals['pending']) }}</p></div>
            <div class="card p-4 text-center"><p class="text-xs text-gray-500">Approved</p><p class="text-xl font-bold text-blue-600 mt-1">₹{{ number_format($totals['approved']) }}</p></div>
            <div class="card p-4 text-center"><p class="text-xs text-gray-500">Paid</p><p class="text-xl font-bold text-green-600 mt-1">₹{{ number_format($totals['paid']) }}</p></div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr><th class="px-4 py-3 text-gray-600 font-medium">Deal</th><th class="px-4 py-3 text-gray-600 font-medium">Amount</th><th class="px-4 py-3 text-gray-600 font-medium">Rate</th><th class="px-4 py-3 text-gray-600 font-medium">Status</th><th class="px-4 py-3 text-gray-600 font-medium">Date</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($commissions as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $c->deal_id ?? 'N/A' }}</td>
                            <td class="px-4 py-3">₹{{ number_format($c->amount) }}</td>
                            <td class="px-4 py-3">{{ $c->rate ? $c->rate.'%' : '—' }}</td>
                            <td class="px-4 py-3"><span class="badge badge-{{ $c->status === 'paid' ? 'success' : ($c->status === 'pending' ? 'warning' : 'info') }} text-xs">{{ $c->status }}</span></td>
                            <td class="px-4 py-3">{{ $c->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">No commissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $commissions->links() }}</div>
    </div>
</x-app-layout>
