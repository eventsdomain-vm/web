<x-app-layout>
    <x-slot name="title">Social Posts - EventsDomain</x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-r from-terracotta-500 to-orange-500 p-2.5 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Social Posts</h1>
                        <p class="text-sm text-gray-500">Manage and track your social media posts.</p>
                    </div>
                </div>
                <a href="{{ route($rp . '.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                    ← Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-emerald-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Posts Table --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                @if($posts->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Event</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Platforms</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Status</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Scheduled</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Created</th>
                                    <th class="text-right px-6 py-3 font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($posts as $post)
                                    <tr class="hover:bg-gray-50/50 transition cursor-pointer" onclick="window.location='{{ route($rp . '.posts.show', $post) }}'">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($post->event->cover_image)
                                                    <img src="{{ $post->event->cover_image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                                @else
                                                    <div class="w-10 h-10 rounded-lg bg-terracotta-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <p class="font-medium text-gray-900 truncate">{{ $post->event->title ?? 'Deleted Event' }}</p>
                                                    <p class="text-xs text-gray-400 truncate">Post #{{ $post->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($post->platforms as $platform)
                                                    @php
                                                        $colors = [
                                                            'facebook' => ['#1877F2', 'bg-blue-100 text-blue-700'],
                                                            'linkedin' => ['#0A66C2', 'bg-sky-100 text-sky-700'],
                                                            'instagram' => ['#E4405F', 'bg-pink-100 text-pink-700'],
                                                            'youtube' => ['#FF0000', 'bg-red-100 text-red-700'],
                                                        ];
                                                        [$color, $badgeClass] = $colors[$platform] ?? ['#6B7280', 'bg-gray-100 text-gray-700'];
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $badgeClass }}">
                                                        {{ ucfirst($platform) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusStyles = [
                                                    'draft' => 'bg-gray-100 text-gray-700',
                                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                                    'publishing' => 'bg-yellow-100 text-yellow-700',
                                                    'published' => 'bg-emerald-100 text-emerald-700',
                                                    'partial' => 'bg-orange-100 text-orange-700',
                                                    'failed' => 'bg-red-100 text-red-700',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusStyles[$post->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ $post->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ $post->scheduled_at ? $post->scheduled_at->format('M d, Y g:i A') : '—' }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route($rp . '.posts.show', $post) }}" class="text-terracotta-500 hover:text-terracotta-600 font-medium text-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($posts->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">No social posts yet</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                            Create your first social post from an event page to start sharing across platforms.
                        </p>
                        <a href="{{ route($rp . '.dashboard') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-terracotta-500 text-white text-sm font-medium rounded-lg hover:bg-terracotta-600 transition">
                            Go to Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
