<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.clients.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $assignment->sponsor?->name ?? 'Client Profile' }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><dt class="text-xs text-gray-500">Sponsor Name</dt><dd class="text-gray-900">{{ $assignment->sponsor?->name ?? 'N/A' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Role</dt><dd class="text-gray-900">{{ $assignment->role ?? 'N/A' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Status</dt><dd class="text-gray-900">{{ ucfirst($assignment->status) }}</dd></div>
                <div><dt class="text-xs text-gray-500">Assigned At</dt><dd class="text-gray-900">{{ $assignment->assigned_at?->format('d M Y') ?? 'N/A' }}</dd></div>
            </dl>
            @if($assignment->notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <dt class="text-xs text-gray-500 mb-1">Notes</dt>
                    <dd class="text-gray-700 text-sm">{{ $assignment->notes }}</dd>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
