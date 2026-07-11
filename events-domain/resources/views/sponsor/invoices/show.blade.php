<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('sponsor.invoices.index') }}" class="text-sm text-terracotta-500 hover:underline">&larr; Back to Invoices</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">{{ $invoice->invoice_number }}</h2>
            </div>
            <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }} text-sm">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</span>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Details</h3>
                <dl class="space-y-2 text-sm"><div class="flex justify-between"><dt class="text-gray-500">Issue Date</dt><dd>{{ $invoice->issue_date->format('M d, Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Due Date</dt><dd>{{ $invoice->due_date->format('M d, Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Event</dt><dd>{{ $invoice->event?->title ?? 'N/A' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Contract</dt><dd>{{ $invoice->contract?->contract_number ?? 'N/A' }}</dd></div></dl>
            </div>
            <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Summary</h3>
                <dl class="space-y-2 text-sm"><div class="flex justify-between"><dt>Subtotal</dt><dd>₹{{ number_format($invoice->subtotal, 2) }}</dd></div>
                <div class="flex justify-between"><dt>Tax ({{ $invoice->tax_rate }}%)</dt><dd>₹{{ number_format($invoice->tax_amount, 2) }}</dd></div>
                <div class="flex justify-between"><dt>Discount</dt><dd>-₹{{ number_format($invoice->discount, 2) }}</dd></div>
                <div class="flex justify-between font-bold text-base border-t pt-2 mt-2"><dt>Total</dt><dd>₹{{ number_format($invoice->total, 2) }}</dd></div>
                <div class="flex justify-between text-green-600"><dt>Paid</dt><dd>₹{{ number_format($invoice->amount_paid, 2) }}</dd></div>
                @if($invoice->balance_due > 0)<div class="flex justify-between text-red-600 font-bold"><dt>Balance Due</dt><dd>₹{{ number_format($invoice->balance_due, 2) }}</dd></div>@endif</dl>
            </div>
        </div>
        @if($invoice->items->isNotEmpty())
            <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Line Items</h3>
                <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 border-b"><th class="pb-2">Description</th><th class="pb-2">Qty</th><th class="pb-2">Unit Price</th><th class="pb-2 text-right">Total</th></tr></thead>
                <tbody>@foreach($invoice->items as $item)<tr class="border-b border-gray-50"><td class="py-2">{{ $item->description }}</td><td class="py-2">{{ $item->quantity }}</td><td class="py-2">₹{{ number_format($item->unit_price, 2) }}</td><td class="py-2 text-right">₹{{ number_format($item->total, 2) }}</td></tr>@endforeach</tbody></table>
            </div>
        @endif
        @if(in_array($invoice->status, ['draft', 'sent', 'partially_paid', 'overdue']))
            <div class="card p-6 bg-yellow-50 border border-yellow-200">
                <form method="POST" action="{{ route('sponsor.invoices.pay', $invoice) }}" class="flex items-end gap-4">
                    @csrf
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Amount to Pay</label><input type="number" step="0.01" name="amount" max="{{ $invoice->balance_due }}" value="{{ $invoice->balance_due }}" class="border-gray-300 rounded-md shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500"></div>
                    <input type="hidden" name="gateway" value="bank_transfer"><input type="hidden" name="transaction_id" value="TXN-{{ str()->random(12) }}">
                    <button type="submit" class="btn-primary">Record Payment</button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
