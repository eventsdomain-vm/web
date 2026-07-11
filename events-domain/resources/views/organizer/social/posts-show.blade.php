<x-app-layout>
    <x-slot name="title">Post Details - EventsDomain</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route($rp . '.posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition mb-2 inline-block">
                        ← Back to Posts
                    </a>
                    <h1 class="text-xl font-bold text-gray-900">Post #{{ $post->id }}</h1>
                </div>
                <div class="flex items-center gap-3">
                    @if($post->status === 'draft')
                        <form action="{{ route($rp . '.posts.publish', $post) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Publish Now
                            </button>
                        </form>
                    @endif

                    @if($post->status === 'draft')
                        <form action="{{ route($rp . '.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Event Info Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Event</h2>
                <div class="flex items-center gap-4">
                    @if($post->event->cover_image)
                        <img src="{{ $post->event->cover_image }}" alt="" class="w-16 h-16 rounded-xl object-cover">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-terracotta-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-terracotta-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $post->event->title }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $post->event->start_date->format('M d, Y') }} — {{ $post->event->end_date->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Post Details --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
                {{-- Status & Platforms --}}
                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status</span>
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
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusStyles[$post->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $post->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="h-8 w-px bg-gray-200"></div>

                    <div>
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Platforms</span>
                        <div class="flex flex-wrap gap-1.5 mt-1">
                            @foreach($post->platforms as $platform)
                                @php
                                    $platformStyles = [
                                        'facebook' => ['#1877F2', 'bg-blue-100 text-blue-700'],
                                        'linkedin' => ['#0A66C2', 'bg-sky-100 text-sky-700'],
                                        'instagram' => ['#E4405F', 'bg-pink-100 text-pink-700'],
                                        'youtube' => ['#FF0000', 'bg-red-100 text-red-700'],
                                    ];
                                    [$color, $badgeClass] = $platformStyles[$platform] ?? ['#6B7280', 'bg-gray-100 text-gray-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($platform) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    @if($post->scheduled_at)
                        <div class="h-8 w-px bg-gray-200"></div>
                        <div>
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Scheduled</span>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $post->scheduled_at->format('M d, Y g:i A') }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Content Per Platform --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Post Content</h3>
                    <div class="space-y-4">
                        @foreach($post->platforms as $platform)
                            @php
                                $platformStyles = [
                                    'facebook' => ['border-l-blue-500', 'text-blue-600', '#1877F2'],
                                    'linkedin' => ['border-l-sky-500', 'text-sky-600', '#0A66C2'],
                                    'instagram' => ['border-l-pink-500', 'text-pink-600', '#E4405F'],
                                    'youtube' => ['border-l-red-500', 'text-red-600', '#FF0000'],
                                ];
                                [$borderClass, $textClass, $color] = $platformStyles[$platform] ?? ['border-l-gray-300', 'text-gray-600', '#6B7280'];

                                $content = $post->content[$platform] ?? null;
                                $message = $content['message'] ?? $content['caption'] ?? $content['title'] ?? '';
                                $description = $content['description'] ?? '';
                                $link = $content['link'] ?? '';
                                $imageUrl = $content['image_url'] ?? '';
                            @endphp
                            <div class="border-l-4 {{ $borderClass }} pl-4 py-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-semibold text-sm {{ $textClass }}">{{ ucfirst($platform) }}</span>
                                </div>
                                @if($message)
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $message }}</p>
                                @endif
                                @if($description)
                                    <p class="text-sm text-gray-500 mt-1 whitespace-pre-wrap">{{ $description }}</p>
                                @endif
                                @if($link)
                                    <p class="text-xs text-gray-400 mt-1 truncate">Link: {{ $link }}</p>
                                @endif
                                @if($imageUrl)
                                    <p class="text-xs text-gray-400 mt-1 truncate">Image: {{ $imageUrl }}</p>
                                @endif
                                @if(!$message && !$description && !$link && !$imageUrl)
                                    <p class="text-sm text-gray-400 italic">No content defined</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Platform Logs --}}
            @if($post->logs->count())
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Publishing History</h2>
                    <div class="space-y-4">
                        @foreach($post->logs as $log)
                            @php
                                $logStatusStyles = [
                                    'published' => 'bg-emerald-100 text-emerald-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                                $platformStyles = [
                                    'facebook' => ['text-blue-600', '#1877F2'],
                                    'linkedin' => ['text-sky-600', '#0A66C2'],
                                    'instagram' => ['text-pink-600', '#E4405F'],
                                    'youtube' => ['text-red-600', '#FF0000'],
                                ];
                                [$textClass, $color] = $platformStyles[$log->platform] ?? ['text-gray-600', '#6B7280'];
                            @endphp
                            <div class="border border-gray-100 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="font-semibold text-sm {{ $textClass }}">{{ ucfirst($log->platform) }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $logStatusStyles[$log->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $log->created_at->format('M d, Y g:i A') }}</span>
                                </div>

                                @if($log->post_url)
                                    <p class="text-xs text-gray-500 mb-2">
                                        URL: <a href="{{ $log->post_url }}" target="_blank" class="text-terracotta-500 hover:underline">{{ $log->post_url }}</a>
                                    </p>
                                @endif

                                @if($log->error_message)
                                    <div class="bg-red-50 rounded-lg p-3 mt-2">
                                        <p class="text-xs text-red-600">{{ $log->error_message }}</p>
                                    </div>
                                @endif

                                {{-- Engagement Metrics --}}
                                @php
                                    $impressions = $log->reach_impressions ?? 0;
                                    $likes = $log->engagement_likes ?? 0;
                                    $comments = $log->engagement_comments ?? 0;
                                    $shares = $log->engagement_shares ?? 0;
                                    $hasMetrics = $impressions || $likes || $comments || $shares;
                                @endphp
                                @if($hasMetrics)
                                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-50">
                                        @if($impressions)
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900">{{ number_format($impressions) }}</p>
                                                <p class="text-xs text-gray-400">Impressions</p>
                                            </div>
                                        @endif
                                        @if($likes)
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900">{{ number_format($likes) }}</p>
                                                <p class="text-xs text-gray-400">Likes</p>
                                            </div>
                                        @endif
                                        @if($comments)
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900">{{ number_format($comments) }}</p>
                                                <p class="text-xs text-gray-400">Comments</p>
                                            </div>
                                        @endif
                                        @if($shares)
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900">{{ number_format($shares) }}</p>
                                                <p class="text-xs text-gray-400">Shares</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
