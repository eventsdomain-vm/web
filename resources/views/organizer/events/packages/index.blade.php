<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sponsorship Packages: {{ $event->title }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('organizer.events.packages.create', $event) }}" class="btn-primary text-sm">+ Add Package</a>
                <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Event</a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($packages as $package)
            <div class="card p-6 border border-gray-200 hover:border-terracotta-200 transition">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $package->title }}</h3>
                        @if($package->description)
                            <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-terracotta-500">₹{{ number_format($package->price) }}</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <span>Slots: {{ $package->slots_filled }}/{{ $package->slots_available }}</span>
                </div>

                @if($package->benefitRecords->count())
                    <div class="bg-gray-50 rounded-xl p-4 mb-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Benefits:</p>
                        <ul class="space-y-1">
                            @foreach($package->benefitRecords as $benefit)
                                <li class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    {{ $benefit->benefit_text }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('organizer.events.packages.edit', [$event, $package]) }}" class="text-terracotta-500 hover:text-terracotta-700 text-sm font-medium">Edit</a>
                    <form action="{{ route('organizer.events.packages.destroy', [$event, $package]) }}" method="POST" onsubmit="return confirm('Delete this package?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 text-center py-12">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-gray-500">No packages created yet.</p>
                <a href="{{ route('organizer.events.packages.create', $event) }}" class="btn-primary text-sm mt-4 inline-block">Create Package</a>
            </div>
        @endforelse
    </div>
</x-app-layout>
