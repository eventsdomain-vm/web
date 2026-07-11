<x-guest-layout>
    <x-slot name="title">Pricing - EventsDomain</x-slot>

    <section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
        <div class="container-page text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Simple, Transparent Pricing</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">Start for free. Pay only when you close a deal.</p>
        </div>
    </section>

    <section class="py-20">
        <div class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="card border border-gray-200 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Starter</h3>
                    <p class="text-gray-500 mb-6">Perfect for getting started</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">₹0</span>
                        <span class="text-gray-500">/forever</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Up to 3 events</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Basic sponsorship packages</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Direct messaging</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-outline w-full block text-center">Get Started</a>
                </div>

                <!-- Pro Plan -->
                <div class="card shadow-lg border-2 border-terracotta-500 p-8 relative">
                    <div class="absolute top-0 right-0 bg-terracotta-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-xl text-sm font-semibold">
                        Popular
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Professional</h3>
                    <p class="text-gray-500 mb-6">For serious organizers</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">₹4,999</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Unlimited events</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Featured event listings</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Priority support</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary w-full block text-center">Start Free Trial</a>
                </div>

                <!-- Enterprise Plan -->
                <div class="card border border-gray-200 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Enterprise</h3>
                    <p class="text-gray-500 mb-6">For large organizations</p>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">Custom</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Everything in Professional</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>White-label solution</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>API access</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Dedicated account manager</span>
                        </li>
                    </ul>
                    <a href="/contact" class="btn-outline w-full block text-center">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
