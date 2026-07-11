<x-app-layout>
    <x-slot name="title">Create CMS Page - Admin</x-slot>

    <div class="space-y-6 max-w-3xl">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.cms') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Create CMS Page</h1>
        </div>

        <form action="{{ route('admin.cms.store') }}" method="POST" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent"
                        placeholder="e.g. About Us">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ tab: 'source' }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
                    <div class="flex gap-0 mb-2 border border-gray-300 rounded-lg overflow-hidden w-fit">
                        <button type="button" @click="tab = 'source'" :class="tab === 'source' ? 'bg-[#E35336] text-white' : 'bg-white text-gray-600 hover:bg-gray-50'" class="px-4 py-1.5 text-xs font-medium transition">Source</button>
                        <button type="button" @click="tab = 'preview'" :class="tab === 'preview' ? 'bg-[#E35336] text-white' : 'bg-white text-gray-600 hover:bg-gray-50'" class="px-4 py-1.5 text-xs font-medium transition">Preview</button>
                    </div>
                    <div x-show="tab === 'source'" x-cloak>
                        <textarea x-ref="source" name="content" id="content" rows="16" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-[#E35336] focus:border-transparent"
                            placeholder="HTML content for this page...">{{ old('content') }}</textarea>
                    </div>
                    <div x-show="tab === 'preview'" x-cloak class="border border-gray-200 rounded-lg p-4 min-h-[300px] prose prose-sm max-w-none bg-white overflow-auto">
                        <div x-html="$refs.source?.value || ''"></div>
                    </div>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent"
                        placeholder="SEO title">
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent"
                        placeholder="SEO description">{{ old('meta_description') }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" id="is_published"
                        {{ old('is_published') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]">
                    <label for="is_published" class="text-sm text-gray-700">Published</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.cms') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">Create Page</button>
            </div>
        </form>
    </div>
</x-app-layout>
