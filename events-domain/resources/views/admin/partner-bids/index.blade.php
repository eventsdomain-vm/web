<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Partner Bids') }}</h2></x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto"><option value="">All Status</option><option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option><option value="accepted" {{ request('status')==='accepted'?'selected':'' }}>Accepted</option><option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Rejected</option></select>
                    <input type="text" name="search" placeholder="Search event..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <table class="w-full"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Event</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Partner</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Service</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Quote</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th><th class="px-6 py-3 text-right text-xs font-medium uppercase">Actions</th></tr></thead>
                    <tbody class="divide-y">@forelse($bids as $bid)<tr class="hover:bg-gray-50"><td class="px-6 py-4 text-sm font-medium">{{ $bid->event->title ?? 'N/A' }}</td><td class="px-6 py-4 text-sm text-gray-600">{{ $bid->partner->name ?? 'N/A' }}</td><td class="px-6 py-4 text-sm text-gray-600">{{ $bid->service->title ?? 'N/A' }}</td><td class="px-6 py-4 text-sm">&#8377;{{ number_format($bid->quote_amount) }}</td><td class="px-6 py-4"><span class="badge badge-{{ $bid->status === 'accepted' ? 'success' : ($bid->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($bid->status) }}</span></td><td class="px-6 py-4 text-right"><a href="{{ route('admin.partner-bids.show', $bid) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td></tr>@empty <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No bids found.</td></tr>@endforelse</tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $bids->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
