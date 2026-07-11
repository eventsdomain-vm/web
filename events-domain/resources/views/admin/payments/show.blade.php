<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment Detail') }}
            </h2>
            <a href="{{ route('admin.payments') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page max-w-3xl">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Reference</p>
                        <p class="font-mono text-sm text-gray-700">{{ $payment->uuid }}</p>
                    </div>
                    <span class="badge badge-{{ $payment->status_color }} capitalize">{{ $payment->status }}</span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Payer</p>
                        <p class="font-medium text-gray-900">{{ $payment->user->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">{{ $payment->user->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gateway</p>
                        <p class="font-medium text-gray-900 capitalize">{{ $payment->gateway }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Event</p>
                        <p class="font-medium text-gray-900">{{ $payment->payable->event->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Package</p>
                        <p class="font-medium text-gray-900">{{ $payment->payable->package->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Base amount</p>
                        <p class="font-medium text-gray-900">₹{{ number_format((float) $payment->base_amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">GST {{ $payment->gst_number ? '('.$payment->gst_number.')' : '' }}</p>
                        <p class="font-medium text-gray-900">₹{{ number_format((float) $payment->tax_amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="font-bold text-[#E35336]">{{ $payment->formatted_amount }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Paid at</p>
                        <p class="font-medium text-gray-900">{{ $payment->paid_at?->format('M d, Y H:i') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gateway order ID</p>
                        <p class="font-mono text-xs text-gray-700">{{ $payment->gateway_order_id ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gateway payment ID</p>
                        <p class="font-mono text-xs text-gray-700">{{ $payment->gateway_payment_id ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Manual status control (view/mark only; no gateway refund call) --}}
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Update status</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Manual override only — this does not call the gateway. Use it to reconcile a
                    refund issued directly in the gateway dashboard.
                </p>
                <form method="POST" action="{{ route('admin.payments.status', $payment) }}" class="flex items-center gap-3">
                    @csrf
                    @method('PUT')
                    <select name="status" class="input-field w-auto">
                        <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $payment->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    <button type="submit" class="btn-primary text-sm">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
