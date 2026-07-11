<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sponsorship Renewals') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="negotiating" {{ request('status') === 'negotiating' ? 'selected' : '' }}>Negotiating</option>
                        <option value="renewed" {{ request('status') === 'renewed' ? 'selected' : '' }}>Renewed</option>
                        <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                    <input type="text" name="search" placeholder="Search sponsor..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sponsor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proposed Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Probability</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expected Close</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($renewals as $renewal)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $renewal->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $renewal->sponsor->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">&#8377;{{ number_format($renewal->proposed_value ?? 0) }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $renewal->probability ?? 'N/A' }}%</td>
                                    <td class="px-6 py-4"><span class="badge badge-{{ $renewal->status === 'renewed' ? 'success' : ($renewal->status === 'lost' ? 'danger' : 'warning') }}">{{ ucfirst($renewal->status) }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $renewal->expected_close_date?->format('M d, Y') ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.renewals.show', $renewal) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No renewals found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $renewals->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
