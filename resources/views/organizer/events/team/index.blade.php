<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Team: {{ $event->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('organizer.events.team.create', $event) }}" class="btn-primary text-sm">+ Add Member</a>
                <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Event</a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-6 md:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($team as $member)
                <div class="border border-gray-200 rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-terracotta-100 rounded-full flex items-center justify-center text-terracotta-600 font-bold">
                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $member->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('organizer.events.team.destroy', [$event, $member]) }}" method="POST" onsubmit="return confirm('Remove this team member?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 text-center py-12">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <p class="text-gray-500">No team members added yet.</p>
                    <a href="{{ route('organizer.events.team.create', $event) }}" class="btn-primary text-sm mt-4 inline-block">Add Team Member</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
