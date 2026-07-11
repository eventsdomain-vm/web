<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $service->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('partner.services.edit', $service) }}" class="btn-outline text-sm">
                    Edit Service
                </a>
                <a href="{{ route('partner.services.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="badge badge-info">{{ $service->category->name ?? 'N/A' }}</span>
                        <span class="badge {{ $service->is_available ? 'badge-success' : 'badge-danger' }} ml-2">
                            {{ $service->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                    <span class="text-2xl font-bold text-[#E35336]">{{ $service->formatted_price }}</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $service->title }}</h1>

                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($service->description)) !!}
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-500">Price Type</p>
                        <p class="font-medium">{{ $service->price_type_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pricing Model</p>
                        <p class="font-medium">{{ $service->pricing_model_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Rating</p>
                        <p class="font-medium">{{ $service->average_rating ?? 'N/A' }} ({{ $service->review_count }} reviews)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Created</p>
                        <p class="font-medium">{{ $service->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviews</h3>
                @forelse($service->reviews as $review)
                    <div class="border-b border-gray-100 last:border-0 py-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ $review->organizer->avatar_url }}" alt="{{ $review->organizer->name }}" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $review->organizer->name }}</p>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600">{{ $review->review }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No reviews yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
