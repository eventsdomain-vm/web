<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bid Details') }}
            </h2>
            <a href="{{ route('partner.bids.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Bids
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Bid Details -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $bid->event->title ?? 'Event N/A' }}</h1>
                            <span class="badge badge-{{ $bid->status_color }} text-lg">{{ $bid->status_label }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Service</p>
                                <p class="font-medium">{{ $bid->service->title ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Quoted Price</p>
                                <p class="font-medium text-[#E35336]">{{ $bid->formatted_price }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Submitted</p>
                                <p class="font-medium">{{ $bid->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        @if($bid->quote_note)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Your Quote Note</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700">{{ $bid->quote_note }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Event Info -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">{{ $bid->event->start_date->format('M d, Y') ?? 'TBA' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium">{{ $bid->event->city ?? 'TBA' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Expected Audience</p>
                                <p class="font-medium">{{ number_format($bid->event->expected_audience ?? 0) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Service Info -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Service</p>
                                <p class="font-medium">{{ $bid->service->title ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Category</p>
                                <p class="font-medium">{{ $bid->service->category->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Listed Price</p>
                                <p class="font-medium">{{ $bid->service->formatted_price ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
