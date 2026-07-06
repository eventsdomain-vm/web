<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Service') }}
            </h2>
            <a href="{{ route('partner.services.show', $service) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Service
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('partner.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="label">Service Title *</label>
                            <input type="text" name="title" value="{{ old('title', $service->title) }}" class="input-field" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="label">Description *</label>
                            <textarea name="description" class="input-field" rows="6" required>{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div>
                            <label class="label">Category *</label>
                            <select name="category_id" class="input-field" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->children as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ old('category_id', $service->category_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label">Status</label>
                            <select name="is_available" class="input-field">
                                <option value="1" {{ old('is_available', $service->is_available) ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ !old('is_available', $service->is_available) ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="label">Price (₹) *</label>
                            <input type="number" name="price" value="{{ old('price', $service->price) }}" class="input-field" required min="0">
                        </div>

                        <div>
                            <label class="label">Price Type *</label>
                            <select name="price_type" class="input-field" required>
                                <option value="fixed" {{ old('price_type', $service->price_type) === 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="hourly" {{ old('price_type', $service->price_type) === 'hourly' ? 'selected' : '' }}>Per Hour</option>
                                <option value="negotiable" {{ old('price_type', $service->price_type) === 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                            </select>
                        </div>

                        <div>
                            <label class="label">Pricing Model *</label>
                            <select name="pricing_model" class="input-field" required>
                                <option value="cost" {{ old('pricing_model', $service->pricing_model) === 'cost' ? 'selected' : '' }}>Paid</option>
                                <option value="barter" {{ old('pricing_model', $service->pricing_model) === 'barter' ? 'selected' : '' }}>Barter</option>
                                <option value="hybrid" {{ old('pricing_model', $service->pricing_model) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('partner.services.show', $service) }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
