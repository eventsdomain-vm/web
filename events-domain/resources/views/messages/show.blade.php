<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <img src="{{ $otherParticipant->avatar_url }}" alt="{{ $otherParticipant->name }}" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h2 class="font-semibold text-gray-800 leading-tight">{{ $otherParticipant->name }}</h2>
                    <p class="text-xs text-gray-500">Online</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-[calc(100vh-16rem)]">
        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
            @forelse($conversation->messages as $message)
                @if($message->sender_id === auth()->id())
                    <!-- Sent Message -->
                    <div class="flex justify-end">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="bg-terracotta-500 text-white rounded-2xl rounded-br-none px-4 py-3">
                                <p class="text-sm">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">{{ $message->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                @else
                    <!-- Received Message -->
                    <div class="flex justify-start">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="bg-gray-100 text-gray-900 rounded-2xl rounded-bl-none px-4 py-3">
                                <p class="text-sm">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                @endif
            @empty
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <img src="{{ $otherParticipant->avatar_url }}" alt="{{ $otherParticipant->name }}" class="w-16 h-16 rounded-full object-cover mx-auto mb-3">
                        <p class="text-gray-500">Start a conversation with {{ $otherParticipant->name }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 bg-white p-4">
            <form action="{{ route('messages.store', $conversation) }}" method="POST" id="message-form" class="flex items-center gap-3">
                @csrf
                <div class="flex-1">
                    <input type="text" name="content" id="message-input" class="input-field" placeholder="Type a message..." required autocomplete="off">
                </div>
                <button type="submit" class="btn-primary px-4 py-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            const form = document.getElementById('message-form');
            const input = document.getElementById('message-input');

            // Scroll to bottom
            container.scrollTop = container.scrollHeight;

            // Auto-scroll on new messages
            const observer = new MutationObserver(function() {
                container.scrollTop = container.scrollHeight;
            });

            observer.observe(container, { childList: true });

            // Focus input
            input.focus();
        });
    </script>
</x-app-layout>
