<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Analytics & Reports</h2></x-slot>
    <div class="container-page space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card p-4"><p class="text-xs text-gray-500">Total Events</p><p class="text-2xl font-bold text-indigo-600">{{ $totalEvents }}</p><p class="text-xs text-gray-400">{{ $publishedEvents }} published, {{ $draftEvents }} draft</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Contract Value (Active)</p><p class="text-2xl font-bold text-green-600">₹{{ number_format($totalContractValue, 0) }}</p><p class="text-xs text-gray-400">{{ $activeContracts }} active contracts</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Sponsorship Requests</p><p class="text-2xl font-bold text-yellow-600">{{ $pendingRequests }}</p><p class="text-xs text-gray-400">{{ $acceptedRequests }} accepted</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Active Sponsors</p><p class="text-2xl font-bold text-blue-600">{{ $activeSponsors }}</p><p class="text-xs text-gray-400">Avg health: {{ $avgHealthScore ? number_format($avgHealthScore, 1) : 'N/A' }}</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Avg Sponsor Satisfaction</p><p class="text-2xl font-bold text-purple-600">{{ $avgSatisfaction ? number_format($avgSatisfaction, 1) : 'N/A' }}/5</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Avg ROI</p><p class="text-2xl font-bold text-green-600">{{ $avgROI ? number_format($avgROI, 1).'%' : 'N/A' }}</p></div>
            <div class="card p-4"><p class="text-xs text-gray-500">Total Post-Event Revenue</p><p class="text-2xl font-bold text-emerald-600">₹{{ number_format($totalRevenue, 0) }}</p></div>
        </div>
    </div>
</x-app-layout>
