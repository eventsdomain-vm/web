<x-app-layout>
    <x-slot name="title">Analytics - EventsDomain</x-slot>

    <div class="space-y-6">
        {{-- Filters --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full sm:w-auto">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Event</label>
                    <select class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-sm">
                        <option>All Events</option>
                    </select>
                </div>
                <div class="flex-1 w-full sm:w-auto">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Date Range</label>
                    <select class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-sm">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>This Year</option>
                    </select>
                </div>
                <button class="w-full sm:w-auto px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </button>
            </div>
        </div>

        {{-- Engagement Funnel --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Engagement Funnel</h2>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Views</span>
                        <span class="font-medium text-gray-900">1,284</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#F26C4F] h-2.5 rounded-full" style="width:100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Enquiries</span>
                        <span class="font-medium text-gray-900">48</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#F26C4F] h-2.5 rounded-full" style="width:48%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Sponsorships</span>
                        <span class="font-medium text-gray-900">12</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#F26C4F] h-2.5 rounded-full" style="width:12%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Completed</span>
                        <span class="font-medium text-gray-900">8</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#F26C4F] h-2.5 rounded-full" style="width:8%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $kpis = [
                    ['label' => 'Total Posts', 'value' => number_format($socialStats['total_posts'] ?? 0), 'change' => '', 'color' => 'text-sky-500'],
                    ['label' => 'Published', 'value' => number_format($socialStats['published_posts'] ?? 0), 'change' => '', 'color' => 'text-emerald-500'],
                    ['label' => 'Scheduled', 'value' => number_format($socialStats['scheduled_posts'] ?? 0), 'change' => '', 'color' => 'text-blue-500'],
                    ['label' => 'Total Impressions', 'value' => number_format($platformStats->sum('total_impressions')), 'change' => '', 'color' => 'text-amber-500'],
                    ['label' => 'Total Engagement', 'value' => number_format($platformStats->sum('total_likes') + $platformStats->sum('total_comments') + $platformStats->sum('total_shares')), 'change' => '', 'color' => 'text-rose-500'],
                ];
            @endphp
            @foreach($kpis as $kpi)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                    <p class="text-xs text-gray-500 font-medium">{{ $kpi['label'] }}</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ $kpi['value'] }}</p>
                    <p class="text-xs font-medium {{ $kpi['color'] }} mt-1">{{ $kpi['change'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-5">
                <nav class="flex gap-6 -mb-px">
                    @php $tabs = ['Overview', 'Audience', 'Engagement', 'Events']; @endphp
                    @foreach($tabs as $i => $tab)
                        <button class="py-4 text-sm font-medium border-b-2 transition {{ $i === 0 ? 'border-[#F26C4F] text-[#F26C4F]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $tab }}
                        </button>
                    @endforeach
                </nav>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-center h-48 text-gray-400 text-sm">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <p>Chart will render here</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Views Over Time + Device / Traffic --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Views Over Time --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Views Over Time</h2>
                <div class="flex items-center justify-center h-48 text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                        <p>Line chart placeholder</p>
                    </div>
                </div>
            </div>

            {{-- Device Breakdown --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Device Breakdown</h2>
                <div class="space-y-4">
                    @php
                        $devices = [
                            ['name' => 'Desktop', 'pct' => 52, 'color' => '#F26C4F'],
                            ['name' => 'Mobile', 'pct' => 35, 'color' => '#4A6362'],
                            ['name' => 'Tablet', 'pct' => 13, 'color' => '#FFB0A1'],
                        ];
                    @endphp
                    @foreach($devices as $d)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ $d['name'] }}</span>
                                <span class="font-medium text-gray-900">{{ $d['pct'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="h-2 rounded-full" style="width:{{ $d['pct'] }}%;background-color:{{ $d['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Traffic Sources --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-semibold text-gray-900 mb-4">Traffic Sources</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $sources = [
                        ['name' => 'Direct', 'value' => '38%', 'color' => '#F26C4F'],
                        ['name' => 'Search', 'value' => '28%', 'color' => '#4A6362'],
                        ['name' => 'Social', 'value' => '20%', 'color' => '#FFB0A1'],
                        ['name' => 'Referral', 'value' => '14%', 'color' => '#9E3A26'],
                    ];
                @endphp
                @foreach($sources as $s)
                    <div class="text-center p-4 rounded-lg bg-gray-50">
                        <div class="w-3 h-3 rounded-full mx-auto mb-2" style="background-color:{{ $s['color'] }}"></div>
                        <p class="text-lg font-bold text-gray-900">{{ $s['value'] }}</p>
                        <p class="text-xs text-gray-500">{{ $s['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Social Media Reach --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-900">Social Media Reach</h2>
                <a href="{{ route('organizer.posts.index') }}" class="text-sm text-[#F26C4F] hover:text-[#E35336] font-medium">View All Posts</a>
            </div>

            @if($platformStats->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    <p class="text-sm">No social posts published yet</p>
                    <p class="text-xs text-gray-400 mt-1">Share your events on social media to see reach data here</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    @php
                        $platformColors = [
                            'facebook' => ['bg' => '#1877F220', 'text' => '#1877F2', 'name' => 'Facebook'],
                            'linkedin' => ['bg' => '#0A66C220', 'text' => '#0A66C2', 'name' => 'LinkedIn'],
                            'instagram' => ['bg' => '#E4405F20', 'text' => '#E4405F', 'name' => 'Instagram'],
                            'youtube' => ['bg' => '#FF000020', 'text' => '#FF0000', 'name' => 'YouTube'],
                        ];
                    @endphp
                    @foreach($platformStats as $stat)
                        @php $pc = $platformColors[$stat->platform] ?? ['bg' => '#6B728020', 'text' => '#6B7280', 'name' => ucfirst($stat->platform)]; @endphp
                        <div class="rounded-xl p-4" style="background-color: {{ $pc['bg'] }}">
                            <p class="text-xs font-medium" style="color: {{ $pc['text'] }}">{{ $pc['name'] }}</p>
                            <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($stat->total_impressions) }}</p>
                            <p class="text-xs text-gray-500">impressions</p>
                            <div class="flex gap-3 mt-2 text-xs text-gray-500">
                                <span>{{ number_format($stat->total_likes) }} likes</span>
                                <span>{{ number_format($stat->total_comments) }} comments</span>
                                <span>{{ number_format($stat->total_shares) }} shares</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Engagement Summary --}}
                <div class="border-t border-gray-100 pt-4">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($platformStats->sum('total_reach')) }}</p>
                            <p class="text-xs text-gray-500">Total Reach</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($platformStats->sum('total_impressions')) }}</p>
                            <p class="text-xs text-gray-500">Total Impressions</p>
                        </div>
                        <div>
                            @php
                                $totalEng = $platformStats->sum('total_likes') + $platformStats->sum('total_comments') + $platformStats->sum('total_shares');
                                $totalPosts = $platformStats->sum('total_posts');
                                $avgEng = $totalPosts > 0 ? round($totalEng / $totalPosts, 1) : 0;
                            @endphp
                            <p class="text-2xl font-bold text-gray-900">{{ $avgEng }}</p>
                            <p class="text-xs text-gray-500">Avg. Engagement/Post</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
