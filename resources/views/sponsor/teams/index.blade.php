<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Project Teams</h2>
            <button onclick="document.getElementById('createTeamModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Team</button>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        @forelse($events as $event)
            <div class="space-y-4">
                <div class="flex items-center gap-2 px-2">
                    <h3 class="font-semibold text-lg text-gray-900">{{ $event->name }}</h3>
                    <span class="text-sm text-gray-500">({{ $event->eventTeams->count() ?? 0 }} teams)</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($teams->where('event_id', $event->id) as $team)
                        <div class="card p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-900">{{ $team->name }}</h4>
                                <span class="text-xs text-gray-500">{{ $team->members->count() }} members</span>
                            </div>
                            @if($team->lead)<p class="text-sm text-gray-500 mb-3">Lead: {{ $team->lead->name }}</p>@endif
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($team->members as $member)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-full text-xs">
                                        <div>
                                            <div class="font-medium">{{ $member->user->name }}</div>
                                            <div class="text-gray-500 text-xs">{{ $member->designation ?? 'N/A' }} ({{ $member->role }})</div>
                                        </div>
                                        <form method="POST" action="{{ route('sponsor.teams.members.destroy', [$team, $member]) }}" style="display: inline;" onsubmit="return confirm('Remove this member?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 ml-1">&times;</button>
                                        </form>
                                    </span>
                                @endforeach
                            </div>
                            <button onclick="document.getElementById('addMemberModal-{{ $team->id }}').classList.remove('hidden')" class="btn-outline text-xs w-full">+ Add Member</button>
                        </div>
                    @empty
                        <div class="card p-8 text-center text-gray-500 col-span-2">No teams created for this project yet.</div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">
                <p class="mb-2">No active projects/events yet.</p>
                <p class="text-sm">Create or request sponsorship for events to organize teams.</p>
            </div>
        @endforelse
    </div>

    <!-- Create Team Modal -->
    <div id="createTeamModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Team for Project</h3>
            <form method="POST" action="{{ route('sponsor.teams.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Project/Event *</label>
                    <select name="event_id" required class="w-full border-gray-300 rounded-md">
                        <option value="">Select a project...</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Team Name *</label>
                    <input type="text" name="name" required class="w-full border-gray-300 rounded-md" placeholder="e.g., Marketing Team, Event Logistics">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" class="w-full border-gray-300 rounded-md" rows="2" placeholder="Optional team description"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="this.closest('#createTeamModal').classList.add('hidden')" class="btn-outline">Cancel</button>
                    <button type="submit" class="btn-primary">Create Team</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Member Modals for each team -->
    @foreach($teams as $team)
        <div id="addMemberModal-{{ $team->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
            <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
                <h3 class="font-semibold text-lg mb-4">Add Member to {{ $team->name }}</h3>
                <form method="POST" action="{{ route('sponsor.teams.members.store', $team) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Name *</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-md" placeholder="Full name">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Email ID *</label>
                        <input type="email" name="email" required class="w-full border-gray-300 rounded-md" placeholder="Email address">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Designation *</label>
                        <input type="text" name="designation" required class="w-full border-gray-300 rounded-md" placeholder="e.g., Project Manager, Coordinator">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Role *</label>
                        <select name="role" required class="w-full border-gray-300 rounded-md">
                            <option value="">Select a role...</option>
                            <option value="viewer">Viewer</option>
                            <option value="editor">Editor</option>
                            <option value="approver">Approver</option>
                            <option value="finance">Finance</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="this.closest('#addMemberModal-{{ $team->id }}').classList.add('hidden')" class="btn-outline">Cancel</button>
                        <button type="submit" class="btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</x-app-layout>
