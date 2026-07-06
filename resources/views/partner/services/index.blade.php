<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Services') }}
            </h2>
            <a href="{{ route('partner.services.create') }}" class="btn-primary text-sm">
                + Add Service
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                    <div class="card-hover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="badge badge-info">{{ $service->category->name ?? 'N/A' }}</span>
                                <span class="badge {{ $service->is_available ? 'badge-success' : 'badge-danger' }}">
                                    {{ $service->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $service->price_type_label }}</span>
                                <span class="text-[#E35336] font-bold">{{ $service->formatted_price }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <span>{{ $service->pricing_model_label }}</span>
                                @if($service->average_rating)
                                    <span>•</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ $service->average_rating }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('partner.services.show', $service) }}" class="btn-outline flex-1 text-center text-sm">
                                    View
                                </a>
                                <a href="{{ route('partner.services.edit', $service) }}" class="btn-primary flex-1 text-center text-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-gray-500 text-lg mb-4">No services yet.</p>
                        <a href="{{ route('partner.services.create') }}" class="btn-primary inline-flex items-center">
                            Add Your First Service
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
