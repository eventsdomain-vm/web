<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.tasks.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $task->title }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><dt class="text-xs text-gray-500">Status</dt><dd class="text-gray-900"><span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'cancelled' ? 'danger' : 'info') }} text-xs">{{ str_replace('_',' ',$task->status) }}</span></dd></div>
                <div><dt class="text-xs text-gray-500">Priority</dt><dd class="text-gray-900">{{ ucfirst($task->priority) }}</dd></div>
                <div><dt class="text-xs text-gray-500">Due Date</dt><dd class="text-gray-900">{{ $task->due_date?->format('d M Y') ?? '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Assigned To</dt><dd class="text-gray-900">{{ $task->assignedTo?->name ?? '—' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Completed At</dt><dd class="text-gray-900">{{ $task->completed_at?->format('d M Y H:i') ?? '—' }}</dd></div>
            </dl>
            @if($task->description)
                <div class="mt-4 pt-4 border-t border-gray-100"><dt class="text-xs text-gray-500 mb-1">Description</dt><dd class="text-gray-700 text-sm">{{ $task->description }}</dd></div>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Status</h3>
            <form method="POST" action="{{ route('partner.tasks.update-status', $task->id) }}" class="flex gap-3">
                @csrf
                <select name="status" class="rounded-lg border-gray-300 text-sm">
                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $task->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
