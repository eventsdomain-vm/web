<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assigned Clients</h2>
    </x-slot>
    <div class="container-page">
        @if($assignments->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($assignments as $assignment)
                    <div class="card p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $assignment->sponsor?->name ?? 'Unnamed Sponsor' }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $assignment->role ?? 'General' }} • {{ ucfirst($assignment->status) }}</p>
                            </div>
                            <span class="badge badge-{{ $assignment->status === 'active' ? 'success' : 'danger' }} text-xs">{{ $assignment->status }}</span>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <a href="{{ route('partner.clients.show', $assignment->id) }}" class="text-sm text-terracotta-500 hover:underline">View Profile</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $assignments->links() }}</div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">No clients assigned yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>
