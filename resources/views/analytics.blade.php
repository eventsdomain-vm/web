<x-app-layout>
    <x-slot name="title">Analytics Dashboard - EventsDomain</x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.min.css">

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Analytics Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Track your event performance, audience reach, and engagement metrics</p>
            </div>
            <div class="flex gap-3">
                <select id="dateRange" class="rounded-lg border-gray-200 bg-white text-sm focus:border-[#E35336] focus:ring-1 focus:ring-[#E35336]">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                    <option value="365">This Year</option>
                </select>
                <button onclick="exportCSV()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </button>
            </div>
        </div>

        {{-- KPI Cards Row --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $totalEngagement = ($platformTotals['likes'] ?? 0) + ($platformTotals['comments'] ?? 0) + ($platformTotals['shares'] ?? 0);
                $totalPostsCount = $platformTotals['posts'] ?? 0;
                $avgEng = $totalPostsCount > 0 ? round($totalEngagement / $totalPostsCount, 1) : 0;

                $kpiCards = [
                    [
                        'label' => 'Total Views',
                        'value' => number_format($totalViews),
                        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>',
                        'bg' => 'bg-[#E35336]',
                    ],
                    [
                        'label' => 'Published Posts',
                        'value' => number_format($socialStats['published_posts'] ?? 0),
                        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        'bg' => 'bg-emerald-500',
                    ],
                    [
                        'label' => 'Total Reach',
                        'value' => number_format($platformTotals['reach'] ?? 0),
                        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                        'bg' => 'bg-blue-500',
                    ],
                    [
                        'label' => 'Total Engagement',
                        'value' => number_format($totalEngagement),
                        'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                        'bg' => 'bg-purple-500',
                    ],
                ];
            @endphp
            @foreach($kpiCards as $kpi)
                <div class="relative overflow-hidden bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $kpi['label'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $kpi['value'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-lg {{ $kpi['bg'] }} flex items-center justify-center text-white">
                            {!! $kpi['icon'] !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Charts Row 1: Traffic + Platform Performance --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Traffic Over Time --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Visitor Traffic</h2>
                    <span class="text-xs text-gray-400">Last 30 days</span>
                </div>
                <div style="height:260px">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            {{-- Platform Performance --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Platforms</h2>
                    <a href="{{ route('organizer.posts.index') }}" class="text-xs text-[#E35336] hover:underline font-medium">View All</a>
                </div>
                @if(empty($platformStats))
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <p class="text-sm">No posts yet</p>
                    </div>
                @else
                    @php
                        $platformColors = [
                            'facebook' => ['bg' => '#1877F220', 'text' => '#1877F2', 'name' => 'Facebook'],
                            'linkedin' => ['bg' => '#0A66C220', 'text' => '#0A66C2', 'name' => 'LinkedIn'],
                            'instagram' => ['bg' => '#E4405F20', 'text' => '#E4405F', 'name' => 'Instagram'],
                            'youtube' => ['bg' => '#FF000020', 'text' => '#FF0000', 'name' => 'YouTube'],
                        ];
                        $platformIcons = [
                            'facebook' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                            'linkedin' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="#0A66C2"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                            'instagram' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="#E4405F"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                        ];
                    @endphp
                    <div class="space-y-4">
                        @foreach($platformStats as $stat)
                            @php $pc = $platformColors[$stat->platform] ?? ['bg' => '#6B728020', 'text' => '#6B7280', 'name' => ucfirst($stat->platform)]; @endphp
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: {{ $pc['bg'] }}">
                                    {!! $platformIcons[$stat->platform] ?? '' !!}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $pc['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($stat->total_posts) }} posts</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">{{ number_format($stat->total_impressions) }}</p>
                                    <p class="text-xs text-gray-400">impressions</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2 text-center">
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ $avgEng }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Avg Eng/Post</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ number_format($platformTotals['reach'] ?? 0) }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Reach</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ number_format($platformTotals['impressions'] ?? 0) }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Impressions</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Charts Row 2: Device + Browser + Posts --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Device Breakdown --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Devices</h2>
                <div style="height:220px" class="flex items-center justify-center">
                    <canvas id="deviceChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @php
                        $deviceTotal = array_sum(array_column($deviceStats, 'count')) ?: 1;
                    @endphp
                    @foreach($deviceStats as $ds)
                        @php
                            $pct = round(($ds->count / $deviceTotal) * 100);
                            $colors = ['Mobile' => '#E35336', 'Desktop' => '#4A6362', 'Tablet' => '#FFB0A1'];
                        @endphp
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $colors[$ds->device] ?? '#9CA3AF' }}"></span>
                                <span class="text-gray-600">{{ $ds->device }}</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Browser Breakdown --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Browsers</h2>
                <div style="height:220px" class="flex items-center justify-center">
                    <canvas id="browserChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @php
                        $browserColors = ['#E35336', '#4A6362', '#FFB0A1', '#9E3A26', '#3B82F6', '#8B5CF6'];
                        $browserTotal = array_sum(array_column($browserStats, 'count')) ?: 1;
                    @endphp
                    @foreach($browserStats as $idx => $bs)
                        @php $pct = round(($bs->count / $browserTotal) * 100); @endphp
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $browserColors[$idx % count($browserColors)] }}"></span>
                                <span class="text-gray-600">{{ $bs->browser }}</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Posts Over Time --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Posts Activity</h2>
                <div style="height:220px">
                    <canvas id="postsChart"></canvas>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-3 text-center">
                    <div class="p-2 rounded-lg bg-emerald-50">
                        <p class="text-lg font-bold text-emerald-600">{{ number_format($socialStats['published_posts'] ?? 0) }}</p>
                        <p class="text-[10px] text-gray-500 uppercase">Published</p>
                    </div>
                    <div class="p-2 rounded-lg bg-blue-50">
                        <p class="text-lg font-bold text-blue-600">{{ number_format($socialStats['scheduled_posts'] ?? 0) }}</p>
                        <p class="text-[10px] text-gray-500 uppercase">Scheduled</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- India Geographic Demographics --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- India States --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-lg">IN</span>
                    <h2 class="font-bold text-gray-900">Visitors by Indian State</h2>
                </div>
                @if(empty($geoStats['states']))
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-sm">No visitor geo data yet</p>
                        <p class="text-xs text-gray-400 mt-1">Visitors will appear as they browse your events</p>
                    </div>
                @else
                    <div style="height:300px" class="mb-4">
                        <canvas id="indiaStatesChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                        @foreach(array_slice($geoStats['states'], 0, 15, true) as $state => $count)
                            <div class="flex items-center justify-between p-2 rounded bg-gray-50 text-sm">
                                <span class="text-gray-700 truncate">{{ $state }}</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- India Cities --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-lg">IN</span>
                    <h2 class="font-bold text-gray-900">Visitors by City</h2>
                </div>
                @if(empty($geoStats['cities']))
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <p class="text-sm">No city data yet</p>
                    </div>
                @else
                    <div style="height:300px" class="mb-4">
                        <canvas id="indiaCitiesChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                        @foreach(array_slice($geoStats['cities'], 0, 15, true) as $city => $count)
                            <div class="flex items-center justify-between p-2 rounded bg-gray-50 text-sm">
                                <span class="text-gray-700 truncate">{{ $city }}</span>
                                <span class="font-semibold text-gray-900 ml-2">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Zipcodes + Countries --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Zipcodes --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Top Zipcodes</h2>
                @if(empty($geoStats['zipcodes']))
                    <div class="text-center py-10 text-gray-400">
                        <p class="text-sm">No zipcode data yet</p>
                    </div>
                @else
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach(array_slice($geoStats['zipcodes'], 0, 20, true) as $zip => $count)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#E3533610] flex items-center justify-center text-[#E35336] text-xs font-bold">{{ $loop->iteration }}</div>
                                    <span class="text-sm font-medium text-gray-900">{{ $zip }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-600">{{ $count }} visitor{{ $count > 1 ? 's' : '' }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Global Countries --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Visitors by Country</h2>
                @if(empty($geoStats['countries']))
                    <div class="text-center py-10 text-gray-400">
                        <p class="text-sm">No country data yet</p>
                    </div>
                @else
                    <div style="height:220px" class="mb-4">
                        <canvas id="countriesChart"></canvas>
                    </div>
                    <div class="space-y-2 max-h-32 overflow-y-auto">
                        @foreach(array_slice($geoStats['countries'], 0, 10, true) as $country => $count)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $country }}</span>
                                <span class="font-semibold text-gray-900">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Top Events --}}
        @if($topEvents->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Top Events by Views</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Event</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Date</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topEvents as $evt)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $evt->title }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $statusColors = [
                                                'live' => 'bg-emerald-100 text-emerald-700',
                                                'approved' => 'bg-blue-100 text-blue-700',
                                                'draft' => 'bg-gray-100 text-gray-600',
                                                'completed' => 'bg-purple-100 text-purple-700',
                                            ];
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$evt->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($evt->status) }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-500">{{ $evt->start_date ? $evt->start_date->format('d M Y') : '-' }}</td>
                                    <td class="py-3 px-4 text-right font-bold text-gray-900">{{ number_format($evt->views_count) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ISP Breakdown --}}
        @if(!empty($geoStats['isps']))
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-4">Top ISPs</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(array_slice($geoStats['isps'], 0, 8, true) as $isp => $count)
                        <div class="p-3 rounded-lg bg-gray-50 text-center">
                            <p class="text-lg font-bold text-gray-900">{{ $count }}</p>
                            <p class="text-xs text-gray-500 truncate" title="{{ $isp }}">{{ substr($isp, 0, 20) }}{{ strlen($isp) > 20 ? '...' : '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartDefaults = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
        };

        // Traffic Over Time
        const trafficCtx = document.getElementById('trafficChart');
        if (trafficCtx) {
            const trafficData = {!! json_encode($trafficOverTime) !!};
            new Chart(trafficCtx, {
                type: 'line',
                data: {
                    labels: trafficData.map(d => d.date),
                    datasets: [{
                        label: 'Visitors',
                        data: trafficData.map(d => d.visitors),
                        borderColor: '#E35336',
                        backgroundColor: 'rgba(227,83,54,0.08)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 2,
                        pointHoverRadius: 6,
                        borderWidth: 2.5,
                    }]
                },
                options: {
                    ...chartDefaults,
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 7, font: { size: 11 } } },
                        y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { font: { size: 11 } } },
                    },
                    plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                }
            });
        }

        // Device Doughnut
        const deviceCtx = document.getElementById('deviceChart');
        if (deviceCtx) {
            const deviceData = {!! json_encode($deviceStats) !!};
            const deviceColors = { Mobile: '#E35336', Desktop: '#4A6362', Tablet: '#FFB0A1' };
            new Chart(deviceCtx, {
                type: 'doughnut',
                data: {
                    labels: deviceData.map(d => d.device),
                    datasets: [{ data: deviceData.map(d => d.count), backgroundColor: deviceData.map(d => deviceColors[d.device] || '#9CA3AF'), borderWidth: 0, cutout: '70%' }]
                },
                options: { ...chartDefaults, plugins: { legend: { display: false } } }
            });
        }

        // Browser Doughnut
        const browserCtx = document.getElementById('browserChart');
        if (browserCtx) {
            const browserData = {!! json_encode($browserStats) !!};
            const bColors = ['#E35336', '#4A6362', '#FFB0A1', '#9E3A26', '#3B82F6', '#8B5CF6'];
            new Chart(browserCtx, {
                type: 'doughnut',
                data: {
                    labels: browserData.map(d => d.browser),
                    datasets: [{ data: browserData.map(d => d.count), backgroundColor: browserData.map((_, i) => bColors[i % bColors.length]), borderWidth: 0, cutout: '70%' }]
                },
                options: { ...chartDefaults, plugins: { legend: { display: false } } }
            });
        }

        // Posts Bar
        const postsCtx = document.getElementById('postsChart');
        if (postsCtx) {
            const postsData = {!! json_encode($postsOverTime) !!};
            new Chart(postsCtx, {
                type: 'bar',
                data: {
                    labels: postsData.map(d => d.date),
                    datasets: [{
                        label: 'Posts',
                        data: postsData.map(d => d.total),
                        backgroundColor: '#E35336',
                        borderRadius: 6,
                        barThickness: 12,
                    }]
                },
                options: {
                    ...chartDefaults,
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 7, font: { size: 10 } } },
                        y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { stepSize: 1, font: { size: 10 } } },
                    },
                }
            });
        }

        // India States Bar
        const statesCtx = document.getElementById('indiaStatesChart');
        if (statesCtx) {
            const statesData = {!! json_encode(array_values($geoStats['states'] ?? [])) !!};
            const statesLabels = {!! json_encode(array_keys($geoStats['states'] ?? [])) !!};
            new Chart(statesCtx, {
                type: 'bar',
                data: {
                    labels: statesLabels,
                    datasets: [{ data: statesData, backgroundColor: '#E35336', borderRadius: 4, barThickness: 16 }]
                },
                options: {
                    ...chartDefaults,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { stepSize: 1 } },
                        y: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    },
                }
            });
        }

        // India Cities Bar
        const citiesCtx = document.getElementById('indiaCitiesChart');
        if (citiesCtx) {
            const citiesData = {!! json_encode(array_values($geoStats['cities'] ?? [])) !!};
            const citiesLabels = {!! json_encode(array_keys($geoStats['cities'] ?? [])) !!};
            new Chart(citiesCtx, {
                type: 'bar',
                data: {
                    labels: citiesLabels,
                    datasets: [{ data: citiesData, backgroundColor: '#4A6362', borderRadius: 4, barThickness: 16 }]
                },
                options: {
                    ...chartDefaults,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { stepSize: 1 } },
                        y: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    },
                }
            });
        }

        // Countries Horizontal Bar
        const countriesCtx = document.getElementById('countriesChart');
        if (countriesCtx) {
            const countriesData = {!! json_encode(array_values($geoStats['countries'] ?? [])) !!};
            const countriesLabels = {!! json_encode(array_keys($geoStats['countries'] ?? [])) !!};
            new Chart(countriesCtx, {
                type: 'bar',
                data: {
                    labels: countriesLabels,
                    datasets: [{ data: countriesData, backgroundColor: '#E35336', borderRadius: 4, barThickness: 18 }]
                },
                options: {
                    ...chartDefaults,
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { stepSize: 1 } },
                        y: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    },
                }
            });
        }
    });

    function exportCSV() {
        const table = document.querySelector('table');
        if (!table) { alert('No data to export'); return; }
        let csv = [];
        const rows = table.querySelectorAll('tr');
        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            const rowData = Array.from(cols).map(col => '"' + col.innerText.replace(/"/g, '""') + '"');
            csv.push(rowData.join(','));
        });
        const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = 'analytics-export.csv'; a.click();
        URL.revokeObjectURL(url);
    }
    </script>
</x-app-layout>
