<x-guest-layout>
    <section class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 gradient-hero relative items-center justify-center p-12">
            <div class="absolute inset-0 bg-pattern opacity-5"></div>
            <div class="relative z-10 text-center max-w-md">
                <img src="{{ asset('logo-white.png') }}" alt="EventsDomain" class="h-14 w-auto mx-auto mb-8">
                <h2 class="text-3xl font-bold text-white mb-4">Start Your Journey</h2>
                <p class="text-white/70 text-lg leading-relaxed">Join India's leading B2B event sponsorship marketplace. Connect with organizers, sponsors, and partners.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-lg">
                <div class="lg:hidden flex items-center mb-8">
                    <img src="{{ asset('logo.png') }}" alt="EventsDomain" class="h-8 object-contain">
                </div>

                <div class="mb-6 sm:mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                    <p class="text-sm text-gray-500">Enter your details to get started!</p>
                </div>



                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                                placeholder="John Doe"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                                    placeholder="info@gmail.com"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition">
                                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="mobile" class="mb-1.5 block text-sm font-medium text-gray-700">Phone Number</label>
                                <input id="mobile" name="mobile" type="tel" value="{{ old('mobile') }}"
                                    placeholder="+91 97250 98250"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition">
                                @error('mobile')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Role Selector --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">I want to join as <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-terracotta-500 has-[:checked]:bg-terracotta-50 border-gray-200 hover:border-gray-300 bg-white">
                                    <input type="radio" name="role" value="organizer" class="sr-only peer" {{ old('role', 'organizer') === 'organizer' ? 'checked' : '' }}>
                                    <svg class="w-7 h-7 text-gray-400 peer-checked:text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-terracotta-700">Organizer</span>
                                </label>
                                <label class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-terracotta-500 has-[:checked]:bg-terracotta-50 border-gray-200 hover:border-gray-300 bg-white">
                                    <input type="radio" name="role" value="sponsor" class="sr-only peer" {{ old('role') === 'sponsor' ? 'checked' : '' }}>
                                    <svg class="w-7 h-7 text-gray-400 peer-checked:text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-terracotta-700">Sponsor</span>
                                </label>
                                <label class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-terracotta-500 has-[:checked]:bg-terracotta-50 border-gray-200 hover:border-gray-300 bg-white">
                                    <input type="radio" name="role" value="partner" class="sr-only peer" {{ old('role') === 'partner' ? 'checked' : '' }}>
                                    <svg class="w-7 h-7 text-gray-400 peer-checked:text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-terracotta-700">Partner</span>
                                </label>
                            </div>
                            @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div x-data="{ showPassword: false }">
                                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password"
                                        placeholder="Min 8 characters"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition pr-11">
                                    <span @click="showPassword = !showPassword" class="absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </span>
                                </div>
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div x-data="{ showConfirm: false }">
                                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required autocomplete="new-password"
                                        placeholder="Re-enter password"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-terracotta-400 focus:ring-3 focus:ring-terracotta-100 focus:outline-none transition pr-11">
                                    <span @click="showConfirm = !showConfirm" class="absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showConfirm" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showConfirm" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </span>
                                </div>
                                @error('password_confirmation')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="terms" id="terms" class="mt-0.5 h-4 w-4 rounded border-gray-300 text-terracotta-600 focus:ring-terracotta-500" required>
                            <label for="terms" class="text-sm text-gray-600 leading-relaxed">
                                I agree to the
                                <a href="/terms" class="font-semibold text-terracotta-600 hover:text-terracotta-700 transition">Terms of Service</a>
                                and
                                <a href="/privacy" class="font-semibold text-terracotta-600 hover:text-terracotta-700 transition">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" class="bg-terracotta-500 hover:bg-terracotta-700 shadow-sm hover:shadow-md flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-semibold text-white transition">
                            Create Account
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-terracotta-600 hover:text-terracotta-700 transition">Sign In</a>
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>
