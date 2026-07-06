<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">AI Opportunity Matching</h2>
            <span class="text-sm text-gray-500">Powered by intelligent scoring</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if($budget)
        <div class="card p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">FY{{ $budget->fiscal_year }} Budget</span>
                <span class="text-sm font-bold text-gray-900">₹{{ number_format($budget->remaining) }} remaining</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                @php $usedPct = $budget->total_budget > 0 ? (($budget->allocated + $budget->spent) / $budget->total_budget) * 100 : 0; @endphp
                <div class="bg-terracotta-500 h-2 rounded-full" style="width: {{ min($usedPct, 100) }}%"></div>
            </div>
        </div>
        @endif

        <div class="card p-4">
            <form action="{{ route('sponsor.ai-matching.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <select name="industry" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="">All Industries</option>
                        @foreach($industries as $ind)
                            <option value="{{ $ind }}" {{ ($filters['industry'] ?? '') === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Budget</label>
                    <input type="number" name="budget_max" value="{{ $filters['budget_max'] ?? '' }}" placeholder="Enter amount" class="w-full rounded-lg border-gray-200 text-sm">
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ $filters['location'] ?? '' }}" placeholder="City" class="w-full rounded-lg border-gray-200 text-sm">
                </div>
                <button type="submit" class="btn-primary px-4 py-2">Filter Matches</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recommendations as $rec)
                <div class="card hover:shadow-md transition relative overflow-hidden">
                    @if($rec->match_level === 'high')
                        <div class="absolute top-0 right-0 w-16 h-16">
                            <div class="absolute transform rotate-45 bg-green-500 text-white text-[10px] font-bold py-1 px-6 -right-5 top-3">BEST MATCH</div>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="badge badge-{{ $rec->match_level === 'high' ? 'success' : ($rec->match_level === 'medium' ? 'warning' : 'gray') }} text-xs">
                                {{ ucfirst($rec->match_level) }} match
                            </span>
                            <span class="text-lg font-bold {{ $rec->score >= 75 ? 'text-green-600' : ($rec->score >= 50 ? 'text-yellow-600' : 'text-gray-400') }}">
                                {{ $rec->score }}%
                            </span>
                        </div>

                        <h3 class="font-semibold text-gray-900 mb-1">{{ $rec->event->title }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $rec->event->city }}, {{ $rec->event->start_date?->format('M d, Y') }}</p>

                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach($rec->reasons as $reason)
                                <span class="badge badge-success text-[10px]">{{ $reason }}</span>
                            @endforeach
                        </div>

                        @if($rec->event->packages->isNotEmpty())
                            <p class="text-sm text-gray-600 mb-4">
                                Packages from <span class="font-semibold">₹{{ number_format($rec->event->packages->min('price')) }}</span>
                            </p>
                        @endif

                        <div class="flex items-center gap-2">
                            <a href="{{ route('sponsor.events.show', $rec->event) }}" class="btn-outline text-sm px-3 py-1.5 flex-1 text-center">View Event</a>
                            @if(!in_array($rec->event->id, $savedIds))
                                <form action="{{ route('sponsor.events.save', $rec->event) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-outline text-sm px-3 py-1.5">Save</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full card p-12 text-center">
                    <p class="text-gray-500">No matching opportunities found.</p>
                    <p class="text-sm text-gray-400 mt-1">Try adjusting your filters or check back later for new events.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
