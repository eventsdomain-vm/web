<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Message Center</h2>
            @if($unreadCount > 0)
                <span class="badge badge-danger text-sm">{{ $unreadCount }} unread</span>
            @endif
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card lg:col-span-1">
            <div class="px-4 py-3 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Conversations</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                @forelse($conversations as $conv)
                    <a href="{{ route('sponsor.messages.show', $conv->user) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition {{ $conv->unread_count > 0 ? 'bg-blue-50/50' : '' }}">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center shrink-0">
                            <span class="text-sm font-medium text-gray-600">{{ strtoupper(substr($conv->user->name, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-sm text-gray-900 truncate">{{ $conv->user->name }}</h4>
                                @if($conv->last_message)
                                    <span class="text-xs text-gray-400">{{ $conv->last_message->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $conv->last_message?->body ?? 'No messages yet' }}</p>
                        </div>
                        @if($conv->unread_count > 0)
                            <span class="w-5 h-5 rounded-full bg-terracotta-500 text-white text-xs flex items-center justify-center">{{ $conv->unread_count }}</span>
                        @endif
                    </a>
                @empty
                    <div class="px-4 py-8 text-center text-gray-500 text-sm">No conversations yet.</div>
                @endforelse
            </div>
        </div>

        <div class="card lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">All Messages</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                @forelse($messages as $message)
                    <div class="px-6 py-4 hover:bg-gray-50 transition {{ is_null($message->read_at) && $message->recipient_id === auth()->id() ? 'bg-blue-50/50' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-sm text-gray-900">{{ $message->sender->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                    @if(is_null($message->read_at) && $message->recipient_id === auth()->id())
                                        <span class="w-2 h-2 rounded-full bg-terracotta-500"></span>
                                    @endif
                                </div>
                                @if($message->subject)
                                    <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $message->subject }}</p>
                                @endif
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($message->body, 200) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No messages. Start a conversation with a team member or organizer.</div>
                @endforelse
            </div>
            <div class="px-6 py-3 border-t border-gray-100">
                @if(method_exists($messages, 'links')){{ $messages->links() }}@endif
            </div>
        </div>
    </div>
</x-app-layout>
