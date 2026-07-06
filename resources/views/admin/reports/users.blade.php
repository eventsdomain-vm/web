<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Report') }}
            </h2>
            <a href="{{ route('admin.reports') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Organizers</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['organizers']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Sponsors</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['sponsors']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Partners</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['partners']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Verified</p>
                    <p class="text-2xl font-bold text-[#E35336]">{{ number_format($stats['verified']) }}</p>
                </div>
            </div>

            {{-- Users Table --}}
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">All Users</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover mr-3">
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
                                        @if($user->is_verified)
                                            <span class="text-green-600 text-sm">Yes</span>
                                        @else
                                            <span class="text-gray-400 text-sm">No</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
