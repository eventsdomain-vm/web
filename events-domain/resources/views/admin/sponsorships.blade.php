<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Sponsorships') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Filters --}}
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="negotiating" {{ request('status') === 'negotiating' ? 'selected' : '' }}>Negotiating</option>
                    </select>
                    <input type="text" name="search" placeholder="Search by event name..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>

            {{-- Sponsorships List --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sponsor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget Offer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sponsorships as $sponsorship)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $sponsorship->event->title ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600">{{ $sponsorship->sponsor->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-400">{{ $sponsorship->sponsor->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $sponsorship->package->title ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($sponsorship->budget_offer)
                                            <span class="text-sm font-medium text-gray-900">₹{{ number_format($sponsorship->budget_offer) }}</span>
                                        @else
                                            <span class="text-sm text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge badge-{{ $sponsorship->status_color }}">{{ $sponsorship->status_label }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $sponsorship->created_at->format('M d, Y') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">No sponsorship requests found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $sponsorships->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
