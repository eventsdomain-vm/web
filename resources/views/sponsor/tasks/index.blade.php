<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
            <button onclick="document.getElementById('createTaskModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Task</button>
        </div>
    </x-slot>
    <div class="container-page py-6">
        @forelse($tasks as $task)
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <form method="POST" action="{{ route('sponsor.tasks.update', $task) }}">
                            @csrf
                            <input type="hidden" name="status" value="{{ $task->status === 'done' ? 'todo' : 'done' }}">
                            <button type="submit" class="w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $task->status === 'done' ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-terracotta-500' }}">
                                @if($task->status === 'done')<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>@endif
                            </button>
                        </form>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium {{ $task->status === 'done' ? 'line-through text-gray-400' : 'text-gray-900' }}">{{ $task->title }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                @if($task->campaign)<span>{{ $task->campaign->event?->title ?? 'Campaign' }}</span>@endif
                                @if($task->due_date)<span>Due: {{ $task->due_date->format('M d') }}</span>@endif
                                <span class="badge badge-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'gray') }} text-xs">{{ ucfirst($task->priority) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        @foreach($task->assignees as $assignee)
                            <span class="text-xs bg-gray-100 rounded-full px-2 py-1">{{ $assignee->user->name }}</span>
                        @endforeach
                        <span class="badge badge-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'gray') }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">No tasks yet.</div>
        @endforelse
        {{ $tasks->links() }}
    </div>
    <div id="createTaskModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Task</h3>
            <form method="POST" action="{{ route('sponsor.tasks.store') }}">@csrf
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea></div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div><label class="block text-sm font-medium mb-1">Priority</label><select name="priority" class="w-full border-gray-300 rounded-md"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option><option value="urgent">Urgent</option></select></div>
                    <div><label class="block text-sm font-medium mb-1">Due Date</label><input type="date" name="due_date" class="w-full border-gray-300 rounded-md"></div>
                </div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createTaskModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
