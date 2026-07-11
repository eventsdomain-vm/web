<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('sponsor.messages.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Conversation with {{ $user->name }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Messages</h3>
        </div>
        <div class="max-h-[400px] overflow-y-auto p-6 space-y-4">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] {{ $message->sender_id === auth()->id() ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg px-4 py-2.5">
                        @if($message->subject)
                            <p class="text-sm font-semibold {{ $message->sender_id === auth()->id() ? 'text-white/90' : 'text-gray-600' }}">{{ $message->subject }}</p>
                        @endif
                        <p class="text-sm whitespace-pre-wrap">{{ $message->body }}</p>
                        <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-white/70' : 'text-gray-400' }} mt-1 text-right">{{ $message->created_at->format('M d, H:i') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 text-sm py-8">No messages in this conversation yet.</div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            <form action="{{ route('sponsor.messages.store', $user) }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <input type="text" name="subject" placeholder="Subject (optional)" class="w-full rounded-lg border-gray-200 text-sm" maxlength="255">
                    <textarea name="body" rows="3" placeholder="Type your message..." class="w-full rounded-lg border-gray-200 text-sm" required></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary text-sm px-4 py-2">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
