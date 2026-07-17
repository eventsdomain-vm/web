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
        <div class="mt-3">
            <button type="button" id="gst-verify-now-btn"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-amber-500 rounded-xl shadow hover:bg-amber-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Verify Now
            </button>
        </div>
    @endif

    <div id="gst-captcha-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 relative">
            <button type="button" id="gst-captcha-close" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Verify GSTIN</h3>
            <div id="gst-captcha-loading" class="text-center py-8 text-gray-500">Loading captcha...</div>
            <div id="gst-captcha-body" class="hidden">
                <p class="text-sm text-gray-600 mb-3">Enter the characters shown in the image below:</p>
                <div class="flex justify-center mb-4">
                    <img id="gst-captcha-img" src="" alt="Captcha" class="border rounded-lg max-w-full">
                </div>
                <input type="text" id="gst-captcha-input"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-center text-lg tracking-widest uppercase"
                       placeholder="Enter captcha" maxlength="10" autocomplete="off">
                <p id="gst-captcha-error" class="mt-2 text-sm text-red-600 hidden"></p>
                <div class="mt-4 flex gap-3">
                    <button type="button" id="gst-captcha-refresh"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Refresh
                    </button>
                    <button type="button" id="gst-captcha-submit"
                            class="flex-1 px-4 py-2 text-sm font-semibold text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition disabled:opacity-50"
                            disabled>
                        Verify
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            const btn = document.getElementById('gst-verify-now-btn');
            if (! btn) return;

            const modal = document.getElementById('gst-captcha-modal');
            const closeBtn = document.getElementById('gst-captcha-close');
            const loading = document.getElementById('gst-captcha-loading');
            const body = document.getElementById('gst-captcha-body');
            const img = document.getElementById('gst-captcha-img');
            const input = document.getElementById('gst-captcha-input');
            const error = document.getElementById('gst-captcha-error');
            const refreshBtn = document.getElementById('gst-captcha-refresh');
            const submitBtn = document.getElementById('gst-captcha-submit');

            const gstin = '{{ $profile?->gst_number }}';
            let sessionId = null;

            function fetchCaptcha() {
                loading.classList.remove('hidden');
                body.classList.add('hidden');
                error.classList.add('hidden');
                input.value = '';
                submitBtn.disabled = true;

                fetch('{{ route("profile.gst.captcha") }}')
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        sessionId = data.session_id;
                        img.src = data.image;
                        loading.classList.add('hidden');
                        body.classList.remove('hidden');
                    })
                    .catch(function () {
                        loading.textContent = 'Failed to load captcha. Try again.';
                    });
            }

            function openModal() {
                modal.classList.remove('hidden');
                fetchCaptcha();
            }

            function closeModal() {
                modal.classList.add('hidden');
                sessionId = null;
            }

            btn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            refreshBtn.addEventListener('click', fetchCaptcha);

            input.addEventListener('input', function () {
                submitBtn.disabled = this.value.trim().length === 0;
            });

            submitBtn.addEventListener('click', function () {
                const captcha = input.value.trim();
                if (! captcha || ! sessionId) return;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Verifying...';
                error.classList.add('hidden');

                fetch('{{ route("profile.gst.verify-captcha") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ gstin: gstin, session_id: sessionId, captcha: captcha }),
                })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.verified) {
                            window.location.reload();
                        } else {
                            error.textContent = data.reason || 'Verification failed. Try again.';
                            error.classList.remove('hidden');
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Verify';
                            fetchCaptcha();
                        }
                    })
                    .catch(function () {
                        error.textContent = 'Network error. Please try again.';
                        error.classList.remove('hidden');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Verify';
                    });
            });
        })();
    </script>
    @endpush
</section>
