<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
            <button
                x-data="{ open: false }"
                @click="open = true"
                class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                Add Category
            </button>
            {{-- Create Modal --}}
            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.away="open = false" class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Category</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                <input type="text" name="name" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                                <input type="text" name="icon" placeholder="e.g. music, business, festival"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                                <select name="parent_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                                    <option value="">None (Top Level)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input type="number" name="sort_order" value="0" min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" checked id="is_active"
                                    class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]">
                                <label for="is_active" class="text-sm text-gray-700">Active</label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="container-page">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Categories Tree --}}
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Categories</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if($category->icon)
                                        <span class="w-8 h-8 rounded-lg bg-[#FFB0A1] bg-opacity-20 flex items-center justify-center text-[#E35336] text-sm">
                                            {{ strtoupper(substr($category->icon, 0, 2)) }}
                                        </span>
                                    @else
                                        <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 text-sm">
                                            {{ strtoupper(substr($category->name, 0, 2)) }}
                                        </span>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $category->slug }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($category->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                    <span class="text-sm text-gray-500">{{ $category->children_count ?? $category->children->count() }} subcategories</span>
                                    <div class="flex items-center gap-2" x-data="{ edit{{ $category->id }}: false }">
                                        <button @click="edit{{ $category->id }} = true" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Subcategories --}}
                            @if($category->children->count())
                                <div class="mt-3 ml-11 space-y-2">
                                    @foreach($category->children as $child)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-400">—</span>
                                                <span class="text-sm font-medium text-gray-700">{{ $child->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $child->slug }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @if($child->is_active)
                                                    <span class="text-xs text-green-600">Active</span>
                                                @else
                                                    <span class="text-xs text-yellow-600">Inactive</span>
                                                @endif
                                                <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-gray-500">No categories found. Create your first category to get started.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
