<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="card p-4">
                    <p class="text-sm text-gray-500">Total collected</p>
                    <p class="text-2xl font-bold text-gray-900">₹{{ number_format((float) $totals['paid'], 2) }}</p>
                </div>
                <div class="card p-4">
                    <p class="text-sm text-gray-500">Paid transactions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totals['count_paid']) }}</p>
                </div>
                <div class="card p-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totals['count_pending']) }}</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="status" class="input-field w-auto">
                        <option value="">All Status</option>
                        @foreach(['created','pending','paid','failed','refunded'] as $s)
                            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <select name="gateway" class="input-field w-auto">
                        <option value="">All Gateways</option>
                        <option value="razorpay" {{ request('gateway') === 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                        <option value="stripe" {{ request('gateway') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    </select>
                    <input type="text" name="search" placeholder="Search UUID / txn / payer..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>

            {{-- Payments table --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gateway</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-mono text-xs text-gray-700">{{ \Illuminate\Support\Str::limit($payment->uuid, 13, '…') }}</div>
                                        @if($payment->gst_number)
                                            <div class="text-xs text-gray-400">GST: {{ $payment->gst_number }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600">{{ $payment->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-400">{{ $payment->user->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-900">{{ $payment->formatted_amount }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600 capitalize">{{ $payment->gateway }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge badge-{{ $payment->status_color }} capitalize">{{ $payment->status }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $payment->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-[#E35336] hover:underline text-sm font-medium">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <p class="text-gray-500">No payments found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
