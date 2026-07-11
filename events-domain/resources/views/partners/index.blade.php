<x-guest-layout>
    <x-slot name="title">Partner With Us - EventsDomain</x-slot>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden text-white bg-cover bg-center" style="background-image: url('/images/partners-hero.jpg');">
        <div class="absolute inset-0 bg-gradient-to-br from-terracotta-900/80 via-terracotta-700/60 to-terracotta-500/40"></div>
        <div class="container-page py-20 lg:py-28 text-center relative z-10">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium text-orange-100 mb-6 border border-white/10">Partnership</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">Partner With Us</h1>
            <p class="text-lg md:text-xl text-orange-100/80 max-w-2xl mx-auto leading-relaxed">Join our network of trusted partners and grow your business alongside the leading event sponsorship platform in the industry.</p>
        </div>
    </section>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="container-page mt-6">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-6 py-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Partnership Opportunities --}}
    <section class="py-20 lg:py-24 bg-gray-50">
        <div class="container-page">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Partnership Opportunities</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">We offer various partnership models tailored to your business needs.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Event Agencies --}}
                <div class="card-hover p-8 text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 bg-terracotta-100 rounded-2xl flex items-center justify-center group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-600 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Event Agencies</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Partner with us to offer your clients access to our extensive sponsor network and streamlined matching.</p>
                </div>

                {{-- Venues & Destinations --}}
                <div class="card-hover p-8 text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 bg-terracotta-100 rounded-2xl flex items-center justify-center group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-600 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Venues & Destinations</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Showcase your venue to event organizers looking for the perfect location for sponsored events.</p>
                </div>

                {{-- Media Partners --}}
                <div class="card-hover p-8 text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 bg-terracotta-100 rounded-2xl flex items-center justify-center group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-600 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Media Partners</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Collaborate on content, co-marketing initiatives, and expand your reach in the event industry.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Partner With Us + Contact Form --}}
    <section class="py-20 lg:py-24 bg-gray-50">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                {{-- Left: Why Partner With Us --}}
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5">Why Partner With Us?</h2>
                    <p class="text-gray-500 text-lg mb-8 leading-relaxed">As an EventsDomain partner, you'll gain access to exclusive benefits designed to help you grow your business and serve your clients better.</p>

                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Access to premium event listings and sponsor database</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Co-marketing opportunities and brand exposure</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Commission-based referral programs</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Featured placement on our platform</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Dedicated partner support and resources</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-700">Early access to new features and tools</span>
                        </li>
                    </ul>
                </div>

                {{-- Right: Get in Touch Form --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-900 px-8 py-5">
                        <h2 class="text-xl font-semibold text-white">Get in Touch</h2>
                    </div>
                    <div class="p-8">
                        <form method="POST" action="{{ route('partners.store') }}" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 text-sm"
                                        placeholder="Your name">
                                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 text-sm"
                                        placeholder="you@company.com">
                                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1.5">Company Name <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" id="company_name" required value="{{ old('company_name') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 text-sm"
                                    placeholder="Your company">
                                @error('company_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="partnership_type" class="block text-sm font-medium text-gray-700 mb-1.5">Partnership Type <span class="text-red-500">*</span></label>
                                <select name="partnership_type" id="partnership_type" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 text-sm">
                                    <option value="" disabled {{ old('partnership_type') ? '' : 'selected' }}>Select partnership type</option>
                                    <option value="event_agency" {{ old('partnership_type') == 'event_agency' ? 'selected' : '' }}>Event Agency</option>
                                    <option value="venue" {{ old('partnership_type') == 'venue' ? 'selected' : '' }}>Venue / Destination</option>
                                    <option value="media" {{ old('partnership_type') == 'media' ? 'selected' : '' }}>Media Partner</option>
                                    <option value="technology" {{ old('partnership_type') == 'technology' ? 'selected' : '' }}>Event Technology</option>
                                    <option value="other" {{ old('partnership_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('partnership_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" required rows="4"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 text-sm"
                                    placeholder="Tell us about your organization and how you'd like to partner with us...">{{ old('message') }}</textarea>
                                @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                    Send Partnership Enquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-guest-layout>
