<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $comparison->name }}</h2>
            <a href="{{ route('partner.compare.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Comparisons</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-xl shadow-sm overflow-hidden">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Metric</th>
                            @foreach($comparison->services as $service)
                                <th class="px-4 py-3 text-center text-sm font-bold text-gray-900 min-w-[200px]">
                                    {{ $service->title }}
                                    <form action="{{ route('partner.compare.remove-service', [$comparison, $service]) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 ml-2">Remove</button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Category</td>
                            @foreach($comparison->services as $service)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $service->category->name ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Type</td>
                            @foreach($comparison->services as $service)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center capitalize">{{ $service->pricing_model }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Price</td>
                            @foreach($comparison->services as $service)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">₹{{ number_format($service->price) }}/{{ $service->price_type }}</td>
                            @endforeach
                        </tr>
                        @foreach($comparison->services as $service)
                        <tr class="{{ $i % 2 === 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Availability</td>
                            @foreach($comparison->services as $comparisonService)
                                @php $isAvailable = $comparisonService->id === $service->id; @endphp
                                <td class="px-4 py-3 text-sm text-center">
                                    @if($isAvailable)
                                        <span class="inline-block px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">Available</span>
                                        <span class="text-xs text-gray-400 block mt-0.5">{{ $service->is_available ? '🟢' : '🔴' }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Partner</td>
                            @foreach($comparison->services as $service)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $service->partner->name }}</td>
                            @endforeach
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700"></td>
                            @foreach($comparison->services as $service)
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('partner.services.show', $service) }}" class="btn-outline text-xs">View Service</a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
