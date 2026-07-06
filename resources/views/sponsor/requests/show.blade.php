<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sponsorship Request Details') }}
            </h2>
            <a href="{{ route('sponsor.requests.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Requests
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Request Details -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $request->event->title ?? 'Event N/A' }}</h1>
                            <span class="badge badge-{{ $request->status_color }} text-lg">{{ $request->status_label }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Package</p>
                                <p class="font-medium">{{ $request->package->title ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Amount</p>
                                <p class="font-medium text-[#E35336]">₹{{ number_format($request->package->price ?? 0) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Request Date</p>
                                <p class="font-medium">{{ $request->created_at->format('M d, Y') }}</p>
                            </div>
                            @if($request->budget_offer)
                                <div>
                                    <p class="text-sm text-gray-500">Your Offer</p>
                                    <p class="font-medium">₹{{ number_format($request->budget_offer) }}</p>
                                </div>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-2">Your Message</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700">{{ $request->message }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contract -->
                    @if($request->contract)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contract</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="badge badge-{{ $request->contract->status_color }}">{{ $request->contract->status_label }}</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Amount</p>
                                    <p class="font-medium">₹{{ number_format($request->contract->amount) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Start Date</p>
                                    <p class="font-medium">{{ $request->contract->start_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">End Date</p>
                                    <p class="font-medium">{{ $request->contract->end_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @if($request->contract->terms)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Terms</p>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-700">{{ $request->contract->terms }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment CTA -->
                    @if($request->package)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                Secure your sponsorship for
                                <span class="font-medium text-gray-700">₹{{ number_format($request->package->price ?? 0) }}</span>.
                            </p>
                            <a href="{{ route('payments.checkout', $request) }}"
                               class="w-full block text-center bg-[#E35336] hover:bg-[#c8442b] text-white font-semibold py-2.5 rounded-xl transition">
                                Proceed to Payment
                            </a>
                        </div>
                    @endif

                    <!-- Event Info -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">{{ $request->event->start_date->format('M d, Y') ?? 'TBA' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium">{{ $request->event->city ?? 'TBA' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Expected Audience</p>
                                <p class="font-medium">{{ number_format($request->event->expected_audience ?? 0) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('sponsor.events.show', $request->event) }}" class="btn-outline w-full block text-center text-sm mt-4">
                            View Event
                        </a>
                    </div>

                    <!-- Package Benefits -->
                    @if($request->package && $request->package->benefitRecords->count())
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Package Benefits</h3>
                            <ul class="space-y-2">
                                @foreach($request->package->benefitRecords as $benefit)
                                    <li class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $benefit->benefit_text }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
