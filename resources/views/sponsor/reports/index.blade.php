<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('sponsor.reports.show', 'financial') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Financial Report</h3>
                    <p class="text-sm text-gray-500">Proposals, budgets, and overall financial summary.</p>
                </div>
            </a>

            <a href="{{ route('sponsor.reports.show', 'campaign') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Campaign Report</h3>
                    <p class="text-sm text-gray-500">All campaigns with status, progress, and budget.</p>
                </div>
            </a>

            <a href="{{ route('sponsor.reports.show', 'roi') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">ROI Report</h3>
                    <p class="text-sm text-gray-500">Campaign ROI analysis and performance metrics.</p>
                </div>
            </a>

            <a href="{{ route('sponsor.reports.show', 'contract') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Contract Report</h3>
                    <p class="text-sm text-gray-500">All contracts with status, value, and expiry.</p>
                </div>
            </a>

            <a href="{{ route('sponsor.reports.show', 'invoice') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Invoice Report</h3>
                    <p class="text-sm text-gray-500">Invoice status, payments, and outstanding amounts.</p>
                </div>
            </a>

            <a href="{{ route('sponsor.reports.show', 'budget') }}" class="card hover:shadow-md transition block">
                <div class="p-6">
                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Budget Report</h3>
                    <p class="text-sm text-gray-500">Budget allocation, spending, and remaining funds.</p>
                </div>
            </a>
        </div>

        @if($reports->isNotEmpty())
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Generated Reports</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($reports as $report)
                    <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $report->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $report->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="badge badge-gray text-xs">{{ $report->status }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
