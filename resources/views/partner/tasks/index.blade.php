<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
            <a href="{{ route('partner.tasks.create') }}" class="btn-primary text-sm px-4 py-2 rounded-lg">+ New Task</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="flex gap-2 mb-4 flex-wrap">
            <a href="{{ route('partner.tasks.index') }}" class="text-xs px-3 py-1 rounded-full {{ !request('status') ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            @foreach(['pending','in_progress','completed','cancelled'] as $s)
                <a href="{{ route('partner.tasks.index', ['status' => $s]) }}" class="text-xs px-3 py-1 rounded-full {{ request('status') === $s ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">{{ str_replace('_',' ',$s) }}</a>
            @endforeach
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3 text-gray-600 font-medium">Title</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Priority</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Status</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Due Date</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Assigned To</th>
                        <th class="px-4 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $task->title }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-0.5 rounded {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-700' : ($task->priority === 'high' ? 'bg-amber-100 text-amber-700' : ($task->priority === 'medium' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600')) }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3"><span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'cancelled' ? 'danger' : 'info') }} text-xs">{{ str_replace('_',' ',$task->status) }}</span></td>
                            <td class="px-4 py-3">{{ $task->due_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $task->assignedTo?->name ?? '—' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('partner.tasks.show', $task->id) }}" class="text-terracotta-500 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">No tasks found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $tasks->links() }}</div>
    </div>
</x-app-layout>
