<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Integrations</h2>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary text-sm">+ Add Integration</button>
        </div>
    </x-slot>
    <div class="container-page py-6">
        @forelse($integrations as $integration)
            <div class="card mb-3 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-bold uppercase">{{ substr($integration->provider, 0, 2) }}</div>
                        <div><h3 class="font-semibold text-gray-900">{{ $integration->name ?? $integration->provider }}</h3>
                            <p class="text-xs text-gray-500">{{ ucfirst($integration->type) }} • {{ $integration->provider }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge badge-{{ $integration->status === 'connected' ? 'success' : ($integration->status === 'error' ? 'danger' : 'gray') }}">{{ ucfirst($integration->status) }}</span>
                        @if($integration->isConnected())
                            <form method="POST" action="{{ route('sponsor.integrations.disconnect', $integration) }}">@csrf<button type="submit" class="text-red-500 hover:underline text-sm">Disconnect</button></form>
                        @endif
                    </div>
                </div>
                @if($integration->last_error)
                    <p class="text-xs text-red-500 mt-2">Error: {{ $integration->last_error }}</p>
                @endif
            </div>
        @empty
            <div class="card p-8 text-center text-gray-500">No integrations configured. Connect your CRM, analytics, or communication tools.</div>
        @endforelse
    </div>
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Add Integration</h3>
            <form method="POST" action="{{ route('sponsor.integrations.store') }}">@csrf
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Provider</label><input type="text" name="provider" placeholder="e.g. zapier, hubspot, slack" required class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" placeholder="Optional label" class="w-full border-gray-300 rounded-md"></div>
                <div class="mb-3"><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full border-gray-300 rounded-md"><option value="crm">CRM</option><option value="analytics">Analytics</option><option value="communication">Communication</option><option value="automation">Automation</option><option value="payment">Payment</option></select></div>
                <div class="flex justify-end gap-2"><button type="button" onclick="this.closest('#createModal').classList.add('hidden')" class="btn-outline">Cancel</button><button type="submit" class="btn-primary">Add</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
