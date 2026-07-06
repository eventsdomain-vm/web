<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">SEO Settings</h2>
    </x-slot>

    <div class="container-page">
        <form method="POST" action="{{ route('admin.seo.settings.store') }}" class="space-y-6">
            @csrf

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Global Meta Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" name="global[site_name]" value="{{ old('global.site_name', $globalSettings->get('global')?->firstWhere('key', 'site_name')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Tagline</label>
                        <input type="text" name="global[site_tagline]" value="{{ old('global.site_tagline', $globalSettings->get('global')?->firstWhere('key', 'site_tagline')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="global[meta_description]" rows="2" class="input-field w-full">{{ old('global.meta_description', $globalSettings->get('global')?->firstWhere('key', 'meta_description')?->value ?? '') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input type="text" name="global[meta_keywords]" value="{{ old('global.meta_keywords', $globalSettings->get('global')?->firstWhere('key', 'meta_keywords')?->value ?? '') }}" class="input-field w-full" placeholder="keyword1, keyword2, keyword3">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Author</label>
                        <input type="text" name="global[default_author]" value="{{ old('global.default_author', $globalSettings->get('global')?->firstWhere('key', 'default_author')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher Name</label>
                        <input type="text" name="global[publisher_name]" value="{{ old('global.publisher_name', $globalSettings->get('global')?->firstWhere('key', 'publisher_name')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">OG Image URL</label>
                        <input type="text" name="global[og_image]" value="{{ old('global.og_image', $globalSettings->get('global')?->firstWhere('key', 'og_image')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter Card Image URL</label>
                        <input type="text" name="global[twitter_card_image]" value="{{ old('global.twitter_card_image', $globalSettings->get('global')?->firstWhere('key', 'twitter_card_image')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Language</label>
                        <input type="text" name="global[default_language]" value="{{ old('global.default_language', $globalSettings->get('global')?->firstWhere('key', 'default_language')?->value ?? '') }}" class="input-field w-full" maxlength="2" placeholder="en">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Country</label>
                        <input type="text" name="global[default_country]" value="{{ old('global.default_country', $globalSettings->get('global')?->firstWhere('key', 'default_country')?->value ?? '') }}" class="input-field w-full" maxlength="2" placeholder="US">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Theme Color</label>
                        <input type="text" name="global[theme_color]" value="{{ old('global.theme_color', $globalSettings->get('global')?->firstWhere('key', 'theme_color')?->value ?? '') }}" class="input-field w-full" placeholder="#E35336">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Favicon URL</label>
                        <input type="text" name="global[favicon]" value="{{ old('global.favicon', $globalSettings->get('global')?->firstWhere('key', 'favicon')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Google Verification Code</label>
                        <input type="text" name="global[google_verification_code]" value="{{ old('global.google_verification_code', $globalSettings->get('global')?->firstWhere('key', 'google_verification_code')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bing Verification Code</label>
                        <input type="text" name="global[bing_verification_code]" value="{{ old('global.bing_verification_code', $globalSettings->get('global')?->firstWhere('key', 'bing_verification_code')?->value ?? '') }}" class="input-field w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yandex Verification Code</label>
                        <input type="text" name="global[yandex_verification_code]" value="{{ old('global.yandex_verification_code', $globalSettings->get('global')?->firstWhere('key', 'yandex_verification_code')?->value ?? '') }}" class="input-field w-full">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</x-app-layout>
