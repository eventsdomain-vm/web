<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deals</h2>
            <a href="{{ route('partner.deals.create') }}" class="btn-primary text-sm px-4 py-2 rounded-lg">+ New Deal</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="flex gap-2 mb-4 flex-wrap">
            <a href="{{ route('partner.deals.index') }}" class="text-xs px-3 py-1 rounded-full {{ !request('stage') ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            @foreach($stages as $s)
                <a href="{{ route('partner.deals.index', ['stage' => $s]) }}" class="text-xs px-3 py-1 rounded-full {{ request('stage') === $s ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($s) }}</a>
            @endforeach
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3 text-gray-600 font-medium">ID</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Stage</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Value</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Commission</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Expected Close</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($deals as $deal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $deal->id }}</td>
                            <td class="px-4 py-3"><span class="badge badge-{{ $deal->stage === 'completed' ? 'success' : ($deal->stage === 'lost' ? 'danger' : 'info') }} text-xs">{{ $deal->stage }}</span></td>
                            <td class="px-4 py-3">{{ $deal->deal_value ? '₹'.number_format($deal->deal_value) : '—' }}</td>
                            <td class="px-4 py-3">{{ $deal->commission_rate ? $deal->commission_rate.'%' : '—' }}</td>
                            <td class="px-4 py-3">{{ $deal->expected_close_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('partner.deals.show', $deal->id) }}" class="text-terracotta-500 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">No deals found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $deals->links() }}</div>
    </div>
</x-app-layout>
