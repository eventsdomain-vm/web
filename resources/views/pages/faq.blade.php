<x-guest-layout>
    <x-slot name="title">FAQ - EventsDomain</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: url('/images/partners-hero.jpg');">
        <div class="absolute inset-0 bg-gradient-to-br from-terracotta-900/80 via-terracotta-700/60 to-terracotta-500/40"></div>
        <div class="container-page text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Frequently Asked Questions</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">Find answers to common questions about EventsDomain</p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6" x-data="{ open: null }">
                <!-- FAQ 1 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">What is EventsDomain?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">EventsDomain is India's premier B2B Event Sponsorship & Partnership Marketplace. We connect event organizers with sponsors and partners to create successful events.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">How do I post an event?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">To post an event, create a free account as an organizer. Once logged in, you can create events, set up sponsorship packages, and start receiving requests from sponsors.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">How much does it cost?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Creating an account and posting events is completely free. We charge a small service fee only when a sponsorship deal is successfully closed through our platform.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">How do sponsorships work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 4 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Organizers create events with sponsorship packages. Sponsors browse events, select packages, and submit requests. Once both parties agree on terms, a contract is created and managed through the platform.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 5 ? null : 5" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">Can I become a partner on the platform?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 5 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 5" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Yes! Partners can offer services like catering, AV equipment, decoration, photography, and more. Create a partner account, list your services, and start receiving bids from event organizers.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 6 ? null : 6" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">Is my information secure?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 6 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 6" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">Absolutely. We use industry-standard encryption and security measures to protect your data. Your information is never shared with third parties without your consent.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="card border border-gray-100 overflow-hidden">
                    <button @click="open = open === 7 ? null : 7" class="w-full px-6 py-4 text-left flex items-center justify-between">
                        <span class="font-semibold text-gray-900">How do I contact support?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 7 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 7" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600">You can reach us at support@eventsdomain.com or call us at +91 97250 98250. Our support team is available Monday to Friday, 9 AM to 6 PM IST.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
