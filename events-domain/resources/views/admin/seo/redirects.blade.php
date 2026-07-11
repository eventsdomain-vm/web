<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Redirects</h2>
            <button onclick="document.getElementById('createRedirectModal').classList.remove('hidden')" class="btn-primary text-sm">Add Redirect</button>
        </div>
    </x-slot>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Source</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($redirects as $redirect)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900 break-all">{{ $redirect->source_url }}</td>
                        <td class="px-4 py-3 text-sm text-blue-600 break-all">{{ $redirect->target_url }}</td>
                        <td class="px-4 py-3"><span class="badge badge-info">{{ $redirect->type }}</span></td>
                        <td class="px-4 py-3">
                            <span class="badge {{ $redirect->is_active ? 'badge-success' : 'badge-warning' }}">{{ $redirect->is_active ? 'Yes' : 'No' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.seo.redirects.destroy', $redirect) }}" class="inline" onsubmit="return confirm('Delete this redirect?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No redirects configured.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $redirects->links() }}
        </div>
    </div>

    {{-- Create Modal --}}
    <div id="createRedirectModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 m-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">New Redirect</h3>
                <button onclick="document.getElementById('createRedirectModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.seo.redirects.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Source URL</label>
                    <input type="url" name="source_url" required class="input-field w-full" placeholder="https://example.com/old-page">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target URL</label>
                    <input type="url" name="target_url" required class="input-field w-full" placeholder="https://example.com/new-page">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" required class="input-field w-full">
                        <option value="301">301 - Permanent</option>
                        <option value="302">302 - Temporary</option>
                        <option value="307">307 - Temporary (method preserved)</option>
                        <option value="308">308 - Permanent (method preserved)</option>
                        <option value="410">410 - Gone</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300">
                    <label for="is_active" class="text-sm text-gray-700">Active</label>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('createRedirectModal').classList.add('hidden')" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
