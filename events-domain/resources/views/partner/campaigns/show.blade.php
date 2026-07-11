<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partner.campaigns.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $campaign->name }}</h2>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6 mb-6">
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><dt class="text-xs text-gray-500">Status</dt><dd class="text-gray-900"><span class="badge badge-{{ $campaign->status === 'active' ? 'success' : 'info' }} text-xs">{{ $campaign->status }}</span></dd></div>
                <div><dt class="text-xs text-gray-500">Budget</dt><dd class="text-gray-900">₹{{ number_format($campaign->budget ?? 0) }}</dd></div>
                <div><dt class="text-xs text-gray-500">Period</dt><dd class="text-gray-900">{{ $campaign->start_date?->format('d M') ?? '?' }} - {{ $campaign->end_date?->format('d M Y') ?? '?' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Attendance</dt><dd class="text-gray-900">{{ number_format($campaign->attendance ?? 0) }}</dd></div>
                <div><dt class="text-xs text-gray-500">Engagement</dt><dd class="text-gray-900">{{ $campaign->engagement ?? '—' }}{{ $campaign->engagement ? '%' : '' }}</dd></div>
                <div><dt class="text-xs text-gray-500">Media Coverage</dt><dd class="text-gray-900 text-sm">{{ Str::limit($campaign->media_coverage ?? '—', 100) }}</dd></div>
            </dl>
        </div>
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Status</h3>
            <form method="POST" action="{{ route('partner.campaigns.update-status', $campaign->id) }}" class="flex gap-3">
                @csrf
                <select name="status" class="rounded-lg border-gray-300 text-sm">
                    <option value="planning" {{ $campaign->status === 'planning' ? 'selected' : '' }}>Planning</option>
                    <option value="active" {{ $campaign->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ $campaign->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="paused" {{ $campaign->status === 'paused' ? 'selected' : '' }}>Paused</option>
                </select>
                <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
