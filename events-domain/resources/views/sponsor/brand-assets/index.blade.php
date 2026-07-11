<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Brand Assets</h2>
            <button onclick="document.getElementById('createBrandModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Brand</button>
        </div>
    </x-slot>
    <div class="container-page py-6 space-y-6">
        @foreach($brands as $brand)
            <div class="card p-4"><div class="flex items-center justify-between mb-3"><h3 class="font-semibold text-lg">{{ $brand->name }} @if($brand->is_primary)<span class="badge badge-success text-xs ml-2">Primary</span>@endif</h3></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($brand->assets as $asset)
                        <div class="border rounded-lg p-3 text-center hover:shadow-sm transition">
                            <div class="w-full h-20 bg-gray-50 rounded mb-2 flex items-center justify-center text-gray-400 text-xs">{{ $asset->type }}</div>
                            <p class="text-sm font-medium truncate">{{ $asset->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($asset->type) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="card p-6"><h3 class="font-semibold text-lg mb-4">Upload Asset</h3>
            <form method="POST" action="{{ route('sponsor.brand-assets.assets.store') }}" class="flex flex-wrap gap-3">@csrf
                <select name="brand_id" required class="border-gray-300 rounded-md text-sm"><option value="">Select brand...</option>@foreach($brands as $brand)<option value="{{ $brand->id }}">{{ $brand->name }}</option>@endforeach</select>
                <input type="text" name="name" placeholder="Asset name" required class="border-gray-300 rounded-md text-sm">
                <select name="type" required class="border-gray-300 rounded-md text-sm"><option value="logo">Logo</option><option value="banner">Banner</option><option value="video">Video</option><option value="document">Document</option><option value="social_post">Social Post</option><option value="other">Other</option></select>
                <input type="text" name="file_path" placeholder="File path / URL" required class="border-gray-300 rounded-md text-sm flex-1">
                <button type="submit" class="btn-primary text-sm">Upload</button>
            </form>
        </div>
    </div>
    <div id="createBrandModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Brand</h3>
            <form method="POST" action="{{ route('sponsor.brand-assets.brands.store') }}">@csrf
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Brand Name</label><input type="text" name="name" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Tagline</label><input type="text" name="tagline" class="w-full border-gray-300 rounded-md"></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createBrandModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Create</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
