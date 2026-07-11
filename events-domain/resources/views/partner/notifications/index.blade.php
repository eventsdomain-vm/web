<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
            <form method="POST" action="{{ route('partner.notifications.mark-all-read') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-terracotta-500 hover:underline">Mark all as read</button>
            </form>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="card p-4 flex items-start justify-between {{ $notification->read_at ? '' : 'border-l-4 border-terracotta-500 bg-terracotta-50/30' }}">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            @unless($notification->read_at)
                                <span class="w-2 h-2 bg-terracotta-500 rounded-full shrink-0"></span>
                            @endunless
                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? $notification->type }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $notification->data['body'] ?? 'No details' }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @unless($notification->read_at)
                            <form method="POST" action="{{ route('partner.notifications.mark-read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:underline">Mark read</button>
                            </form>
                        @endunless
                        <form method="POST" action="{{ route('partner.notifications.destroy', $notification->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Dismiss</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">No notifications yet.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
</x-app-layout>
