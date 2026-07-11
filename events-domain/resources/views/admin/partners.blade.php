<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Partners') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Filters --}}
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" placeholder="Search partners..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>

            {{-- Partners List --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($partners as $partner)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $partner->avatar_url }}" alt="{{ $partner->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $partner->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $partner->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $partner->profile->company_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($partner->is_verified)
                                            <span class="badge badge-success">Verified</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $partner->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @unless($partner->is_verified)
                                                <form action="{{ route('admin.partners.verify', $partner) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">No partners found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $partners->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
