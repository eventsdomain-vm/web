<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sitemap</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.seo.sitemap.generate') }}" class="btn-primary text-sm">Generate</a>
                <a href="{{ route('admin.seo.sitemap.download') }}" class="btn-secondary text-sm">Download</a>
            </div>
        </div>
    </x-slot>

    <div class="card p-6">
        @if(count($sitemapPaths) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Key</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($sitemapPaths as $key => $url)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $key }}</td>
                            <td class="px-4 py-3 text-sm text-blue-600 break-all">{{ $url }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No sitemap paths available. Click "Generate" to create one.</p>
        @endif
    </div>
</x-app-layout>
