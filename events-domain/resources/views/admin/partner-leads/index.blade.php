<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Partner Leads') }}</h2></x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="stage" class="input-field w-auto"><option value="">All Stages</option>@foreach($stages as $s)<option value="{{ $s }}" {{ request('stage')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select>
                    <select name="priority" class="input-field w-auto"><option value="">All Priority</option><option value="low" {{ request('priority')==='low'?'selected':'' }}>Low</option><option value="medium" {{ request('priority')==='medium'?'selected':'' }}>Medium</option><option value="high" {{ request('priority')==='high'?'selected':'' }}>High</option></select>
                    <input type="text" name="search" placeholder="Search partner..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="flex gap-4 mb-6">
                <div class="stat-card flex-1"><p class="text-sm text-gray-500">Total Leads</p><p class="text-2xl font-bold">{{ $leads->total() }}</p></div>
                <div class="stat-card flex-1"><p class="text-sm text-gray-500">Won</p><p class="text-2xl font-bold text-green-600">{{ $leads->where('stage','won')->count() }}</p></div>
                <div class="stat-card flex-1"><p class="text-sm text-gray-500">Lost</p><p class="text-2xl font-bold text-red-600">{{ $leads->where('stage','lost')->count() }}</p></div>
            </div>
            <div class="card overflow-hidden">
                <table class="w-full"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium uppercase">Partner</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Sponsor</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Value</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Stage</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Priority</th><th class="px-6 py-3 text-left text-xs font-medium uppercase">Probability</th><th class="px-6 py-3 text-right text-xs font-medium uppercase">Actions</th></tr></thead>
                    <tbody class="divide-y">@forelse($leads as $lead)<tr class="hover:bg-gray-50"><td class="px-6 py-4 text-sm">{{ $lead->partner->name ?? 'N/A' }}</td><td class="px-6 py-4 text-sm text-gray-600">{{ $lead->sponsor->name ?? 'N/A' }}</td><td class="px-6 py-4 text-sm">&#8377;{{ number_format($lead->value ?? 0) }}</td><td class="px-6 py-4"><span class="badge badge-{{ $lead->stage === 'won' ? 'success' : ($lead->stage === 'lost' ? 'danger' : 'info') }}">{{ ucfirst($lead->stage) }}</span></td><td class="px-6 py-4"><span class="badge badge-{{ $lead->priority === 'high' ? 'danger' : ($lead->priority === 'medium' ? 'warning' : 'info') }}">{{ ucfirst($lead->priority) }}</span></td><td class="px-6 py-4 text-sm">{{ $lead->probability ?? 'N/A' }}%</td><td class="px-6 py-4 text-right"><a href="{{ route('admin.partner-leads.show', $lead) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td></tr>@empty <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No leads found.</td></tr>@endforelse</tbody>
                </table>
                <div class="px-6 py-4 border-t">{{ $leads->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
