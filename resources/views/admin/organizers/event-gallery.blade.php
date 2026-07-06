<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Gallery &mdash; {{ $event->title }}</h2>
            <a href="{{ route('admin.events.show', $event) }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Upload Images</h3>
                <form method="POST" action="{{ route('admin.events.gallery.store', $event) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4"><input type="file" name="images[]" multiple accept="image/*" class="input-field w-full"></div>
                    <button type="submit" class="btn-primary">Upload</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Gallery Images ({{ $images->count() }})</h3></div>
                <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_url) }}" class="w-full h-40 object-cover rounded-lg">
                            <form method="POST" action="{{ route('admin.events.gallery.destroy', [$event, $image]) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition" onsubmit="return confirm('Delete this image?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">&times;</button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-4 text-center text-gray-500 py-12">No images in gallery.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
