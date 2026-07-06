<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sponsorship Report') }}
            </h2>
            <a href="{{ route('admin.reports') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Accepted</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['accepted']) }}</p>
                </div>
                <div class="card p-4 text-center">
                    <p class="text-sm text-gray-500">Rejected</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($stats['rejected']) }}</p>
                </div>
            </div>

            {{-- Sponsorships Table --}}
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">All Sponsorships</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sponsor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sponsorships as $sponsorship)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $sponsorship->event->title ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $sponsorship->sponsor->name ?? 'N/A' }}</span>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">No sponsorships found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $sponsorships->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
