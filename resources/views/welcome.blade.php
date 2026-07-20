<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="EventsDomain - India's B2B Event Sponsorship & Partnership Marketplace connecting Organizers, Sponsors, and Partners">
    <meta name="keywords" content="event sponsorship, B2B events, India, sponsors, partners, event organizers, sponsorship marketplace">
    <meta property="og:title" content="EventsDomain - B2B Event Sponsorship Marketplace">
    <meta property="og:description" content="India's premier platform connecting event organizers with sponsors and partners">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://eventsdomain.com">
    <title>EventsDomain - B2B Event Sponsorship & Partnership Marketplace</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    @include('partials.tracking-head')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/feature-events-ticket.css'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    <x-public-header />

    {{-- ═══════════════════════════════════════════
         1. HERO SECTION
    ═══════════════════════════════════════════ --}}
    <section class="relative pt-16 lg:pt-18 overflow-hidden bg-gradient-to-br from-terracotta-50 via-white to-terracotta-50/50 min-h-[85vh] flex items-center">
        <div class="absolute inset-0 opacity-[0.08]">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-terracotta-400 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-terracotta-200 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl"></div>
        </div>
        <div class="bg-pattern absolute inset-0 opacity-[0.03]"></div>

        <div class="container-page relative z-10 py-16 md:py-24">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center bg-terracotta-100/50 rounded-full px-4 py-2 mb-8 border border-terracotta-200/50">
                    <span class="w-2 h-2 bg-terracotta-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-terracotta-700 text-sm font-semibold">India's #1 Event Sponsorship Platform</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight tracking-tight mb-6">
                    Create Unforgettable Events with the
                    <span class="text-terracotta-500"> Right Partnerships</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Ready to Transform Your Events? The B2B marketplace where organizers meet sponsors and partners to build something remarkable.
                </p>

                {{-- Category & City Filters --}}
                <div class="bg-white shadow-xl border border-gray-100 rounded-2xl p-4 md:p-6 mb-10 max-w-3xl mx-auto">
                    <form action="{{ route('events.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <select name="category" class="input-field input-lg w-full">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="city" class="input-field input-lg w-full">
                                <option value="">All Cities</option>
                                <option value="Mumbai">Mumbai</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Bangalore">Bangalore</option>
                                <option value="Hyderabad">Hyderabad</option>
                                <option value="Chennai">Chennai</option>
                                <option value="Kolkata">Kolkata</option>
                                <option value="Pune">Pune</option>
                                <option value="Ahmedabad">Ahmedabad</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-lg whitespace-nowrap">
                            <svg class="w-5 h-5 mr-1.5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Find Events
                        </button>
                    </form>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                    <a href="{{ route('register') }}" class="btn-primary btn-lg group">
                        Post Your Event Free
                        <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#events" class="btn-outline btn-lg">
                        Browse Events
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         2. TRUST INDICATORS
    ═══════════════════════════════════════════ --}}
    <section class="section py-12 md:py-16" style="background-color: #EDF2F2">
        <div class="container-page">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2">
                    <div class="text-3xl md:text-4xl font-bold text-terracotta-600">500+</div>
                    <div class="text-sm text-gray-500 font-medium">Events Listed</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl md:text-4xl font-bold text-terracotta-600">1,200+</div>
                    <div class="text-sm text-gray-500 font-medium">Sponsors Onboarded</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl md:text-4xl font-bold text-terracotta-600">800+</div>
                    <div class="text-sm text-gray-500 font-medium">Brands Connected</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl md:text-4xl font-bold text-terracotta-600">50+</div>
                    <div class="text-sm text-gray-500 font-medium">Cities Covered</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         3. HOW IT WORKS
    ═══════════════════════════════════════════ --}}
    <section id="how-it-works" class="section">
        <div class="container-page">
            <div class="text-center mb-16">
                <span class="section-label">Simple Process</span>
                <h2 class="section-title mt-3">How It Works</h2>
                <p class="section-subtitle mt-4 mx-auto">Three simple steps to connect events with the right sponsors and partners</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-500 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Post Your Event</h3>
                    <p class="text-gray-500 leading-relaxed">Create your event listing with details, goals, and sponsorship packages. It's free to get started.</p>
                </div>

                <div class="text-center group relative">
                    <div class="hidden md:block absolute top-8 left-0 right-0 h-0.5 bg-gray-200 -z-10" style="width: 80%; margin: 0 auto;"></div>
                    <div class="w-16 h-16 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-500 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Get Matched</h3>
                    <p class="text-gray-500 leading-relaxed">Our smart matching connects you with relevant sponsors and partners based on your event category and goals.</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-terracotta-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-terracotta-500 group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="heading-3 mb-3">Collaborate</h3>
                    <p class="text-gray-500 leading-relaxed">Negotiate terms, sign contracts, and manage your partnerships all in one place. Track ROI in real-time.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         4. CORE CATEGORIES
    ═══════════════════════════════════════════ --}}
    <section class="section section-alt">
        <div class="container-page">
            <div class="text-center mb-16">
                <span class="section-label">Event Categories</span>
                <h2 class="section-title mt-3">Explore by Category</h2>
                <p class="section-subtitle mt-4 mx-auto">From business conferences to music festivals, find opportunities that match your brand</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card-hover p-8 text-center cursor-pointer group">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-blue-100 transition">
                        <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Business Events</h3>
                    <p class="text-gray-500 text-sm">Conferences, Seminars, Trade Shows, Product Launches, Networking Events</p>
                </div>

                <div class="card-hover p-8 text-center cursor-pointer group">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-purple-100 transition">
                        <svg class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Entertainment</h3>
                    <p class="text-gray-500 text-sm">Music Concerts, Live Shows, Fashion Shows, Sports Events, Esports</p>
                </div>

                <div class="card-hover p-8 text-center cursor-pointer group">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-amber-100 transition">
                        <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Festivals & Community</h3>
                    <p class="text-gray-500 text-sm">Cultural Festivals, Food Festivals, Charity Events, Government Events</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
          5. FEATURED EVENTS — Ticket Layout
     ═══════════════════════════════════════════ --}}
     <section id="events" class="py-16 md:py-24" style="background: linear-gradient(180deg, #f0f2f5 0%, #f9fafb 30%, #ffffff 100%);">
         <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

             {{-- Section Header --}}
             <div class="text-center mb-10">
                 <span class="section-label">Featured Events</span>
                 <h2 class="section-title mt-3">Discover Exciting Opportunities</h2>
                 <p class="section-subtitle mt-4 mx-auto">Explore events looking for sponsors and partners</p>
                 <div class="ticket-section-accent mx-auto mt-3"></div>
                 {{-- White divider line between subtitle and dots --}}
                 <hr class="ticket-header-divider">
             </div>

             @if($featuredEvents->isNotEmpty())
                 {{-- Carousel Wrapper (Alpine.js powered) --}}
                 <div
                     x-data="{
                         activeSlide: 0,
                         total: {{ count($featuredEvents) }},
                         paused: false,
                         timer: null,
                         progress: 0,
                         progressTimer: null,
                         interval: 4000,
                         _touchStartX: 0,
                         _touchEndX: 0,
                         init() {
                             this.startAutoPlay();
                             this.$el.addEventListener('mouseenter', () => { this.paused = true; this.clearTimers(); });
                             this.$el.addEventListener('mouseleave', () => { this.paused = false; this.startAutoPlay(); });
                         },
                         startAutoPlay() {
                             this.clearTimers();
                             this.progress = 0;
                             const step = 50;
                             this.progressTimer = setInterval(() => {
                                 this.progress += (step / this.interval) * 100;
                                 if (this.progress >= 100) this.progress = 100;
                             }, step);
                             this.timer = setInterval(() => {
                                 this.activeSlide = (this.activeSlide + 1) % this.total;
                                 this.progress = 0;
                             }, this.interval);
                         },
                         clearTimers() {
                             clearInterval(this.timer);
                             clearInterval(this.progressTimer);
                             this.progress = 0;
                         },
                         goTo(index) {
                             this.activeSlide = index;
                             this.startAutoPlay();
                         },
                         prev() { this.goTo((this.activeSlide - 1 + this.total) % this.total); },
                         next() { this.goTo((this.activeSlide + 1) % this.total); }
                     }"
                     x-init="init()"
                     class="relative w-full">

                     {{-- Carousel Dots + Auto-scroll indicator --}}
                     <div class="flex flex-col items-center gap-2 mb-8">
                         <div class="flex justify-center items-center gap-2">
                             <template x-for="(dot, index) in total" :key="index">
                                 <button @click="goTo(index)"
                                         class="ticket-slider-dot cursor-pointer"
                                         :class="activeSlide === index ? 'active' : ''"
                                         :aria-label="'Go to slide ' + (index + 1)"></button>
                             </template>
                         </div>
                         {{-- Subtle progress bar showing auto-scroll timer --}}
                         <div class="flex items-center gap-2">
                             <div class="w-24 h-0.5 bg-gray-200 rounded-full overflow-hidden" title="Auto-scrolling">
                                 <div class="h-full bg-[#F26C4F] rounded-full transition-none"
                                      :style="'width:' + progress + '%'"
                                      :class="paused ? 'opacity-30' : 'opacity-80'"></div>
                             </div>
                             <span class="text-[10px] text-gray-400 font-medium" x-text="paused ? '⏸ Paused' : '▶ Auto'"></span>
                         </div>
                     </div>

                     {{-- Carousel Track with Prev/Next arrows --}}
                     <div class="overflow-visible relative"
                          x-on:touchstart.passive="_touchStartX = $event.changedTouches[0].screenX"
                          x-on:touchend.passive="_touchEndX = $event.changedTouches[0].screenX; (_touchStartX - _touchEndX > 50) ? next() : (_touchEndX - _touchStartX > 50 ? prev() : null)">

                         {{-- Prev Arrow --}}
                         <button @click="prev()"
                                 x-show="total > 1"
                                 class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-5 z-20 w-10 h-10 rounded-full bg-white shadow-lg border border-gray-100 items-center justify-center text-gray-500 hover:text-[#F26C4F] hover:border-[#F26C4F] hover:shadow-xl transition-all duration-200 hidden md:flex"
                                 aria-label="Previous event">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                             </svg>
                         </button>

                         <div class="relative overflow-hidden rounded-[26px]">
                             <div class="flex transition-transform duration-500 ease-out"
                                  :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                                  @foreach($featuredEvents as $event)
                                      <div class="w-full shrink-0">
                                          <div class="ticket-card-wrapper ticket-animate">
                                              <a href="{{ route('events.show', $event->slug ?? $event->id) }}" class="group block">
                                                  <div class="ticket-card">

                                                      {{-- ▸ LEFT: Event Image & Explore Button (38% ratio) --}}
                                                      <div class="ticket-image-section">
                                                          @if($event->cover_image_url)
                                                              <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="ticket-bg-image">
                                                          @else
                                                              <img src="{{ asset('images/ticket_bg.jpg') }}" alt="Event" class="ticket-bg-image">
                                                          @endif

                                                          {{-- Dark Overlay --}}
                                                          <div class="ticket-image-overlay"></div>

                                                          {{-- Centered Explore Button --}}
                                                          <button onclick="event.preventDefault(); window.location='{{ route('events.show', $event->slug ?? $event->id) }}'"
                                                                  class="ticket-cta-btn">
                                                              <span>Explore Event</span>
                                                              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                              </svg>
                                                          </button>
                                                      </div>

                                                      {{-- ▸ PERFORATION LINE (vertical divider) --}}
                                                      <div class="ticket-perforation"></div>

                                                      {{-- ▸ RIGHT: Dynamic Event Details Section (62% ratio) --}}
                                                      <div class="ticket-content-section">
                                                          {{-- Top: Badges --}}
                                                          <div class="flex justify-between items-start gap-4">
                                                              {{-- Live Opportunities Badge --}}
                                                              <span class="ticket-live-badge ticket-live-badge--live">
                                                                  <span class="ticket-badge-dot"></span>
                                                                  LIVE OPPORTUNITIES
                                                              </span>

                                                              {{-- Sponsorship Type (e.g. PAID/BARTER) --}}
                                                              <span class="ticket-type-badge rounded-xl px-3 py-1.5 text-xs font-semibold">
                                                                  @if($event->sponsorship_type)
                                                                      {{ $event->sponsorship_type === 'paid' ? '💳 PAID' : ($event->sponsorship_type === 'barter' ? '🔄 BARTER' : '💎 HYBRID') }}
                                                                  @else
                                                                      ✨ OPEN
                                                                  @endif
                                                              </span>
                                                          </div>

                                                          {{-- Middle: Event Title & Description --}}
                                                          <div class="my-6">
                                                              <h3 class="ticket-title text-xl md:text-2xl font-bold mb-2 leading-tight">
                                                                  {{ $event->title }}
                                                              </h3>
                                                              <p class="ticket-description text-xs md:text-sm line-clamp-3">
                                                                  {{ Str::limit($event->description, 160) }}
                                                              </p>
                                                          </div>

                                                           {{-- Bottom: Stats Row + Branding --}}
                                                           <div class="mt-auto">
                                                               {{-- All 4 stats in one flex row with vertical pipe dividers --}}
                                                               <div style="display:flex; flex-direction:row; align-items:flex-start; padding-bottom:16px; border-bottom:1px solid rgba(255,255,255,0.1); margin-bottom:16px;">
                                                                   {{-- Date & Time --}}
                                                                   <div style="flex:1; min-width:0; padding-right:12px;">
                                                                       <span class="ticket-stat-label">Date & Time</span>
                                                                       <div class="ticket-stat-val">{{ $event->start_date ? $event->start_date->format('M d, Y') : 'TBA' }}</div>
                                                                   </div>
                                                                   {{-- Divider --}}
                                                                   <div style="width:1px; background:rgba(255,255,255,0.15); margin:2px 0; align-self:stretch;"></div>
                                                                   {{-- City / State --}}
                                                                   <div style="flex:1; min-width:0; padding:0 12px;">
                                                                       <span class="ticket-stat-label">City / State</span>
                                                                       <div class="ticket-stat-val">{{ $event->city ?? ($event->location ?? 'India') }}</div>
                                                                   </div>
                                                                   {{-- Divider --}}
                                                                   <div style="width:1px; background:rgba(255,255,255,0.15); margin:2px 0; align-self:stretch;"></div>
                                                                   {{-- Ticket Cost --}}
                                                                   <div style="flex:1; min-width:0; padding:0 12px;">
                                                                       <span class="ticket-stat-label">Ticket Cost</span>
                                                                       <div class="ticket-stat-val">
                                                                           @if($event->min_sponsorship_amount)
                                                                               @php
                                                                                   $amt = $event->min_sponsorship_amount;
                                                                                   $formatted = $amt >= 100000 ? number_format($amt/100000, 1).'L+' : ($amt >= 1000 ? number_format($amt/1000, 0).'K+' : '₹'.$amt);
                                                                               @endphp
                                                                               ₹{{ $formatted }}
                                                                           @else
                                                                               Open
                                                                           @endif
                                                                       </div>
                                                                   </div>
                                                                   {{-- Divider --}}
                                                                   <div style="width:1px; background:rgba(255,255,255,0.15); margin:2px 0; align-self:stretch;"></div>
                                                                   {{-- Expected Crowd --}}
                                                                   <div style="flex:1; min-width:0; padding-left:12px; text-align:right;">
                                                                       <span class="ticket-stat-label">Expected Crowd</span>
                                                                       <div class="ticket-stat-val">
                                                                           @php
                                                                               $crowd = $event->expected_audience ?? 500;
                                                                               $crowdFmt = $crowd >= 100000 ? number_format($crowd/100000,1).'L+' : ($crowd >= 1000 ? number_format($crowd/1000,0).'K+' : $crowd.'+');
                                                                           @endphp
                                                                           {{ $crowdFmt }}
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                               {{-- Branding: use footer logo instead of text --}}
                                                               <div class="flex items-center justify-between">
                                                                   <div class="flex flex-col">
                                                                       <img src="{{ asset('logo-white.png') }}" alt="EventsDomain" style="height:28px; width:auto; object-fit:contain;">
                                                                       <span class="text-[9px] text-gray-400" style="margin-top:2px;">The bridge between brands & experiences.</span>
                                                                   </div>
                                                                   <span class="ticket-category-pill rounded-full px-3 py-1 text-xs font-semibold">
                                                                       {{ $event->category->name ?? 'General' }}
                                                                   </span>
                                                               </div>
                                                           </div>
                                                       </div>{{-- end ticket-content-section --}}

                                                  </div>{{-- end ticket-card --}}
                                              </a>
                                          </div>{{-- end ticket-card-wrapper --}}
                                      </div>
                                  @endforeach
                             </div>
                         </div>

                         {{-- Next Arrow --}}
                         <button @click="next()"
                                 x-show="total > 1"
                                 class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-5 z-20 w-10 h-10 rounded-full bg-white shadow-lg border border-gray-100 items-center justify-center text-gray-500 hover:text-[#F26C4F] hover:border-[#F26C4F] hover:shadow-xl transition-all duration-200 hidden md:flex"
                                 aria-label="Next event">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                             </svg>
                         </button>
                     </div>
                 </div>
             @else
                 <div class="text-center py-16 bg-white rounded-3xl shadow-elegant border-2 border-dashed border-gray-200">
                     <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                         <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                         </svg>
                     </div>
                     <h3 class="text-xl font-semibold text-gray-900 mb-2">No events found</h3>
                     <p class="text-gray-600 mb-6">Try adjusting your filters or check back later for new opportunities.</p>
                     <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 bg-terracotta-500 hover:bg-terracotta-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                         Browse All Events
                     </a>
                 </div>
             @endif
         </div>
     </section>

     <div class="text-center mt-12 mb-8">
         <a href="{{ route('events.index') }}" class="btn-primary btn-lg group">
             View All Events
             <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
             </svg>
         </a>
     </div>

    {{-- ═══════════════════════════════════════════
         6. FOR ORGANIZERS SECTION
    ═══════════════════════════════════════════ --}}
    <section class="section" style="background-color: #4A6362">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="section-label text-terracotta-200">For Organizers</span>
                    <h2 class="heading-2 text-white mt-3 mb-6">Create Unforgettable Events with the Right Partnerships</h2>
                    <p class="text-white/70 text-lg mb-8 leading-relaxed">Ready to Transform Your Events? Join thousands of organizers, sponsors, and partners who are already using EventsDomain to create successful events.</p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-white/85">Create and manage multi-tier sponsorship packages</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-white/85">Smart matching with relevant sponsors</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-white/85">Secure contract management</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-white/85">Real-time ROI tracking and analytics</span>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn-white btn-lg group">
                        Start Free Today
                        <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>

                <div class="card-glass p-8">
                    <div class="space-y-4">
                        <div class="bg-white/10 rounded-xl p-4 flex items-center justify-between">
                            <span class="text-white/80 font-medium">Active Sponsorships</span>
                            <span class="text-terracotta-100 font-bold text-xl">12</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 flex items-center justify-between">
                            <span class="text-white/80 font-medium">Total Funding</span>
                            <span class="text-terracotta-100 font-bold text-xl">₹45,00,000</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 flex items-center justify-between">
                            <span class="text-white/80 font-medium">Partner Requests</span>
                            <span class="text-terracotta-100 font-bold text-xl">28</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 flex items-center justify-between">
                            <span class="text-white/80 font-medium">Conversion Rate</span>
                            <span class="text-terracotta-100 font-bold text-xl">68%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         7. FOR SPONSORS SECTION
    ═══════════════════════════════════════════ --}}
    <section id="sponsors" class="section">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="bg-gray-50 rounded-2xl p-8 space-y-4">
                        <div class="bg-white rounded-xl p-4 shadow-card flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900">TechSummit India 2026</div>
                                <div class="text-sm text-gray-500">Gold Sponsor &bull; ₹5,00,000</div>
                            </div>
                            <span class="badge-success flex-shrink-0">Active</span>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-card flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900">Startup India Summit</div>
                                <div class="text-sm text-gray-500">Silver Sponsor &bull; ₹2,50,000</div>
                            </div>
                            <span class="badge-warning flex-shrink-0">Pending</span>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-card flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900">India Music Festival</div>
                                <div class="text-sm text-gray-500">Title Sponsor &bull; ₹10,00,000</div>
                            </div>
                            <span class="badge-success flex-shrink-0">Confirmed</span>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <span class="section-label">For Sponsors</span>
                    <h2 class="heading-2 mt-3 mb-6">Find Events That Match Your Brand</h2>
                    <p class="text-gray-500 text-lg mb-8 leading-relaxed">Discover sponsorship opportunities that align with your brand values and target audience. Track your sponsorship ROI in real-time.</p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Smart event discovery and matching</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Direct communication with organizers</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Performance analytics and reporting</span>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn-primary btn-lg group">
                        Become a Sponsor
                        <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         8. FOR PARTNERS SECTION
    ═══════════════════════════════════════════ --}}
    <section id="partners" class="section section-alt">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="section-label">Partner Network</span>
                    <h2 class="heading-2 mt-3 mb-6">Showcase Your Services & Grow Your Business</h2>
                    <p class="text-gray-500 text-lg mb-8 leading-relaxed">Whether you provide venues, sound, catering, or photography — list your services, bid on opportunities, and connect with event organizers worldwide.</p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">List services with pricing & availability</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Bid on organizer requests & opportunities</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Cost, Barter, and Hybrid pricing models</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-terracotta-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <span class="text-gray-700">Portfolio showcase and reviews from organizers</span>
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn-primary btn-lg group">
                        Join as Partner
                        <svg class="w-5 h-5 ml-2 inline transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="card p-5 text-center">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <div class="font-semibold text-gray-900 text-sm">Venues</div>
                        </div>
                        <div class="card p-5 text-center">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                            </div>
                            <div class="font-semibold text-gray-900 text-sm">Sound & Light</div>
                        </div>
                    </div>
                    <div class="space-y-4 mt-6">
                        <div class="card p-5 text-center">
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
                            </div>
                            <div class="font-semibold text-gray-900 text-sm">Catering</div>
                        </div>
                        <div class="card p-5 text-center">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div class="font-semibold text-gray-900 text-sm">Photography</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         9. WHY EVENTS DOMAIN
    ═══════════════════════════════════════════ --}}
    <section class="section">
        <div class="container-page">
            <div class="text-center mb-16">
                <span class="section-label">Why EventsDomain</span>
                <h2 class="section-title mt-3">The Smarter Way to Sponsor</h2>
                <p class="section-subtitle mt-4 mx-auto">Built for the modern event ecosystem — faster discovery, verified partners, and direct communication</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card p-8 flex gap-5">
                    <div class="w-12 h-12 bg-terracotta-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-terracotta-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Faster Discovery</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Find relevant sponsorship opportunities in seconds, not weeks. Smart filters by category, budget, and audience.</p>
                    </div>
                </div>

                <div class="card p-8 flex gap-5">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Verified Ecosystem</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Every organizer, sponsor, and partner is verified. Build trust through reviews, ratings, and verified badges.</p>
                    </div>
                </div>

                <div class="card p-8 flex gap-5">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Smart Filtering</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Search by industry, location, audience size, budget range, and sponsorship type. Find exactly what fits your brand.</p>
                    </div>
                </div>

                <div class="card p-8 flex gap-5">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Direct Communication</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">No middlemen. Chat directly with organizers and sponsors. Negotiate terms, share proposals, close deals faster.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         10. FINAL CTA SECTION
    ═══════════════════════════════════════════ --}}
    <section class="section relative overflow-hidden" style="background-color: #4A6362">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-terracotta-400 rounded-full translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-terracotta-300 rounded-full -translate-x-1/2 translate-y-1/2 blur-3xl"></div>
        </div>
        <div class="container-page relative z-10 text-center">
            <h2 class="heading-2 text-white mb-6">Ready to Transform Your Events?</h2>
            <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto">Join thousands of organizers, sponsors, and partners who are already using EventsDomain to create successful events.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto mb-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-3xl font-bold text-white mb-2">🎤</div>
                    <h3 class="font-bold text-white mb-1">Event Organizers</h3>
                    <p class="text-white/60 text-sm">List your event & attract the right sponsors</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-3xl font-bold text-white mb-2">🏢</div>
                    <h3 class="font-bold text-white mb-1">Sponsors & Brands</h3>
                    <p class="text-white/60 text-sm">Discover opportunities that match your brand</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-3xl font-bold text-white mb-2">🤝</div>
                    <h3 class="font-bold text-white mb-1">Service Partners</h3>
                    <p class="text-white/60 text-sm">Showcase services & grow your business</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-white btn-lg">Get Started Free</a>
                <a href="/contact" class="btn btn-lg border-2 border-white/30 text-white hover:bg-white/10">Contact Sales</a>
            </div>
        </div>
    </section>

    <x-public-footer />

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "EventsDomain",
        "url": "https://eventsdomain.com",
        "description": "India's B2B Event Sponsorship & Partnership Marketplace",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": "https://eventsdomain.com/events?q={search_term_string}",
            "query-input": "required name=search_term_string"
    </script>
</body>
</html>
