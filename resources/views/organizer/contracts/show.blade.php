<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contract: {{ $contract->sponsor?->company_name ?? 'N/A' }}</h2>
            <a href="{{ route('organizer.contracts.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 max-w-2xl">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div><span class="text-xs text-gray-500">Event</span><p class="font-semibold">{{ $contract->event?->title ?? 'N/A' }}</p></div>
                <div><span class="text-xs text-gray-500">Sponsor</span><p class="font-semibold">{{ $contract->sponsor?->company_name ?? 'N/A' }}</p></div>
                <div><span class="text-xs text-gray-500">Amount</span><p class="font-semibold text-green-600">₹{{ number_format($contract->amount ?? 0, 2) }}</p></div>
                <div><span class="text-xs text-gray-500">Status</span><p class="font-semibold">{{ ucfirst($contract->status) }}</p></div>
                <div><span class="text-xs text-gray-500">Created</span><p>{{ $contract->created_at->format('M d, Y') }}</p></div>
                <div><span class="text-xs text-gray-500">Signed At</span><p>{{ $contract->signed_at?->format('M d, Y') ?? '-' }}</p></div>
            </div>
            @if ($contract->terms)
                <div class="mb-4"><h3 class="text-sm font-semibold text-gray-900 mb-1">Terms</h3><p class="text-sm text-gray-600">{{ $contract->terms }}</p></div>
            @endif
            <form method="POST" action="{{ route('organizer.contracts.update-status', $contract->id) }}" class="flex items-center gap-3">
                @csrf
                <label class="text-sm font-medium text-gray-700">Update Status:</label>
                <select name="status" class="rounded-lg border-gray-300 text-sm">
                    <option value="pending" {{ $contract->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="signed" {{ $contract->status === 'signed' ? 'selected' : '' }}>Signed</option>
                    <option value="active" {{ $contract->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ $contract->status === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ $contract->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
