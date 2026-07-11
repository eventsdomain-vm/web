<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Relationship Details</h2>
            <a href="{{ route('admin.srm.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $relationship->sponsor->name ?? 'N/A' }}</h1>
                        <p class="text-gray-600">Organizer: {{ $relationship->user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="badge badge-{{ ($relationship->health_score ?? 0) >= 70 ? 'success' : (($relationship->health_score ?? 0) >= 40 ? 'warning' : 'danger') }} text-lg">{{ $relationship->health_score ?? 'N/A' }}/100</span>
                        <p class="text-sm text-gray-500 mt-1">{{ ucfirst($relationship->status ?? 'active') }}</p>
                    </div>
                </div>
            </div>
            @if($relationship->notes)
            <div class="card p-6 mb-6"><h3 class="font-semibold mb-3">Notes</h3><p class="text-gray-700 whitespace-pre-wrap">{{ $relationship->notes }}</p></div>
            @endif
            <div class="card overflow-hidden mb-6">
                <div class="px-6 py-4 border-b"><h3 class="font-semibold">Contracts ({{ $contracts->count() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($contracts as $c)
                        <div class="px-6 py-4 flex justify-between">
                            <span class="text-sm">{{ $c->event->title ?? 'N/A' }} - &#8377;{{ number_format($c->amount ?? 0) }}</span>
                            <span class="badge badge-{{ $c->status === 'active' ? 'success' : 'info' }}">{{ ucfirst($c->status) }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">No contracts.</div>
                    @endforelse
                </div>
            </div>
            <div class="card overflow-hidden">
                <div class="px-6 py-4 border-b"><h3 class="font-semibold">Renewals ({{ $renewals->count() }})</h3></div>
                <div class="divide-y divide-gray-100">
                    @forelse($renewals as $r)
                        <div class="px-6 py-4 flex justify-between">
                            <span class="text-sm">{{ $r->status }} - &#8377;{{ number_format($r->proposed_value ?? 0) }}</span>
                            <span class="text-sm text-gray-500">{{ $r->created_at->format('M d, Y') }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">No renewals.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
