<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment Receipt') }}
            </h2>
            <a href="{{ route('sponsor.requests.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Requests
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Receipt</p>
                        <p class="font-mono text-sm text-gray-700">{{ $payment->uuid }}</p>
                    </div>
                    <span class="badge badge-{{ $payment->status_color }} text-sm capitalize">{{ $payment->status }}</span>
                </div>

                <div class="border border-gray-100 rounded-lg divide-y divide-gray-100">
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Event</span>
                        <span class="font-medium text-gray-900">{{ $payment->payable->event->title ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Package</span>
                        <span class="font-medium text-gray-900">{{ $payment->payable->package->title ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Base amount</span>
                        <span class="font-medium text-gray-900">₹{{ number_format((float) $payment->base_amount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">GST @if($payment->gst_number)<span class="text-xs text-gray-400">· {{ $payment->gst_number }}</span>@endif</span>
                        <span class="font-medium text-gray-900">₹{{ number_format((float) $payment->tax_amount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="font-bold text-lg text-[#E35336]">{{ $payment->formatted_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Gateway</span>
                        <span class="font-medium text-gray-900 capitalize">{{ $payment->gateway }}</span>
                    </div>
                    @if($payment->gateway_payment_id)
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-gray-600">Transaction ID</span>
                            <span class="font-mono text-sm text-gray-700">{{ $payment->gateway_payment_id }}</span>
                        </div>
                    @endif
                    @if($payment->paid_at)
                        <div class="flex items-center justify-between px-4 py-3">
                            <span class="text-gray-600">Paid on</span>
                            <span class="font-medium text-gray-900">{{ $payment->paid_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                @if(!$payment->isPaid())
                    <div class="mt-6">
                        <a href="{{ route('payments.checkout', $payment->payable) }}"
                           class="w-full block text-center bg-[#E35336] hover:bg-[#c8442b] text-white font-semibold py-3 rounded-xl transition">
                            Complete payment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
