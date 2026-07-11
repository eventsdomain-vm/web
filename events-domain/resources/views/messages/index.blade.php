<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            <div class="card overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @forelse($conversations as $conversation)
                        @php
                            $otherParticipant = $conversation->participants
                                ->where('user_id', '!=', auth()->id())
                                ->first()
                                ->user;
                            $lastMessage = $conversation->messages->first();
                        @endphp
                        <a href="{{ route('messages.show', $conversation) }}" class="block hover:bg-gray-50 transition">
                            <div class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ $otherParticipant->avatar_url }}" alt="{{ $otherParticipant->name }}" class="w-12 h-12 rounded-full object-cover">
                                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-gray-900 truncate">{{ $otherParticipant->name }}</h3>
                                            @if($lastMessage)
                                                <span class="text-xs text-gray-500">{{ $lastMessage->created_at->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                        @if($lastMessage)
                                            <p class="text-sm text-gray-500 truncate">{{ $lastMessage->content }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 italic">No messages yet</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No conversations yet</h3>
                            <p class="text-gray-500 mb-4">Start a conversation with an event organizer, sponsor, or partner.</p>
                            <a href="{{ route('events.index') }}" class="btn-primary inline-flex items-center">
                                Browse Events
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
