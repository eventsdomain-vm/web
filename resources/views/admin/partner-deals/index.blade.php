<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Partner Deals') }}</h2></x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="stage" class="input-field w-auto"><option value="">All Stages</option>@foreach($stages as $s)<option value="{{ $s }}" {{ request('stage')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select>
                    <input type="text" name="search" placeholder="Search partner..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <table class="w-full"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Partner</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Sponsor</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Event</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Value</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Stage</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Close Date</th><th class="px-6 py-3 text-right text-xs font-medium uppercase">Actions</th></tr></thead>
                    <tbody class="divide-y">@forelse($deals as $deal)<tr class="hover:bg-gray-50"><td class="px-6 py-4 text-sm font-medium">{{ $deal->partner->name ?? 'N/A' }}</td><td class="px-6 py-4 text-sm text-gray-600">{{ $deal->sponsor->name ?? 'N/A' }}</td><td class="px-6 py-4 text-sm text-gray-600">{{ $deal->event->title ?? 'N/A' }}</td><td class="px-6 py-4 text-sm">&#8377;{{ number_format($deal->deal_value ?? 0) }}</td><td class="px-6 py-4"><span class="badge badge-{{ $deal->stage === 'completed' ? 'success' : ($deal->stage === 'lost' ? 'danger' : 'info') }}">{{ ucfirst($deal->stage) }}</span></td><td class="px-6 py-4 text-sm text-gray-500">{{ $deal->expected_close_date?->format('M d, Y') ?? 'N/A' }}</td><td class="px-6 py-4 text-right"><a href="{{ route('admin.partner-deals.show', $deal) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td></tr>@empty <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No deals found.</td></tr>@endforelse</tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $deals->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
