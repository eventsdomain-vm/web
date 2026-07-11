<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Renewal Details</h2>
            <a href="{{ route('admin.renewals.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $renewal->sponsor->name ?? 'N/A' }}</h1>
                        <p class="text-gray-600">Organizer: {{ $renewal->user->name ?? 'N/A' }}</p>
                    </div>
                    <span class="badge badge-{{ $renewal->status === 'renewed' ? 'success' : ($renewal->status === 'lost' ? 'danger' : 'warning') }}">{{ ucfirst($renewal->status) }}</span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="card p-6"><h3 class="font-semibold mb-2">Proposed Value</h3><p class="text-2xl font-bold">&#8377;{{ number_format($renewal->proposed_value ?? 0) }}</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">Probability</h3><p class="text-2xl font-bold">{{ $renewal->probability ?? 'N/A' }}%</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">Expected Close</h3><p class="text-lg">{{ $renewal->expected_close_date?->format('M d, Y') ?? 'N/A' }}</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">Renewed At</h3><p class="text-lg">{{ $renewal->renewed_at?->format('M d, Y H:i') ?? 'Not yet' }}</p></div>
            </div>
            @if($renewal->notes)
            <div class="card p-6"><h3 class="font-semibold mb-2">Notes</h3><p class="text-gray-700 whitespace-pre-wrap">{{ $renewal->notes }}</p></div>
            @endif
        </div>
    </div>
</x-app-layout>
