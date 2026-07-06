<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manage Organizers') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" placeholder="Search organizers..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organization</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Events</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verified</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($organizers as $organizer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $organizer->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $organizer->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $organizer->profile->company_name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $organizer->organizedEvents()->count() }}</td>
                                    <td class="px-6 py-4">
                                        <span class="badge {{ $organizer->is_verified ? 'badge-success' : 'badge-warning' }}">
                                            {{ $organizer->is_verified ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.organizers.show', $organizer) }}" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No organizers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $organizers->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
