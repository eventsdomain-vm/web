<x-app-layout>
    <x-slot name="title">CMS Pages - Admin</x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">CMS Pages</h1>
            <a href="{{ route('admin.cms.create') }}"
                class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                + Create Page
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $page->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $page->slug }}</td>
                            <td class="px-6 py-4">
                                @if($page->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $page->updated_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.cms.edit', $page) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                                    <form action="{{ route('admin.cms.destroy', $page) }}" method="POST"
                                        onsubmit="return confirm('Delete this page?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                No CMS pages yet. Click "Create Page" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($pages->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
