<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <a href="{{ route('sponsor.requests.show', $request) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Request
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($error)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4 text-sm">
                    {{ $error }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Confirm your sponsorship</h1>
                <p class="text-gray-500 mb-6">{{ $request->event->title ?? 'Event' }}</p>

                <div class="border border-gray-100 rounded-lg divide-y divide-gray-100">
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Package</span>
                        <span class="font-medium text-gray-900">{{ $package->title }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">Base amount</span>
                        <span class="font-medium text-gray-900">₹{{ number_format($gst['base'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-gray-600">
                            GST ({{ rtrim(rtrim(number_format($gst['rate'], 2), '0'), '.') }}%)
                            @if($payment->gst_number)
                                <span class="text-xs text-gray-400">· {{ $payment->gst_number }}</span>
                            @endif
                        </span>
                        <span class="font-medium text-gray-900">₹{{ number_format($gst['tax'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-b-lg">
                        <span class="font-semibold text-gray-900">Total payable</span>
                        <span class="font-bold text-lg text-[#E35336]">₹{{ number_format($gst['total'], 2) }}</span>
                    </div>
                </div>

                @if(!$payment->gst_number)
                    <p class="text-xs text-gray-400 mt-3">
                        No verified GSTIN on your profile — GST not applied.
                        <a href="{{ route('profile.edit') }}" class="text-[#E35336] hover:underline">Add & verify GSTIN</a>
                    </p>
                @endif

                <div class="mt-6">
                    @if($checkout && $checkout['gateway'] === 'razorpay')
                        <button id="rzp-pay-btn"
                                class="w-full bg-[#E35336] hover:bg-[#c8442b] text-white font-semibold py-3 rounded-xl transition">
                            Pay ₹{{ number_format($gst['total'], 2) }} securely
                        </button>
                    @else
                        <button disabled
                                class="w-full bg-gray-200 text-gray-500 font-semibold py-3 rounded-xl cursor-not-allowed">
                            Payment unavailable
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($checkout && $checkout['gateway'] === 'razorpay')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            const options = {
                key: @json($checkout['key']),
                order_id: @json($checkout['order_id']),
                amount: @json($checkout['amount']),
                currency: @json($checkout['currency']),
                name: @json($checkout['name']),
                description: @json($package->title),
                prefill: @json($checkout['prefill']),
                theme: { color: '#E35336' },
                handler: function (response) {
                    // Post the signed result back to our callback for verification.
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = @json(route('payments.callback', $payment));

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden'; csrf.name = '_token';
                    csrf.value = @json(csrf_token());
                    form.appendChild(csrf);

                    ['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature'].forEach(function (k) {
                        const i = document.createElement('input');
                        i.type = 'hidden'; i.name = k; i.value = response[k];
                        form.appendChild(i);
                    });
                    document.body.appendChild(form);
                    form.submit();
                }
            };
            const rzp = new Razorpay(options);
            document.getElementById('rzp-pay-btn').addEventListener('click', function (e) {
                e.preventDefault();
                rzp.open();
            });
        </script>
    @endif
</x-app-layout>
