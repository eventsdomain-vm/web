<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Partner Workspace</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Assigned Clients</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $kpis['assignments'] }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Active Leads</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $kpis['activeLeads'] }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Pipeline Value</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">₹{{ number_format($kpis['pipelineValue']) }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Won Deals</p>
                    <p class="text-2xl font-bold text-terracotta-500 mt-1">{{ $kpis['wonDeals'] }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Running Campaigns</p>
                    <p class="text-2xl font-bold text-purple-600 mt-1">{{ $kpis['runningCampaigns'] }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Commission Earned</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">₹{{ number_format($kpis['commissionEarned']) }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Pending Commission</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">₹{{ number_format($kpis['pendingCommission']) }}</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Upcoming Meetings</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $kpis['upcomingMeetings'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Trend</h3>
                    @if(count($revenueTrend) > 0)
                        <div class="space-y-2">
                            @foreach($revenueTrend as $point)
                                <div class="flex items-center justify-between py-1 border-b border-gray-50 text-sm">
                                    <span class="text-gray-600">{{ $point['month'] }}</span>
                                    <span class="font-medium text-gray-900">₹{{ number_format($point['total']) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">No revenue data yet.</p>
                    @endif
                </div>

                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Forecast</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Conservative</span>
                            <span class="font-medium text-amber-600">₹{{ number_format($forecast['conservative']) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Likely</span>
                            <span class="font-medium text-blue-600">₹{{ number_format($forecast['likely']) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Optimistic</span>
                            <span class="font-medium text-green-600">₹{{ number_format($forecast['optimistic']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pipeline Funnel</h3>
                    @if(count($pipelineFunnel) > 0)
                        <div class="space-y-2">
                            @foreach($pipelineFunnel as $stage => $count)
                                <div class="flex items-center justify-between py-1 text-sm">
                                    <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $stage) }}</span>
                                    <span class="font-medium text-gray-900">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">No deals in pipeline.</p>
                    @endif
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tasks</h3>
                        <a href="#" class="text-sm text-terracotta-500 hover:underline">View all</a>
                    </div>
                    @forelse($tasks as $task)
                        <div class="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                            <div>
                                <p class="font-medium text-gray-900">{{ $task->title }}</p>
                                <p class="text-xs text-gray-500">{{ $task->due_date?->format('d M') ?? 'No due date' }}</p>
                            </div>
                            <span class="badge badge-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'info') }} text-xs">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">No pending tasks.</p>
                    @endforelse
                </div>
            </div>

            <div class="card p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">AI Recommendations</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($recommendations as $rec)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                            <h4 class="font-medium text-gray-900">{{ $rec['event']->title }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $rec['event']->city ?? 'N/A' }} • Score: {{ $rec['score'] }}/100</p>
                            @if(!empty($rec['reasons']))
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($rec['reasons'] as $reason)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $reason }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm col-span-3">No recommendations available.</p>
                    @endforelse
                </div>
            </div>

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                @forelse($activities as $log)
                    <div class="flex items-center gap-3 py-2 border-b border-gray-50 text-sm">
                        <span class="text-xs text-gray-400 w-20">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span>
                        <span class="text-gray-600">{{ $log->event }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
