<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contract Details</h2>
            <a href="{{ route('admin.contracts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $contract->event->title ?? 'N/A' }}</h1>
                        <p class="text-gray-600 mt-1">Sponsor: {{ $contract->sponsor->name ?? 'N/A' }}</p>
                        <p class="text-gray-600">Organizer: {{ $contract->event->organizer->name ?? 'N/A' }}</p>
                    </div>
                    <span class="badge badge-{{ $contract->status === 'active' ? 'success' : ($contract->status === 'terminated' ? 'danger' : 'info') }} text-lg">{{ ucfirst($contract->status) }}</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="card p-6">
                    <h3 class="font-semibold mb-3">Contract Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Amount</span><span class="font-medium">&#8377;{{ number_format($contract->amount ?? 0) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Start Date</span><span class="font-medium">{{ $contract->start_date?->format('M d, Y') ?? 'N/A' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">End Date</span><span class="font-medium">{{ $contract->end_date?->format('M d, Y') ?? 'N/A' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Signed At</span><span class="font-medium">{{ $contract->signed_at?->format('M d, Y H:i') ?? 'Not signed' }}</span></div>
                    </div>
                </div>
                <div class="card p-6">
                    <h3 class="font-semibold mb-3">Update Status</h3>
                    <form method="POST" action="{{ route('admin.contracts.update-status', $contract) }}">
                        @csrf @method('PATCH')
                        <select name="status" class="input-field w-full mb-3">
                            <option value="active" {{ $contract->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="signed" {{ $contract->status === 'signed' ? 'selected' : '' }}>Signed</option>
                            <option value="completed" {{ $contract->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="terminated" {{ $contract->status === 'terminated' ? 'selected' : '' }}>Terminated</option>
                        </select>
                        <button type="submit" class="btn-primary w-full">Update Status</button>
                    </form>
                </div>
            </div>
            @if($contract->terms)
            <div class="card p-6"><h3 class="font-semibold mb-3">Terms</h3><p class="text-gray-700 whitespace-pre-wrap">{{ $contract->terms }}</p></div>
            @endif
        </div>
    </div>
</x-app-layout>
