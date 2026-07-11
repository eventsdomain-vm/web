<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sponsorship Contracts') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
                        <option value="signed" {{ request('status') === 'signed' ? 'selected' : '' }}>Signed</option>
                    </select>
                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sponsor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($contracts as $contract)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $contract->event->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contract->event->organizer->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contract->sponsor->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">&#8377;{{ number_format($contract->amount ?? 0) }}</td>
                                    <td class="px-6 py-4"><span class="badge badge-{{ $contract->status === 'active' ? 'success' : ($contract->status === 'terminated' ? 'danger' : 'info') }}">{{ ucfirst($contract->status) }}</span></td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.contracts.show', $contract) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No contracts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $contracts->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
