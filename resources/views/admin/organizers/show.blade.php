<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $organizer->name }}</h2>
            <a href="{{ route('admin.organizers.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <div class="flex items-center gap-6">
                    <img src="{{ $organizer->avatar_url }}" class="w-20 h-20 rounded-full object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $organizer->name }}</h1>
                        <p class="text-gray-600">{{ $organizer->email }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="badge badge-info">Organizer</span>
                            <span class="badge {{ $organizer->is_verified ? 'badge-success' : 'badge-warning' }}">{{ $organizer->is_verified ? 'Verified' : 'Unverified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($profile)
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-sm text-gray-500">Organization</p><p class="font-medium">{{ $profile->organization_name ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">Business Type</p><p class="font-medium">{{ $profile->business_type ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">Phone</p><p class="font-medium">{{ $profile->phone ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">City</p><p class="font-medium">{{ $profile->city ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">State</p><p class="font-medium">{{ $profile->state ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">Country</p><p class="font-medium">{{ $profile->country ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">Website</p><p class="font-medium">{{ $profile->website ?? 'N/A' }}</p></div>
                    <div><p class="text-sm text-gray-500">Tax ID</p><p class="font-medium">{{ $profile->tax_id ?? 'N/A' }}</p></div>
                </div>
                @if($profile->bio)
                <div class="mt-4"><p class="text-sm text-gray-500">Bio</p><p class="font-medium">{{ $profile->bio }}</p></div>
                @endif
            </div>
            @endif

            <div class="card overflow-hidden mb-6">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Events ({{ $events->total() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($events as $event)
                        <div class="px-6 py-4 hover:bg-gray-50 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">{{ $event->title }}</p>
                                <p class="text-sm text-gray-500">{{ $event->category->name ?? 'N/A' }} &bull; {{ $event->start_date?->format('M d, Y') ?? 'TBD' }}</p>
                            </div>
                            <span class="badge badge-{{ $event->status_color }}">{{ $event->status_label }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-500">No events.</div>
                    @endforelse
                </div>
                <div class="px-6 py-4 border-t">{{ $events->links() }}</div>
            </div>

            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="text-lg font-semibold">Contracts ({{ $contracts->total() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($contracts as $contract)
                        <div class="px-6 py-4 hover:bg-gray-50 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">{{ $contract->event->title ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">Sponsor: {{ $contract->sponsor->name ?? 'N/A' }} &bull; &#8377;{{ number_format($contract->amount ?? 0) }}</p>
                            </div>
                            <span class="badge badge-{{ $contract->status === 'active' ? 'success' : ($contract->status === 'terminated' ? 'danger' : 'info') }}">{{ ucfirst($contract->status) }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-500">No contracts.</div>
                    @endforelse
                </div>
                <div class="px-6 py-4 border-t">{{ $contracts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
