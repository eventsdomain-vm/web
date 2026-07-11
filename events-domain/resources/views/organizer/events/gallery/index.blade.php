<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gallery: {{ $event->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Event</a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Upload Form --}}
    <div class="card p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4">Upload Images</h3>
        <form action="{{ route('organizer.events.gallery.store', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-terracotta-300 transition cursor-pointer" onclick="document.getElementById('gallery-input').click()">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-sm text-gray-500">Click to select images or drag them here</p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP. Max 5MB each.</p>
                    <input id="gallery-input" type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="hidden" onchange="this.form.submit()">
                </div>
                @error('images')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                @error('images.*')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary text-sm">Upload Images</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Gallery Grid --}}
    @if($images->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($images as $image)
                <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                    <img src="{{ Storage::url($image->image_url) }}" alt="{{ $image->caption ?? '' }}" class="w-full h-48 object-cover" loading="lazy" onerror="this.parentElement.innerHTML='<div class=&quot;w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center&quot;><span class=&quot;text-gray-400 text-sm&quot;>Broken</span></div>'">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <form action="{{ route('organizer.events.gallery.destroy', [$event, $image]) }}" method="POST" onsubmit="return confirm('Remove this image?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <p class="text-gray-500">No gallery images yet.</p>
            <p class="text-sm text-gray-400 mt-1">Upload images above to showcase your event.</p>
        </div>
    @endif
</x-app-layout>
