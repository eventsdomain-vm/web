<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Logs</h2>
            <span class="text-sm text-gray-500">{{ $total }} entries</span>
        </div>
    </x-slot>
    <div class="container-page py-6">
        <div class="card p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="action" class="border-gray-300 rounded-md text-sm"><option value="">All Actions</option>@foreach($actions as $action)<option value="{{ $action }}" @selected(($filters['action'] ?? '') === $action)>{{ ucfirst($action) }}</option>@endforeach</select>
                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="border-gray-300 rounded-md text-sm">
                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="border-gray-300 rounded-md text-sm">
                <button type="submit" class="btn-outline text-sm">Filter</button>
            </form>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($logs as $log)
                <div class="py-3 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold shrink-0">{{ substr($log->user?->name ?? 'SYS', 0, 2) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm"><span class="font-medium">{{ $log->user?->name ?? 'System' }}</span> {{ $log->action }} <span class="text-gray-500">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</span></p>
                        @if($log->description)<p class="text-xs text-gray-500 mt-1">{{ $log->description }}</p>@endif
                        <p class="text-xs text-gray-400 mt-1">{{ $log->created_at->format('M d, Y H:i:s') }} @if($log->ip_address)&middot; {{ $log->ip_address }}@endif</p>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-gray-500">No audit log entries found.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
