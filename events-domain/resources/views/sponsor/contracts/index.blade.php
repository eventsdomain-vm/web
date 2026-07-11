<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contracts</h2>
            <span class="text-sm text-gray-500">{{ method_exists($contracts, 'total') ? $contracts->total() : $contracts->count() }} total</span>
        </div>
    </x-slot>
    <div class="container-page py-6">
        @forelse($contracts as $contract)
            <div class="card mb-4 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('sponsor.contracts.show', $contract) }}" class="font-semibold text-gray-900 hover:text-terracotta-500">{{ $contract->title ?? $contract->contract_number ?? 'Contract #'.$contract->id }}</a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>{{ $contract->event?->title }}</span>
                            <span>₹{{ number_format($contract->amount) }}</span>
                            @if($contract->start_date)<span>{{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date?->format('M d, Y') ?? 'Ongoing' }}</span>@endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-{{ $contract->status_color }}">{{ $contract->status_label }}</span>
                        <a href="{{ route('sponsor.contracts.show', $contract) }}" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">No contracts yet.</div>
        @endforelse
        @if(method_exists($contracts, 'links')){{ $contracts->links() }}@endif
    </div>
</x-app-layout>
