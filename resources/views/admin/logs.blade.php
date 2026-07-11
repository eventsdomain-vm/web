<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Filters --}}
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="action" class="input-field w-auto">
                        <option value="">All Actions</option>
                        <option value="event_approved" {{ request('action') === 'event_approved' ? 'selected' : '' }}>Event Approved</option>
                        <option value="event_rejected" {{ request('action') === 'event_rejected' ? 'selected' : '' }}>Event Rejected</option>
                        <option value="user_verified" {{ request('action') === 'user_verified' ? 'selected' : '' }}>User Verified</option>
                        <option value="user_banned" {{ request('action') === 'user_banned' ? 'selected' : '' }}>User Banned</option>
                        <option value="category_created" {{ request('action') === 'category_created' ? 'selected' : '' }}>Category Created</option>
                        <option value="settings_updated" {{ request('action') === 'settings_updated' ? 'selected' : '' }}>Settings Updated</option>
                    </select>
                    <input type="text" name="search" placeholder="Search logs..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>

            {{-- Logs List --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge badge-info">{{ str_replace('_', ' ', $log->action) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $log->description ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-500 font-mono">{{ $log->ip_address ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $log->created_at->format('M d, Y g:i A') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">No activity logs found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $logs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
