<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">AI Copilot</h2></x-slot>
    <div class="container-page space-y-6">
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue Forecast</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-amber-50 rounded-lg p-4 text-center"><p class="text-xs text-amber-700">Conservative</p><p class="text-lg font-bold text-amber-800 mt-1">₹{{ number_format($forecast['conservative']) }}</p></div>
                <div class="bg-blue-50 rounded-lg p-4 text-center"><p class="text-xs text-blue-700">Likely</p><p class="text-lg font-bold text-blue-800 mt-1">₹{{ number_format($forecast['likely']) }}</p></div>
                <div class="bg-green-50 rounded-lg p-4 text-center"><p class="text-xs text-green-700">Optimistic</p><p class="text-lg font-bold text-green-800 mt-1">₹{{ number_format($forecast['optimistic']) }}</p></div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Opportunity Recommendations</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($recommendations as $rec)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                        <div class="flex justify-between items-start">
                            <h4 class="font-medium text-gray-900 text-sm">{{ $rec['event']->title }}</h4>
                            <span class="text-xs font-bold text-terracotta-500">{{ $rec['score'] }}/100</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $rec['event']->city ?? 'N/A' }} • {{ $rec['event']->start_date?->format('d M Y') ?? '' }}</p>
                        @if(!empty($rec['reasons']))
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($rec['reasons'] as $r)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $r }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400 text-sm col-span-3">No recommendations available.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
