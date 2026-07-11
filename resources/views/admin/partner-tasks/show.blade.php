<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Task Details</h2><a href="{{ route('admin.partner-tasks.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">{{ $task->title }}</h1><p class="text-gray-600">Partner: {{ $task->partner->name ?? 'N/A' }} &bull; Assigned to: {{ $task->assignedTo->name ?? 'N/A' }}</p></div><span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'cancelled' ? 'danger' : 'info') }} text-lg">{{ ucfirst($task->status) }}</span></div></div>
        <div class="grid grid-cols-3 gap-6"><div class="card p-6"><h3 class="font-semibold">Priority</h3><p class="text-lg">{{ ucfirst($task->priority) }}</p></div><div class="card p-6"><h3 class="font-semibold">Due Date</h3><p class="text-lg">{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</p></div><div class="card p-6"><h3 class="font-semibold">Completed At</h3><p class="text-lg">{{ $task->completed_at?->format('M d, Y H:i') ?? 'Not completed' }}</p></div></div>
        @if($task->description)<div class="card p-6"><h3 class="font-semibold">Description</h3><p class="whitespace-pre-wrap">{{ $task->description }}</p></div>@endif
    </div>
</x-app-layout>
