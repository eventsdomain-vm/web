<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Social Posts') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    <input type="text" name="search" placeholder="Search event..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platforms</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled At</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($posts as $post)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $post->event->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $post->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-1">@foreach($post->platforms ?? [] as $p) <span class="badge badge-info text-xs">{{ ucfirst($p) }}</span> @endforeach</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm"><span class="badge badge-{{ $post->status === 'published' ? 'success' : ($post->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($post->status) }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $post->scheduled_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.social.posts.show', $post) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No posts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $posts->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
