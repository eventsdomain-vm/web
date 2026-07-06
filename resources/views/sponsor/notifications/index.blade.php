<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
            <div class="flex items-center gap-2">
                @if($unreadCount > 0)
                    <span class="badge badge-danger text-sm">{{ $unreadCount }} unread</span>
                    <form action="{{ route('sponsor.notifications.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-outline text-sm px-3 py-1.5">Mark All Read</button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-2">
        @forelse($notifications as $notification)
            <div class="card hover:shadow-sm transition {{ is_null($notification->read_at) ? 'border-l-4 border-l-terracotta-500' : '' }}">
                <div class="px-6 py-4 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full {{ is_null($notification->read_at) ? 'bg-terracotta-100' : 'bg-gray-100' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ is_null($notification->read_at) ? 'text-terracotta-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-sm text-gray-900">{{ $notification->title }}</h4>
                            <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        @if($notification->body)
                            <p class="text-sm text-gray-600 mt-0.5">{{ $notification->body }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-2">
                            @if($notification->action_url)
                                <a href="{{ route('sponsor.notifications.read', $notification) }}" class="text-xs text-terracotta-500 hover:underline font-medium">{{ $notification->action_label ?? 'View Details' }}</a>
                            @endif
                            @if(is_null($notification->read_at))
                                <a href="{{ route('sponsor.notifications.read', $notification) }}" class="text-xs text-gray-500 hover:underline">Mark read</a>
                            @endif
                            <a href="{{ route('sponsor.notifications.dismiss', $notification) }}" class="text-xs text-gray-400 hover:text-red-500 hover:underline">Dismiss</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <p class="text-gray-500">No notifications yet.</p>
                <p class="text-sm text-gray-400 mt-1">You will receive notifications for important updates and actions.</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
