<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Leads</h2>
            <a href="{{ route('partner.leads.create') }}" class="btn-primary text-sm px-4 py-2 rounded-lg">+ New Lead</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="flex gap-2 mb-4 flex-wrap">
            <a href="{{ route('partner.leads.index') }}" class="text-xs px-3 py-1 rounded-full {{ !request('stage') ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            @foreach($stages as $s)
                <a href="{{ route('partner.leads.index', ['stage' => $s]) }}" class="text-xs px-3 py-1 rounded-full {{ request('stage') === $s ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($s) }}</a>
            @endforeach
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3 text-gray-600 font-medium">ID</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Source</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Stage</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Value</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Priority</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Assigned</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">#{{ $lead->id }}</td>
                            <td class="px-4 py-3 capitalize">{{ $lead->source }}</td>
                            <td class="px-4 py-3"><span class="badge badge-{{ $lead->stage === 'won' ? 'success' : ($lead->stage === 'lost' ? 'danger' : 'info') }} text-xs">{{ $lead->stage }}</span></td>
                            <td class="px-4 py-3">{{ $lead->value ? '₹'.number_format($lead->value) : '—' }}</td>
                            <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded {{ $lead->priority === 'high' ? 'bg-red-100 text-red-700' : ($lead->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600') }}">{{ ucfirst($lead->priority) }}</span></td>
                            <td class="px-4 py-3">{{ $lead->assignedTo?->name ?? '—' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('partner.leads.show', $lead->id) }}" class="text-terracotta-500 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-12 text-center text-gray-500">No leads found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $leads->links() }}</div>
    </div>
</x-app-layout>
