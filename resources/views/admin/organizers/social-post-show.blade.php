<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Social Post Details</h2>
            <a href="{{ route('admin.social.posts') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $post->event->title ?? 'N/A' }}</h1>
                        <p class="text-gray-600">By: {{ $post->user->name ?? 'N/A' }}</p>
                    </div>
                    <span class="badge badge-{{ $post->status === 'published' ? 'success' : ($post->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($post->status) }}</span>
                </div>
            </div>
            <div class="card p-6 mb-6">
                <h3 class="font-semibold mb-3">Platforms</h3>
                <div class="flex gap-2">@foreach($post->platforms ?? [] as $p) <span class="badge badge-info">{{ ucfirst($p) }}</span> @endforeach</div>
            </div>
            @if($post->content)
            <div class="card p-6 mb-6">
                <h3 class="font-semibold mb-3">Content</h3>
                <pre class="text-sm bg-gray-50 p-4 rounded whitespace-pre-wrap">{{ json_encode($post->content, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
            @if($post->logs && $post->logs->count())
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="font-semibold">Publish Logs</h3></div>
                <div class="divide-y">
                    @foreach($post->logs as $log)
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <span>{{ $log->platform }} - <span class="badge badge-{{ $log->status === 'success' ? 'success' : 'danger' }}">{{ $log->status }}</span></span>
                        <span class="text-gray-500">{{ $log->published_at?->format('M d, Y H:i') ?? ($log->error_message ?? '') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
