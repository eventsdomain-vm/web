<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
            <span class="text-sm text-gray-500">{{ method_exists($invoices, 'total') ? $invoices->total() : $invoices->count() }} total</span>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stat-card"><p class="text-sm text-gray-500">Total Invoiced</p><p class="text-2xl font-bold">₹{{ number_format($summary['total_invoiced']) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Total Paid</p><p class="text-2xl font-bold text-green-600">₹{{ number_format($summary['total_paid']) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Outstanding</p><p class="text-2xl font-bold text-yellow-600">₹{{ number_format($summary['outstanding']) }}</p></div>
            <div class="stat-card"><p class="text-sm text-gray-500">Overdue</p><p class="text-2xl font-bold text-red-600">{{ $summary['overdue_count'] }}</p></div>
        </div>
        @forelse($invoices as $invoice)
            <div class="card p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('sponsor.invoices.show', $invoice) }}" class="font-semibold text-gray-900 hover:text-terracotta-500">{{ $invoice->invoice_number }}</a>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>₹{{ number_format($invoice->total) }}</span>
                            <span>Due: {{ $invoice->due_date->format('M d, Y') }}</span>
                            <span>Paid: ₹{{ number_format($invoice->amount_paid) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : ($invoice->status === 'draft' ? 'gray' : 'warning')) }}">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</span>
                        <a href="{{ route('sponsor.invoices.show', $invoice) }}" class="text-terracotta-500 hover:underline text-sm font-medium">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">No invoices yet.</div>
        @endforelse
        @if(method_exists($invoices, 'links'))
            {{ $invoices->links() }}
        @endif
    </div>
</x-app-layout>
