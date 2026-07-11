<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Social Accounts') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="provider" class="input-field w-auto">
                        <option value="">All Providers</option>
                        <option value="facebook" {{ request('provider') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="linkedin" {{ request('provider') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="google" {{ request('provider') === 'google' ? 'selected' : '' }}>Google</option>
                    </select>
                    <input type="text" name="search" placeholder="Search user..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Provider</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Connected At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Token Expires</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($accounts as $account)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $account->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4"><span class="badge badge-info">{{ ucfirst($account->provider) }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $account->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $account->email ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $account->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $account->token_expires_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No social accounts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $accounts->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
