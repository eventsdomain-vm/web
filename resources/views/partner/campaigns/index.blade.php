<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Campaigns</h2></x-slot>
    <div class="container-page">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($campaigns as $c)
                <div class="card p-5">
                    <div class="flex justify-between items-start">
                        <div><h3 class="font-semibold text-gray-900">{{ $c->name }}</h3><p class="text-xs text-gray-500 mt-1">{{ $c->sponsor?->name ?? 'N/A' }} • {{ $c->event?->title ?? 'N/A' }}</p></div>
                        <span class="badge badge-{{ $c->status === 'active' ? 'success' : ($c->status === 'completed' ? 'info' : 'warning') }} text-xs">{{ $c->status }}</span>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between text-sm">
                        <span class="text-gray-500">Budget: ₹{{ number_format($c->budget ?? 0) }}</span>
                        <a href="{{ route('partner.campaigns.show', $c->id) }}" class="text-terracotta-500 hover:underline">View</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">No campaigns found.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $campaigns->links() }}</div>
    </div>
</x-app-layout>
