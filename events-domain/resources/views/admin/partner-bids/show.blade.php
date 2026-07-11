<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="font-semibold text-xl">Bid Details</h2><a href="{{ route('admin.partner-bids.index') }}" class="text-gray-600 hover:underline text-sm">&larr; Back</a></div></x-slot>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="card p-6">
            <div class="flex justify-between items-start"><div><h1 class="text-2xl font-bold">{{ $bid->event->title ?? 'N/A' }}</h1><p class="text-gray-600">Partner: {{ $bid->partner->name ?? 'N/A' }} &bull; Service: {{ $bid->service->title ?? 'N/A' }}</p></div><span class="badge badge-{{ $bid->status === 'accepted' ? 'success' : ($bid->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($bid->status) }}</span></div>
            <div class="mt-6"><p class="text-sm text-gray-500">Quote Amount</p><p class="text-3xl font-bold">&#8377;{{ number_format($bid->quote_amount) }}</p></div>
            @if($bid->quote_note)<div class="mt-4"><p class="text-sm text-gray-500">Note</p><p class="text-gray-700 whitespace-pre-wrap">{{ $bid->quote_note }}</p></div>@endif
        </div>
    </div>
</x-app-layout>
