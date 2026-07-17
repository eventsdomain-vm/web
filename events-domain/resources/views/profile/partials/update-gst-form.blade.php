<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('GST Details') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add your GSTIN to apply GST on invoices and enable tax-compliant checkout.') }}
        </p>
    </header>

    @php $profile = auth()->user()->profile; @endphp

    @if(session('status') === 'gst-verified')
        <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-lg p-3 text-sm">
            GSTIN verified successfully{{ $profile?->gst_legal_name ? ' — '.$profile->gst_legal_name : '' }}.
        </div>
    @elseif(session('status') === 'gst-saved-unverified')
        <div class="mt-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3 text-sm">
            GSTIN saved — pending verification. Use the <strong>Verify Now</strong> button below to re-attempt verification.
            @if(session('gst_reason') && !str_contains(session('gst_reason'), 'not configured'))
                <br><span class="text-xs opacity-75">{{ session('gst_reason') }}</span>
            @endif
        </div>
    @elseif(session('status') === 'gst-invalid')
        <div class="mt-4 bg-red-50 border border-red-200 text-red-800 rounded-lg p-3 text-sm">
            {{ session('gst_reason') ?? 'Invalid GSTIN.' }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.gst.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="gst_number" :value="__('GSTIN')" />
            <x-text-input id="gst_number" name="gst_number" type="text" maxlength="15"
                          class="mt-1 block w-full uppercase"
                          :value="old('gst_number', $profile?->gst_number)"
                          placeholder="27AAPFU0939F1ZV" />
            <x-input-error class="mt-2" :messages="$errors->get('gst_number')" />

            @if($profile?->gst_number)
                <p class="mt-2 text-sm">
                    Status:
                    @if($profile->gst_verified)
                        <span class="badge badge-green">Verified</span>
                        @if($profile->gst_verified_at)
                            <span class="text-gray-400 text-xs">on {{ $profile->gst_verified_at->format('M d, Y') }}</span>
                        @endif
                    @else
                        <span class="badge badge-yellow">Not verified</span>
                    @endif
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save & Verify') }}</x-primary-button>
        </div>
    </form>

    @if($profile?->gst_number && !$profile->gst_verified)
        <form method="POST" action="{{ route('profile.gst.update') }}" class="mt-3">
            @csrf
            @method('PUT')
            <input type="hidden" name="gst_number" value="{{ $profile->gst_number }}">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-amber-500 rounded-xl shadow hover:bg-amber-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Verify Now
            </button>
        </form>
    @endif
</section>
