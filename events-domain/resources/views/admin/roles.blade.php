<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles & Permissions') }}
            </h2>
            <button
                x-data="{ open: false }"
                @click="open = true"
                class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                Create Role
            </button>
            {{-- Create Modal --}}
            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.away="open = false" class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Role</h3>
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role Name *</label>
                                <input type="text" name="name" required placeholder="e.g. editor"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]">
                                            {{ $permission->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                                Create Role
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

            {{-- Roles List --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($roles as $role)
                    <div class="card p-6" x-data="{ edit{{ $role->id }}: false }">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-900 capitalize">{{ $role->name }}</h3>
                            <button @click="edit{{ $role->id }} = true" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">{{ $role->permissions->count() }} permissions</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions->take(5) as $permission)
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ $permission->name }}</span>
                                @endforeach
                                @if($role->permissions->count() > 5)
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">+{{ $role->permissions->count() - 5 }} more</span>
                                @endif
                            </div>
                        </div>

                        {{-- Edit Modal --}}
                        <div x-show="edit{{ $role->id }}" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                            <div @click.away="edit{{ $role->id }} = false" class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Role: {{ $role->name }}</h3>
                                <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Role Name *</label>
                                            <input type="text" name="name" value="{{ $role->name }}" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#E35336] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                                            <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                                @foreach($permissions as $permission)
                                                    <label class="flex items-center gap-2 text-sm">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                            {{ $role->permissions->contains($permission) ? 'checked' : '' }}
                                                            class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]">
                                                        {{ $permission->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="edit{{ $role->id }} = false" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium">
                                            Update Role
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full card p-12 text-center">
                        <p class="text-gray-500">No roles found. Create your first role to get started.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
