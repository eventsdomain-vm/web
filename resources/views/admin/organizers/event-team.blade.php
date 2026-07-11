<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Team &mdash; {{ $event->title }}</h2>
            <a href="{{ route('admin.events.show', $event) }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Add Team Member</h3>
                <form method="POST" action="{{ route('admin.events.team.store', $event) }}" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1"><label class="block text-sm font-medium mb-1">User *</label><select name="user_id" required class="input-field w-full"><option value="">Select user</option></select></div>
                    <div class="flex-1"><label class="block text-sm font-medium mb-1">Role *</label><input type="text" name="role" required class="input-field w-full" placeholder="e.g. Coordinator"></div>
                    <button type="submit" class="btn-primary">Add</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Team Members ({{ $team->count() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($team as $member)
                        <div class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">{{ $member->user->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-500">Role: {{ $member->role }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.events.team.destroy', [$event, $member]) }}" onsubmit="return confirm('Remove this member?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                            </form>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-500">No team members.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
