<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Service Details</h2><a href="{{ route('admin.partner-services.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a></div></x-slot>
    <div class="space-y-6"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="card p-6 mb-6">
            <div class="flex justify-between items-start">
                <div><h1 class="text-2xl font-bold text-gray-900">{{ $service->title }}</h1><p class="text-gray-600">Partner: {{ $service->partner->name ?? 'N/A' }} &bull; {{ $service->category->name ?? 'N/A' }}</p></div>
                <span class="badge {{ $service->is_available ? 'badge-success' : 'badge-danger' }} text-sm">{{ $service->is_available ? 'Available' : 'Unavailable' }}</span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="card p-6"><h3 class="font-semibold mb-2">Price</h3><p class="text-2xl font-bold">&#8377;{{ number_format($service->price) }}</p></div>
            <div class="card p-6"><h3 class="font-semibold mb-2">Price Type</h3><p class="text-lg">{{ ucfirst($service->price_type) }}</p></div>
            <div class="card p-6"><h3 class="font-semibold mb-2">Model</h3><p class="text-lg">{{ ucfirst($service->pricing_model) }}</p></div>
        </div>
        @if($service->description)<div class="card p-6 mb-6"><h3 class="font-semibold mb-2">Description</h3><p class="text-gray-700 whitespace-pre-wrap">{{ $service->description }}</p></div>@endif
        @if($service->reviews && $service->reviews->count())<div class="card overflow-hidden"><div class="px-6 py-4 border-b"><h3 class="font-semibold">Reviews ({{ $service->reviews->count() }})</h3></div><div class="divide-y">@foreach($service->reviews as $review)<div class="px-6 py-4"><p class="text-sm text-gray-600">{{ $review->review ?? '' }}</p><p class="text-xs text-gray-400">Rating: {{ $review->rating }}/5</p></div>@endforeach</div></div>@endif
    </div></div>
</x-app-layout>
