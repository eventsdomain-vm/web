<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compare Services</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($comparisons->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($comparisons as $comparison)
                        <div class="card p-6 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-semibold text-gray-900">{{ $comparison->name }}</h3>
                                <span class="text-xs text-gray-500">{{ $comparison->services_count }} services</span>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">Created {{ $comparison->created_at->diffForHumans() }}</p>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('partner.compare.show', $comparison) }}" class="btn-primary text-sm">View Comparison</a>
                                <form action="{{ route('partner.compare.destroy', $comparison) }}" method="POST" onsubmit="return confirm('Delete this comparison?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
                    <p class="text-gray-500 text-lg mb-2">No comparisons yet</p>
                    <p class="text-gray-400 text-sm mb-6">Select services and compare them side-by-side to make informed hiring decisions.</p>
                    <a href="{{ route('partner.opportunities') }}" class="btn-primary">Browse Opportunities</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
