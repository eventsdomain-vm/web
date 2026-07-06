<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Meeting Details</h2><a href="{{ route('admin.partner-meetings.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">{{ $meeting->title }}</h1><p class="text-gray-600">Partner: {{ $meeting->partner->name ?? 'N/A' }} &bull; Sponsor: {{ $meeting->sponsor->name ?? 'N/A' }}</p></div><span class="badge badge-{{ $meeting->status === 'completed' ? 'success' : ($meeting->status === 'cancelled' ? 'danger' : 'info') }} text-lg">{{ ucfirst($meeting->status) }}</span></div></div>
        <div class="grid grid-cols-2 gap-6"><div class="card p-6"><h3 class="font-semibold">Type</h3><p class="text-lg">{{ ucfirst($meeting->type) }}</p>@if($meeting->meeting_link)<a href="{{ $meeting->meeting_link }}" target="_blank" class="text-terracotta-500 text-sm">Join Meeting</a>@endif</div><div class="card p-6"><h3 class="font-semibold">Time</h3><p class="text-lg">{{ $meeting->start_time?->format('M d, Y H:i') ?? 'N/A' }} - {{ $meeting->end_time?->format('H:i') ?? 'N/A' }}</p><p class="text-sm text-gray-500">{{ $meeting->timezone ?? 'UTC' }}</p></div></div>
        @if($meeting->description)<div class="card p-6"><h3 class="font-semibold">Description</h3><p class="whitespace-pre-wrap">{{ $meeting->description }}</p></div>@endif
        @if($meeting->minutes)<div class="card p-6"><h3 class="font-semibold">Minutes</h3><p class="whitespace-pre-wrap">{{ $meeting->minutes }}</p></div>@endif
        @if($meeting->location)<div class="card p-6"><h3 class="font-semibold">Location</h3><p>{{ $meeting->location }}</p></div>@endif
    </div>
</x-app-layout>
