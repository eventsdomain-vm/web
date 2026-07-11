<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">{{ $type }} Report</h2>
            <div class="flex gap-2">
                <a href="{{ route('sponsor.reports.index') }}" class="btn-outline text-sm px-3 py-1.5">All Reports</a>
                <a href="{{ route('sponsor.reports.export', $type) }}" class="btn-primary text-sm px-3 py-1.5">Export CSV</a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(!empty($data['summary']))
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Summary</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($data['summary'] as $label => $value)
                        <div>
                            <p class="text-sm text-gray-500">{{ $label }}</p>
                            <p class="text-xl font-semibold text-gray-900">
                                @if(is_float($value) || is_int($value))
                                    @if($value > 1000) ₹{{ number_format($value) }} @else {{ $value }} @endif
                                @else
                                    {{ $value }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 capitalize">{{ $type }} Data</h3>
            </div>
            @if(!empty($data['rows']))
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                @foreach($data['labels'] as $label)
                                    <th class="px-6 py-3 text-left font-medium text-gray-600">{{ $label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($data['rows'] as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    @foreach($row as $cell)
                                        <td class="px-6 py-3 text-gray-700">
                                            @if(is_float($cell) && $cell > 100)
                                                ₹{{ number_format($cell, 2) }}
                                            @else
                                                {{ $cell }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center text-gray-500 text-sm">No data available for this report.</div>
            @endif
        </div>
    </div>
</x-app-layout>
