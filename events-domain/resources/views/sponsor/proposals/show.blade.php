<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Proposal: {{ $proposal->event->title }}</h2>
            <a href="{{ route('sponsor.proposals.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Proposals</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Proposal Status</h3>
                            <span class="badge badge-{{ $proposal->status_color }} px-3 py-1">{{ $proposal->status_label }}</span>
                        </div>

                        <div class="flex items-center gap-2 mb-6">
                            @php $steps = ['draft','submitted','shortlisted','negotiating','agreed','contracted','active','completed']; @endphp
                            @foreach($steps as $i => $step)
                                @php $isActive = array_search($proposal->status, $steps) >= $i; @endphp
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $isActive ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-400' }}">{{ $i + 1 }}</div>
                                    @if($i < count($steps) - 1)
                                        <div class="w-8 h-0.5 {{ $isActive ? 'bg-terracotta-500' : 'bg-gray-100' }}"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Message</span>
                                <p class="mt-1 text-gray-700">{{ $proposal->message }}</p>
                            </div>

                            @if($proposal->additional_benefits)
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Additional Benefits Requested</span>
                                <p class="mt-1 text-gray-700">{{ $proposal->additional_benefits }}</p>
                            </div>
                            @endif

                            @if($proposal->organizer_note)
                            <div class="bg-blue-50 rounded-lg p-4">
                                <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Organizer Response</span>
                                <p class="mt-1 text-blue-800">{{ $proposal->organizer_note }}</p>
                            </div>
                            @endif

                            @if($proposal->counter_amount)
                            <div class="bg-yellow-50 rounded-lg p-4">
                                <span class="text-xs font-semibold text-yellow-700 uppercase tracking-wider">Counter Offer</span>
                                <p class="mt-1 text-yellow-800">
                                    <span class="font-bold">₹{{ number_format($proposal->counter_amount) }}</span>
                                    @if($proposal->counter_message)
                                        — {{ $proposal->counter_message }}
                                    @endif
                                </p>
                                @if($proposal->status === 'counter_offer')
                                    <div class="flex gap-2 mt-3">
                                        <form action="{{ route('sponsor.proposals.accept-counter', $proposal) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-600">Accept Counter</button>
                                        </form>
                                        <a href="#" @click.prevent="$dispatch('open-counter-modal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border rounded-lg hover:bg-gray-50">Send New Counter</a>
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="card p-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Event Info</h3>
                        <div class="space-y-2 text-sm">
                            <p><span class="text-gray-500">Event:</span> <span class="font-medium">{{ $proposal->event->title }}</span></p>
                            <p><span class="text-gray-500">Organizer:</span> <span class="font-medium">{{ $proposal->event->organizer->name }}</span></p>
                            <p><span class="text-gray-500">Package:</span> <span class="font-medium">{{ $proposal->package->title ?? 'N/A' }}</span></p>
                            <p><span class="text-gray-500">Amount:</span> <span class="font-medium">₹{{ number_format($proposal->budget_offer ?? $proposal->package->price ?? 0) }}</span></p>
                            <p><span class="text-gray-500">Date:</span> <span class="font-medium">{{ $proposal->event->start_date?->format('M d, Y') }}</span></p>
                            <p><span class="text-gray-500">Location:</span> <span class="font-medium">{{ $proposal->event->city }}</span></p>
                        </div>
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('sponsor.events.show', $proposal->event) }}" class="btn-outline w-full block text-center text-sm">View Event</a>
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Actions</h3>
                        <div class="space-y-3">
                            @if($proposal->status === 'draft')
                                <form action="{{ route('sponsor.proposals.submit', $proposal) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full text-sm">Submit Proposal</button>
                                </form>
                            @endif
                            @if(in_array($proposal->status, ['submitted', 'viewed', 'shortlisted', 'negotiating', 'counter_offer']))
                                <form action="{{ route('sponsor.proposals.withdraw', $proposal) }}" method="POST" onsubmit="return confirm('Withdraw this proposal?')">
                                    @csrf
                                    <button type="submit" class="btn-outline w-full text-sm text-red-500 border-red-200 hover:bg-red-50">Withdraw Proposal</button>
                                </form>
                            @endif
                            @if(in_array($proposal->status, ['negotiating']))
                                <a href="#" @click.prevent="$dispatch('open-counter-modal')" class="btn-outline w-full block text-center text-sm">Send Counter Offer</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Counter Offer Modal --}}
    <div x-data="{ open: false, amount: '', message: '' }"
         @open-counter-modal.window="open = true"
         x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10"
             @click.outside="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Send Counter Offer</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form :action="'{{ route('sponsor.proposals.counter', $proposal) }}'" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Amount (₹)</label>
                    <input type="number" name="counter_amount" x-model="amount" min="0" step="0.01" class="input-field w-full" required>
                </div>
                <div class="mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Message</label>
                    <textarea name="counter_message" x-model="message" rows="3" class="input-field w-full" placeholder="Explain your counter offer..."></textarea>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="open = false" class="btn-outline text-sm">Cancel</button>
                    <button type="submit" class="btn-primary text-sm">Send Counter</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
