<x-guest-layout>
    <section class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 gradient-hero relative items-center justify-center p-12">
            <div class="absolute inset-0 bg-pattern opacity-5"></div>
            <div class="relative z-10 text-center max-w-md">
                <img src="{{ asset('logo-white.png') }}" alt="EventsDomain" class="h-14 w-auto mx-auto mb-8">
                <h2 class="text-3xl font-bold text-white mb-4">OTP Verification</h2>
                <p class="text-white/70 text-lg leading-relaxed">Secure your account with a one-time passcode sent to your inbox.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden flex items-center mb-8">
                    <img src="{{ asset('logo.png') }}" alt="EventsDomain" class="h-8 object-contain">
                </div>

                <div class="mb-8 text-center">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Enter OTP</h1>
                    <p class="text-sm text-gray-500">We've sent a 6-digit code to <strong class="text-gray-700">{{ auth()->user()->email ?? 'your email' }}</strong></p>
                </div>

                @if (session('status') == 'otp-sent')
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('A new OTP has been sent to your email address.') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf

                    <div class="mb-6">
                        <div class="flex gap-3 justify-center">
                            @for ($i = 0; $i < 6; $i++)
                            <input type="text" name="digit_{{ $i }}" maxlength="1" inputmode="numeric" pattern="[0-9]"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value&&this.nextElementSibling)this.nextElementSibling.focus()"
                                onkeydown="if(event.key==='Backspace'&&!this.value&&this.previousElementSibling)this.previousElementSibling.focus()"
                                class="w-12 h-14 text-center text-xl font-bold rounded-lg border border-gray-300 bg-white text-gray-800 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition"
                                required autofocus>
                            @endfor
                        </div>
                        <input type="hidden" name="code" id="otp_code">
                        @error('code')<p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>@enderror
                        @error('otp')<p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="bg-terracotta-500 hover:bg-terracotta-700 shadow-sm hover:shadow-md flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-semibold text-white transition">
                        Verify Email
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <form method="POST" action="{{ route('otp.send') }}">
                        @csrf
                        <input type="hidden" name="channel" value="email">
                        <button type="submit" class="text-sm font-medium text-terracotta-600 hover:text-terracotta-700 transition underline underline-offset-2">
                            Resend OTP
                        </button>
                    </form>
                    <p class="text-xs text-gray-400 mt-1">Valid for 10 minutes</p>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <a href="{{ route('verification.notice') }}"
                       class="text-sm text-gray-500 hover:text-terracotta-600 transition underline underline-offset-2">
                        {{ __('Use email verification link instead') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input[name^="digit_"]');
        const hidden = document.getElementById('otp_code');
        const form = hidden.closest('form');
        form.addEventListener('submit', function () {
            let code = '';
            inputs.forEach(function (input) { code += input.value; });
            hidden.value = code;
        });
    });
</script>
