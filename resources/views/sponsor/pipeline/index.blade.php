<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deal Pipeline</h2>
            <a href="{{ route('sponsor.proposals.index') }}" class="btn-outline text-sm px-3 py-1.5">View All Proposals</a>
        </div>
    </x-slot>

    <div class="overflow-x-auto pb-4">
        <div class="flex gap-4 min-w-[900px]">
            @php
                $columnConfig = [
                    'discovery' => ['label' => 'Discovery', 'color' => 'gray'],
                    'interest' => ['label' => 'Interest', 'color' => 'blue'],
                    'proposal' => ['label' => 'Proposal', 'color' => 'yellow'],
                    'negotiation' => ['label' => 'Negotiation', 'color' => 'orange'],
                    'closed_won' => ['label' => 'Closed Won', 'color' => 'green'],
                    'closed_lost' => ['label' => 'Closed Lost', 'color' => 'red'],
                ];
            @endphp

            @foreach($columnConfig as $key => $config)
                <div class="flex-1 min-w-[140px]">
                    <div class="card mb-3">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-sm text-gray-900">{{ $config['label'] }}</h3>
                                <span class="text-xs text-gray-500">{{ $columnTotals[$key]['count'] }}</span>
                            </div>
                            @if($columnTotals[$key]['value'] > 0)
                                <p class="text-xs text-gray-400 mt-0.5">₹{{ number_format($columnTotals[$key]['value']) }}</p>
                            @endif
                        </div>
                        <div class="p-3 space-y-2 min-h-[120px]">
                            @forelse($columns[$key] as $proposal)
                                <div class="bg-{{ $config['color'] }}-50 rounded-lg p-3 border border-{{ $config['color'] }}-100 hover:shadow-sm transition cursor-pointer">
                                    <h4 class="font-medium text-sm text-gray-900 truncate">{{ $proposal->event?->title ?? 'Event #' . $proposal->event_id }}</h4>
                                    @if($proposal->budget_offer)
                                        <p class="text-xs font-medium text-gray-600 mt-1">₹{{ number_format($proposal->budget_offer) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-[10px] text-gray-400">{{ $proposal->created_at->format('M d') }}</span>
                                        <a href="{{ route('sponsor.proposals.show', $proposal) }}" class="text-[10px] text-terracotta-500 hover:underline">View</a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-300 text-xs py-4">No deals</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
