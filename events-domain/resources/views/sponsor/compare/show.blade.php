<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $comparison->name }}</h2>
            <a href="{{ route('sponsor.compare.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Comparisons</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-xl shadow-sm overflow-hidden">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Metric</th>
                            @foreach($comparison->events as $event)
                                <th class="px-4 py-3 text-center text-sm font-bold text-gray-900 min-w-[200px]">
                                    {{ $event->title }}
                                    <form action="{{ route('sponsor.compare.remove-event', [$comparison, $event]) }}" method="POST" class="inline">
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
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $event->category->name ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Date</td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $event->start_date?->format('M d, Y') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Location</td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $event->city }}, {{ $event->state }}</td>
                            @endforeach
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Expected Audience</td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ number_format($event->expected_audience) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Sponsorship Type</td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center capitalize">{{ $event->sponsorship_type }}</td>
                            @endforeach
                        </tr>
                        @foreach($comparison->events->first()?->packages ?? [] as $i => $package)
                        <tr class="{{ $i % 2 === 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Package: {{ $package->title }}</td>
                            @foreach($comparison->events as $event)
                                @php $pkg = $event->packages->where('id', $package->id)->first() ?? $event->packages->get($i); @endphp
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                    @if($pkg)
                                        ₹{{ number_format($pkg->price) }}
                                        <span class="text-xs text-gray-400 block">({{ $pkg->slots_filled }}/{{ $pkg->slots_available }} slots)</span>
                                    @else
                                        <span class="text-gray-300">--</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">Organizer</td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $event->organizer->name }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700"></td>
                            @foreach($comparison->events as $event)
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('sponsor.events.show', $event) }}" class="btn-primary text-xs">View Event</a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
