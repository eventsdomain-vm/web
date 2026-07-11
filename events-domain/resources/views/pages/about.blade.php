<x-guest-layout>
    <x-slot name="title">About Us - EventsDomain</x-slot>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-terracotta-950 via-terracotta-900 to-terracotta-800 py-24 md:py-32">
        <div class="absolute inset-0">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-terracotta-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-terracotta-500/15 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxmaWx0ZXIgaWQ9Im4iPjxmZVR1cmJ1bGVuY2UgdHlwZT0iZnJhY3RhbE5vaXNlIiBiYXNlRnJlcXVlbmN5PSIuOTUiIHN0aXRjaFRpbGVzPSJzdGl0Y2giLz48L2ZpbHRlcj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWx0ZXI9InVybCgjbikiIG9wYWNpdHk9Ii4wMyIvPjwvc3ZnPg==')] opacity-10 pointer-events-none"></div>

        <div class="container-page relative">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-yellow-300/10 text-yellow-300 text-sm font-medium mb-8 backdrop-blur-sm border border-yellow-300/20">
                    <span class="w-2 h-2 rounded-full bg-yellow-300 animate-pulse"></span>
                    India's Leading B2B Event Sponsorship Marketplace
                </span>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 tracking-tight">
                    Connecting Events
                    <br class="hidden md:inline" /> the Right Sponsors
                </h1>
                <p class="text-lg md:text-xl text-white/80 max-w-3xl mx-auto mb-10 leading-relaxed">
                    India's premier B2B marketplace bridging the gap between event organizers seeking sponsorship and brands looking for impactful partnerships.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-terracotta-900 font-semibold text-lg rounded-xl hover:bg-terracotta-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                        List Your Event
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold text-lg rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 hover:border-white/30 backdrop-blur-sm">
                        Browse Events
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 max-w-4xl mx-auto pt-8 border-t border-white/10">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-1 tracking-tight">500+</div>
                        <div class="text-white/60 text-sm font-medium">Events Listed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-1 tracking-tight">1,000+</div>
                        <div class="text-white/60 text-sm font-medium">Sponsors Connected</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-1 tracking-tight">50+</div>
                        <div class="text-white/60 text-sm font-medium">Cities Covered</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-1 tracking-tight">20+</div>
                        <div class="text-white/60 text-sm font-medium">Categories</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="container-page">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-terracotta-50 text-terracotta-700 text-sm font-semibold mb-5 uppercase tracking-wider">Our Story</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-terracotta-950 mb-5 tracking-tight">Built to Bridge the Gap</h2>
            </div>
            <div class="max-w-4xl mx-auto space-y-6 text-lg text-gray-700 leading-relaxed">
                <p class="text-gray-600">
                    EventsDomain was born from a simple observation: event organizers struggle to find the right sponsors, while brands miss out on incredible partnership opportunities simply because they don't know these events exist. We set out to change that.
                </p>
                <p class="text-gray-600">
                    Today, we've grown into a comprehensive platform that serves event organizers across India, helping them showcase their events to potential sponsors and facilitating meaningful connections that benefit both parties.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="py-20 md:py-28 bg-gray-50">
        <div class="container-page">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-terracotta-50 text-terracotta-700 text-sm font-semibold mb-5 uppercase tracking-wider">Our Values</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-terracotta-950 mb-5 tracking-tight">The Principles That Guide Us</h2>
                <p class="text-lg text-gray-600">These values shape every decision we make and every feature we build.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-terracotta-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-terracotta-950 mb-3">Mission-Driven</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We are committed to bridging the gap between event organizers and sponsors, creating meaningful partnerships.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-terracotta-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-terracotta-950 mb-3">Trust & Transparency</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We believe in building trust through transparent processes and genuine connections.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-terracotta-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-terracotta-950 mb-3">Community First</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Our platform is built around the needs of both organizers and sponsors, fostering a thriving community.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-terracotta-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-terracotta-950 mb-3">Quality Focus</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We curate high-quality events and ensure sponsors find opportunities that align with their brand.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Managed By Section -->
    <section class="py-20 md:py-28 bg-white">
        <div class="container-page">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-terracotta-50 text-terracotta-700 text-sm font-semibold mb-5 uppercase tracking-wider">Managed By</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-terracotta-950 mb-5 tracking-tight">Ajooba Infotech</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-10 max-w-2xl mx-auto">
                    EventsDomain is proudly managed by Ajooba Infotech, a digital marketing and technology company dedicated to creating innovative solutions for the events and marketing industry.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100">
                    <p class="text-xs font-semibold text-terracotta-600 uppercase tracking-wider mb-2">Office Address</p>
                    <p class="text-gray-600 text-sm leading-relaxed">Ahmedabad, Gujarat 380009</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100">
                    <p class="text-xs font-semibold text-terracotta-600 uppercase tracking-wider mb-2">Email</p>
                    <p class="text-gray-600 text-sm"><a href="mailto:hello@eventsdomain.com" class="text-terracotta-600 hover:text-terracotta-700 font-medium">hello@eventsdomain.com</a></p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100">
                    <p class="text-xs font-semibold text-terracotta-600 uppercase tracking-wider mb-2">Phone</p>
                    <p class="text-gray-600 text-sm"><a href="tel:+919725098250" class="text-terracotta-600 hover:text-terracotta-700 font-medium">+91 97250 98250</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-28 bg-gradient-to-br from-terracotta-950 via-terracotta-900 to-terracotta-800 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-terracotta-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-terracotta-500/15 rounded-full blur-3xl"></div>
        </div>
        <div class="container-page relative">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-5 tracking-tight">Ready to Get Started?</h2>
                <p class="text-lg text-white/80 mb-10 max-w-2xl mx-auto">Join thousands of event organizers who have found their perfect sponsors through EventsDomain.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-terracotta-900 font-semibold text-lg rounded-xl hover:bg-terracotta-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                        List Your Event
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold text-lg rounded-xl hover:bg-white/20 transition-all duration-200 border border-white/20 hover:border-white/30 backdrop-blur-sm">
                        Contact Us
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
