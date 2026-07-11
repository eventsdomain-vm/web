<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Robots.txt</h2>
    </x-slot>

    <div class="container-page">
        <form method="POST" action="{{ route('admin.seo.robots.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Robots Rules</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Allow</label>
                        <input type="text" name="allow" value="{{ old('allow', $robotsRules['allow'] ?? '/') }}" class="input-field w-full" placeholder="/">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Disallow</label>
                        <input type="text" name="disallow" value="{{ old('disallow', $robotsRules['disallow'] ?? '/admin/') }}" class="input-field w-full" placeholder="/admin/">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Crawl Delay (seconds)</label>
                        <input type="number" name="crawl_delay" value="{{ old('crawl_delay', $robotsRules['crawl_delay'] ?? 0) }}" min="0" max="300" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sitemap URL</label>
                        <input type="url" name="sitemap_url" value="{{ old('sitemap_url', $robotsRules['sitemap_url'] ?? '') }}" class="input-field w-full" placeholder="https://example.com/sitemap.xml">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Robots.txt</button>
            </div>
        </form>
    </div>
</x-app-layout>
