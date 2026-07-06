<x-guest-layout>
    <x-slot name="title">Contact Us - EventsDomain</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
        <div class="container-page text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Contact Us</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">Have questions? We'd love to hear from you.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20">
        <div class="container-page">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="card p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="label">First Name</label>
                                <input type="text" class="input-field" placeholder="John">
                            </div>
                            <div>
                                <label class="label">Last Name</label>
                                <input type="text" class="input-field" placeholder="Doe">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label class="label">Email</label>
                            <input type="email" class="input-field" placeholder="john@example.com">
                        </div>
                        <div class="mt-6">
                            <label class="label">Subject</label>
                            <input type="text" class="input-field" placeholder="How can we help?">
                        </div>
                        <div class="mt-6">
                            <label class="label">Message</label>
                            <textarea class="input-field" rows="5" placeholder="Your message..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary mt-6 w-full">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Get in Touch</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-terracotta-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium text-gray-900">support@eventsdomain.com</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-terracotta-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium text-gray-900">+91 97250 98250</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-terracotta-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Address</p>
                                    <p class="font-medium text-gray-900">Mumbai, Maharashtra, India</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-terracotta-500 rounded-xl p-8 text-white">
                        <h3 class="text-xl font-bold mb-4">Business Hours</h3>
                        <div class="space-y-2">
                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday: 10:00 AM - 4:00 PM</p>
                            <p>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
