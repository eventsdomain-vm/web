<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="text-xl font-semibold">Assignment Details</h2><a href="{{ route('admin.partner-clients.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto">
        <div class="card p-6"><div class="flex justify-between"><div><h1 class="text-2xl font-bold">{{ $assignment->sponsor->name ?? 'N/A' }}</h1><p class="text-gray-600">Partner: {{ $assignment->partner->name ?? 'N/A' }}<br>Assigned: {{ $assignment->created_at->format('M d, Y H:i') }}</p></div></div></div>
    </div>
</x-app-layout>
