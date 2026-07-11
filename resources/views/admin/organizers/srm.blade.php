<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sponsor Relationships (SRM)') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Health Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($relationships as $rel)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rel->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $rel->sponsor->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4"><span class="badge badge-{{ ($rel->health_score ?? 0) >= 70 ? 'success' : (($rel->health_score ?? 0) >= 40 ? 'warning' : 'danger') }}">{{ $rel->health_score ?? 'N/A' }}/100</span></td>
                                    <td class="px-6 py-4"><span class="badge badge-info">{{ ucfirst($rel->status ?? 'active') }}</span></td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.srm.show', $rel) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No relationships found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $relationships->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
