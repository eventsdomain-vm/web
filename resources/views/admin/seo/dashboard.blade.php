<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">SEO Dashboard</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Indexed Pages</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $seoStats['indexed_pages'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Missing Meta</p>
                        <p class="text-2xl font-bold text-red-600">{{ $seoStats['missing_meta'] }}</p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Avg SEO Score</p>
                        <p class="text-2xl font-bold text-green-600">{{ $seoStats['average_seo_score'] }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sitemap</p>
                        <p class="text-2xl font-bold text-gray-900 capitalize">{{ $seoStats['sitemap_status'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Issues</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Pages without Title</span>
                        <span class="text-sm font-medium {{ $seoStats['pages_without_title'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['pages_without_title'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Missing Alt Images</span>
                        <span class="text-sm font-medium {{ $seoStats['missing_alt_images'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['missing_alt_images'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Missing Canonical URLs</span>
                        <span class="text-sm font-medium {{ $seoStats['pages_without_canonical'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['pages_without_canonical'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Duplicate Titles</span>
                        <span class="text-sm font-medium {{ $seoStats['duplicate_titles'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['duplicate_titles'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Duplicate Descriptions</span>
                        <span class="text-sm font-medium {{ $seoStats['duplicate_descriptions'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['duplicate_descriptions'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Broken Internal Links</span>
                        <span class="text-sm font-medium {{ $seoStats['broken_internal_links'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['broken_internal_links'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">404 Pages</span>
                        <span class="text-sm font-medium {{ $seoStats['status_404_pages'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $seoStats['status_404_pages'] }}</span>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Robots.txt</span>
                        <span class="text-sm font-medium capitalize text-green-600">{{ $seoStats['robots_status'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Google Search Console</span>
                        <span class="text-sm font-medium capitalize {{ $seoStats['google_search_console_status'] === 'connected' ? 'text-green-600' : 'text-yellow-600' }}">{{ $seoStats['google_search_console_status'] }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">30-Day Trend</span>
                        <span class="flex items-center gap-1 text-sm font-medium {{ $seoTrends['trend_direction'] === 'up' ? 'text-green-600' : 'text-red-600' }}">
                            @if($seoTrends['trend_direction'] === 'up')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                            @endif
                            {{ $seoTrends['trend_direction'] === 'up' ? 'Improving' : 'Declining' }}
                            ({{ $seoTrends['current_score'] }})
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(count($recentSeoIssues) > 0)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent SEO Issues</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Page</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentSeoIssues as $issue)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $issue['model_title'] }}</td>
                            <td class="px-4 py-3 text-sm {{ $issue['title'] === 'Missing' ? 'text-red-600' : 'text-gray-600' }}">{{ $issue['title'] }}</td>
                            <td class="px-4 py-3 text-sm {{ $issue['description'] === 'Missing' ? 'text-red-600' : 'text-gray-600' }}">{{ Str::limit($issue['description'], 50) }}</td>
                            <td class="px-4 py-3 text-sm">{{ $issue['score'] ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $issue['updated_at']->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
