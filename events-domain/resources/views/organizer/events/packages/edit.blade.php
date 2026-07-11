<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sponsorship Package</h2>
            <a href="{{ route('organizer.events.packages.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Packages</a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <form action="{{ route('organizer.events.packages.update', [$event, $package]) }}" method="POST" class="card p-6 md:p-8 space-y-6">
            @csrf @method('PUT')

            <div class="input-group">
                <label class="label">Package Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $package->title) }}" class="input-field input-lg" required>
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="input-group">
                <label class="label">Description</label>
                <textarea name="description" class="input-field" rows="3">{{ old('description', $package->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="input-group">
                    <label class="label">Price (₹) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $package->price) }}" class="input-field input-lg" required min="0" step="0.01">
                </div>
                <div class="input-group">
                    <label class="label">Available Slots <span class="text-red-500">*</span></label>
                    <input type="number" name="slots_available" value="{{ old('slots_available', $package->slots_available) }}" class="input-field input-lg" required min="1">
                </div>
            </div>

            <div class="input-group">
                <label class="label">Benefits</label>
                <p class="input-hint mb-2">One benefit per line.</p>
                <textarea name="benefits" class="input-field" rows="5">{{ old('benefits', $package->benefitRecords->pluck('benefit_text')->implode("\n")) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('organizer.events.packages.index', $event) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Update Package</button>
            </div>
        </form>
    </div>
</x-app-layout>
