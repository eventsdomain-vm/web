<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports & Analytics</h2></x-slot>
    <div class="container-page space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Revenue</h3>
                <p class="text-2xl font-bold text-gray-900 mb-2">₹{{ number_format($revenue['total']) }}</p>
                <div class="space-y-1">
                    @foreach($revenue['monthly'] as $m)
                        <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                            <span class="text-gray-600">{{ $m['month'] }}</span>
                            <span class="font-medium">₹{{ number_format($m['total']) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Conversion</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $conversion['rate'] }}%</p>
                <div class="flex justify-between text-sm"><span class="text-gray-500">Total Leads</span><span>{{ $conversion['totalLeads'] }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-green-600">Won</span><span>{{ $conversion['wonLeads'] }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-red-600">Lost</span><span>{{ $conversion['lostLeads'] }}</span></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Lead Funnel</h3>
                @foreach($leadFunnel as $stage => $count)
                    <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                        <span class="text-gray-600 capitalize">{{ $stage }}</span>
                        <span class="font-medium">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Commission Summary</h3>
                @foreach($commission['byStatus'] as $status => $data)
                    <div class="flex justify-between text-sm py-1 border-b border-gray-50">
                        <span class="capitalize text-gray-600">{{ $status }}</span>
                        <span class="font-medium">₹{{ number_format($data['total']) }} ({{ $data['count'] }})</span>
                    </div>
                @endforeach
                <div class="flex justify-between text-sm pt-2 font-bold">
                    <span>Total</span><span>₹{{ number_format($commission['total']) }}</span>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Partner Performance</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                <div><p class="text-xs text-gray-500">Total Deals</p><p class="text-xl font-bold">{{ $partnerPerformance['totalDeals'] }}</p></div>
                <div><p class="text-xs text-gray-500">Won Deals</p><p class="text-xl font-bold text-green-600">{{ $partnerPerformance['wonDeals'] }}</p></div>
                <div><p class="text-xs text-gray-500">Win Rate</p><p class="text-xl font-bold">{{ $partnerPerformance['winRate'] }}%</p></div>
                <div><p class="text-xs text-gray-500">Avg Deal Size</p><p class="text-xl font-bold">₹{{ number_format($partnerPerformance['avgDealSize']) }}</p></div>
                <div><p class="text-xs text-gray-500">Total Value</p><p class="text-xl font-bold">₹{{ number_format($partnerPerformance['totalValue']) }}</p></div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Campaign Performance</h3>
            @if(count($campaignPerformance) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-left">
                            <tr><th class="px-4 py-2">Name</th><th class="px-4 py-2">Status</th><th class="px-4 py-2">Budget</th><th class="px-4 py-2">Attendance</th><th class="px-4 py-2">Engagement</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($campaignPerformance as $c)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $c['name'] }}</td>
                                    <td class="px-4 py-2"><span class="badge badge-info text-xs">{{ $c['status'] }}</span></td>
                                    <td class="px-4 py-2">₹{{ number_format($c['budget'] ?? 0) }}</td>
                                    <td class="px-4 py-2">{{ number_format($c['attendance'] ?? 0) }}</td>
                                    <td class="px-4 py-2">{{ $c['engagement'] ?? '—' }}{{ isset($c['engagement']) ? '%' : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-sm">No campaigns yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
