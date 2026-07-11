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
            GSTIN saved. {{ session('gst_reason') ?? 'Could not confirm with the GST registry yet.' }}
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
</section>
