<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Teams</h2>
            <button onclick="document.getElementById('createTeamModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Team</button>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($teams as $team)
                <div class="card p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">{{ $team->name }}</h3>
                        <span class="text-xs text-gray-500">{{ $team->members->count() }} members</span>
                    </div>
                    @if($team->lead)<p class="text-sm text-gray-500 mb-3">Lead: {{ $team->lead->name }}</p>@endif
                    <div class="flex flex-wrap gap-2">
                        @foreach($team->members as $member)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-full text-xs">
                                {{ $member->user->name }}
                                <span class="text-gray-400">({{ $member->role }})</span>
                            </span>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('sponsor.teams.members.store', $team) }}" class="mt-3 flex gap-2">
                        @csrf
                        <select name="user_id" class="text-xs border-gray-200 rounded-md" required>
                            <option value="">Add member...</option>
                            @foreach($members as $m)<option value="{{ $m->user_id }}">{{ $m->user->name }}</option>@endforeach
                        </select>
                        <select name="role" class="text-xs border-gray-200 rounded-md">
                            <option value="viewer">Viewer</option><option value="editor">Editor</option><option value="approver">Approver</option><option value="finance">Finance</option>
                        </select>
                        <button type="submit" class="btn-outline text-xs">Add</button>
                    </form>
                </div>
            @empty
                <div class="card p-8 text-center text-gray-500 col-span-2">No teams yet. Create one to organize your team members.</div>
            @endforelse
        </div>
        <div class="card p-6">
            <h3 class="font-semibold text-lg mb-4">All Members</h3>
            <div class="divide-y divide-gray-100">
                @foreach($members as $member)
                    <div class="py-2 flex items-center justify-between">
                        <div><span class="font-medium">{{ $member->user->name }}</span><span class="text-sm text-gray-500 ml-2">({{ $member->role }})</span></div>
                        <span class="text-xs text-gray-400">{{ $member->user->email }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="createTeamModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Team</h3>
            <form method="POST" action="{{ route('sponsor.teams.store') }}">
                @csrf
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createTeamModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
