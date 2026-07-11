<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Proposal: {{ $event->title }}</h2>
            <a href="{{ route('sponsor.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Event</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('sponsor.proposals.store', $event) }}" method="POST" class="space-y-6">
                @csrf

                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Package</h3>
                    <div class="space-y-3">
                        @foreach($event->packages as $package)
                            <label class="flex items-start gap-4 p-4 border rounded-xl cursor-pointer hover:border-terracotta-300 transition has-[:checked]:border-terracotta-500 has-[:checked]:bg-terracotta-50">
                                <input type="radio" name="package_id" value="{{ $package->id }}" class="mt-1 text-terracotta-500" required>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-900">{{ $package->title }}</span>
                                        <span class="text-lg font-bold text-terracotta-500">₹{{ number_format($package->price) }}</span>
                                    </div>
                                    @if($package->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                                        <span>{{ $package->slots_filled }}/{{ $package->slots_available }} slots filled</span>
                                        @if($package->benefitRecords->count())
                                            <span>{{ $package->benefitRecords->count() }} benefits</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Proposal Details</h3>

                    <div class="mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Message to Organizer *</label>
                        <textarea name="message" rows="4" class="input-field w-full" placeholder="Explain why your brand is a great fit for this event..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Budget Offer (₹)</label>
                        <input type="number" name="budget_offer" min="0" step="0.01" class="input-field w-full" placeholder="Leave blank to match package price">
                    </div>

                    <div class="mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Additional Benefits Requested</label>
                        <textarea name="additional_benefits" rows="2" class="input-field w-full" placeholder="Any specific benefits you'd like beyond the package?"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Internal Note (not shared with organizer)</label>
                        <textarea name="internal_note" rows="2" class="input-field w-full" placeholder="Notes for your team..."></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('sponsor.events.show', $event) }}" class="btn-outline text-sm">Cancel</a>
                    <button type="submit" class="btn-primary text-sm">Save as Draft</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
