<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('sponsor.contracts.index') }}" class="text-sm text-terracotta-500 hover:underline">&larr; Back to Contracts</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">{{ $contract->title ?? $contract->contract_number ?? 'Contract' }}</h2>
            </div>
            <span class="badge badge-{{ $contract->status_color }} text-sm">{{ $contract->status_label }}</span>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card"><p class="text-sm text-gray-500">Amount</p><p class="text-2xl font-bold">₹{{ number_format($contract->amount) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Event</p><p class="text-lg font-semibold truncate">{{ $contract->event?->title ?? 'N/A' }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Duration</p><p class="text-lg font-semibold">{{ $contract->start_date?->format('M d, Y') ?? 'N/A' }} - {{ $contract->end_date?->format('M d, Y') ?? 'Open' }}</p></div>
        </div>
        @if($contract->status === 'pending_signature')
            <div class="card p-6 bg-yellow-50 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div><h3 class="font-semibold text-yellow-800">Awaiting Your Signature</h3><p class="text-sm text-yellow-600 mt-1">Review the terms and sign to activate the contract.</p></div>
                    <form method="POST" action="{{ route('sponsor.contracts.sign', $contract) }}">@csrf<button type="submit" class="btn-primary">Sign Contract</button></form>
                </div>
            </div>
        @endif
        <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Timeline</h3>
            <div class="space-y-3">
                @forelse($timeline as $entry)
                    <div class="flex items-start gap-3 pb-3 border-l-2 border-gray-200 ml-2 pl-4">
                        <div><p class="font-medium text-sm">{{ $entry['title'] }}</p><p class="text-xs text-gray-500">{{ $entry['type'] }} &middot; {{ $entry['date']->format('M d, Y H:i') }}</p></div>
                        @if(!empty($entry['description']))<p class="text-xs text-gray-600 mt-1">{{ $entry['description'] }}</p>@endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm py-4">No timeline entries.</p>
                @endforelse
            </div>
        </div>
        @if($contract->paymentSchedules->isNotEmpty())
            <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Payment Schedule</h3>
                <div class="divide-y divide-gray-100">
                    @foreach($contract->paymentSchedules as $schedule)
                        <div class="py-2 flex items-center justify-between">
                            <span>Installment {{ $schedule->installment_number }} - ₹{{ number_format($schedule->amount) }}</span>
                            <span class="text-sm text-gray-500">Due: {{ $schedule->due_date->format('M d, Y') }}</span>
                            <span class="badge badge-{{ $schedule->status === 'paid' ? 'success' : ($schedule->isOverdue() ? 'danger' : 'gray') }}">{{ ucfirst($schedule->status) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
