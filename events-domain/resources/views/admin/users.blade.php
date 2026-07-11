<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            <!-- Tabs -->
            <div class="card p-4 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-1 bg-gray-100 rounded-lg p-1">
                        <a href="{{ route('admin.users') }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition {{ request('role') === null ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            All
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'organizer']) }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition {{ request('role') === 'organizer' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Organizers
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'sponsor']) }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition {{ request('role') === 'sponsor' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Sponsors
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'partner']) }}"
                           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md transition {{ request('role') === 'partner' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Partners
                        </a>
                    </div>
                    <form method="GET" class="flex gap-2">
                        @if(request('role'))
                            <input type="hidden" name="role" value="{{ request('role') }}">
                        @endif
                        <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="input-field w-64">
                        <button type="submit" class="btn-primary text-sm">Search</button>
                    </form>
                </div>
            </div>

            <!-- Users List -->
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Verified</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge badge-info capitalize">{{ $user->role_name ?? 'User' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->hasVerifiedEmail())
                                            <span class="badge badge-success">Verified</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">No users found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
