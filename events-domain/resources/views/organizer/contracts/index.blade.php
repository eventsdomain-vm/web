<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Contracts & Finance</h2></x-slot>
    <div class="container-page space-y-6">
        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead><tr class="text-left bg-gray-50 text-gray-600"><th class="p-3">Sponsor</th><th class="p-3">Event</th><th class="p-3">Amount</th><th class="p-3">Status</th><th class="p-3">Signed</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse ($contracts as $c)
                        <tr class="border-t border-gray-100">
                            <td class="p-3 font-medium">{{ $c->sponsor?->company_name ?? 'ID:'.$c->sponsor_id }}</td>
                            <td class="p-3">{{ $c->event?->title ?? '-' }}</td>
                            <td class="p-3">₹{{ number_format($c->amount ?? 0, 2) }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ match($c->status) { 'active' => 'bg-green-100 text-green-800', 'pending' => 'bg-yellow-100 text-yellow-800', 'expired' => 'bg-red-100 text-red-800', 'cancelled' => 'bg-gray-100 text-gray-800', default => 'bg-blue-100 text-blue-800' } }}">
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $c->signed_at?->format('M d, Y') ?? '-' }}</td>
                            <td class="p-3"><a href="{{ route('organizer.contracts.show', $c->id) }}" class="text-indigo-600 hover:underline text-xs">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center text-gray-400">No contracts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $contracts->links() }}
    </div>
</x-app-layout>
