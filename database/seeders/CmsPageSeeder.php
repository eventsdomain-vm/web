<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'is_published' => true,
                'meta_title' => 'About Us - EventsDomain',
                'meta_description' => 'India\'s premier B2B Event Sponsorship & Partnership Marketplace',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="relative overflow-hidden bg-gradient-to-br from-terracotta-900 via-terracotta-800 to-terracotta-700 py-24">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
    <div class="container-page text-center relative">
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">Connecting Events with Sponsors</h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">EventsDomain is India's premier B2B marketplace that bridges the gap between event organizers seeking sponsorship and brands looking for impactful partnerships.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/events" class="inline-flex items-center px-6 py-3 bg-white text-terracotta-900 font-semibold rounded-lg hover:bg-terracotta-100 transition shadow-lg">Browse Events</a>
            <a href="/register" class="inline-flex items-center px-6 py-3 bg-terracotta-500 text-white font-semibold rounded-lg hover:bg-terracotta-600 transition shadow-lg">List Your Event</a>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container-page">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-terracotta-500 mb-2">500+</div>
                <div class="text-gray-600 font-medium">Events Listed</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-terracotta-500 mb-2">1000+</div>
                <div class="text-gray-600 font-medium">Sponsors Connected</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-terracotta-500 mb-2">50+</div>
                <div class="text-gray-600 font-medium">Cities Covered</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-terracotta-500 mb-2">20+</div>
                <div class="text-gray-600 font-medium">Categories</div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="container-page">
        <h2 class="text-3xl md:text-4xl font-bold text-terracotta-900 mb-12 text-center">Our Story</h2>
        <div class="max-w-3xl mx-auto space-y-6 text-lg text-gray-700 leading-relaxed">
            <p>EventsDomain was born from a simple observation: event organizers struggle to find the right sponsors, while brands miss out on incredible partnership opportunities simply because they don't know these events exist. We set out to change that.</p>
            <p>Today, we've grown into a comprehensive platform that serves event organizers across India, helping them showcase their events to potential sponsors and facilitating meaningful connections that benefit both parties.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container-page">
        <h2 class="text-3xl md:text-4xl font-bold text-terracotta-900 mb-12 text-center">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-100 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-terracotta-900 mb-3">Mission-Driven</h3>
                <p class="text-gray-600 text-sm leading-relaxed">We are committed to bridging the gap between event organizers and sponsors, creating meaningful partnerships.</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-100 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-terracotta-900 mb-3">Trust & Transparency</h3>
                <p class="text-gray-600 text-sm leading-relaxed">We believe in building trust through transparent processes and genuine connections.</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-100 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-terracotta-900 mb-3">Community First</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Our platform is built around the needs of both organizers and sponsors, fostering a thriving community.</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-100 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-terracotta-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-terracotta-900 mb-3">Quality Focus</h3>
                <p class="text-gray-600 text-sm leading-relaxed">We curate high-quality events and ensure sponsors find opportunities that align with their brand.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="container-page">
        <div class="max-w-3xl mx-auto text-center">
            <p class="text-sm font-semibold text-terracotta-500 uppercase tracking-wider mb-3">Managed by</p>
            <h2 class="text-3xl md:text-4xl font-bold text-terracotta-900 mb-6">Ajooba Infotech</h2>
            <p class="text-lg text-gray-700 leading-relaxed mb-8">EventsDomain is proudly managed by Ajooba Infotech, a digital marketing and technology company dedicated to creating innovative solutions for the events and marketing industry. With years of experience in the field, we understand the unique challenges faced by event organizers and sponsors alike.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left bg-white rounded-xl p-8 border border-gray-100">
                <div>
                    <p class="text-sm font-semibold text-terracotta-500 uppercase tracking-wider mb-2">Office Address</p>
                    <p class="text-gray-600 text-sm leading-relaxed">Ahmedabad, Gujarat 380009</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-terracotta-500 uppercase tracking-wider mb-2">Email</p>
                    <p class="text-gray-600 text-sm"><a href="mailto:hello@eventsdomain.com" class="text-terracotta-500 hover:text-terracotta-600">hello@eventsdomain.com</a></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-terracotta-500 uppercase tracking-wider mb-2">Phone</p>
                    <p class="text-gray-600 text-sm"><a href="tel:+919725098250" class="text-terracotta-500 hover:text-terracotta-600">+91 97250 98250</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-br from-terracotta-900 to-terracotta-700">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Get Started?</h2>
        <p class="text-lg text-white/80 mb-8">Join thousands of event organizers who have found their perfect sponsors through EventsDomain.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register" class="inline-flex items-center px-6 py-3 bg-white text-terracotta-900 font-semibold rounded-lg hover:bg-terracotta-100 transition shadow-lg">List Your Event</a>
            <a href="/contact" class="inline-flex items-center px-6 py-3 bg-terracotta-500 text-white font-semibold rounded-lg hover:bg-terracotta-600 transition shadow-lg border border-white/20">Contact Us</a>
        </div>
    </div>
</section>
HTML
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'is_published' => true,
                'meta_title' => 'Privacy Policy - EventsDomain',
                'meta_description' => 'EventsDomain privacy policy - how we collect, use, and protect your personal information',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Privacy Policy</h1>
        <p class="text-xl text-white/80">Last updated: January 14, 2026</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 prose prose-lg">

<h2>1. Introduction</h2>
<p>EventsDomain ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services. Please read this privacy policy carefully. If you do not agree with the terms of this privacy policy, please do not access the site.</p>

<h2>2. Information We Collect</h2>

<h3>Personal Data</h3>
<p>We may collect personally identifiable information that you voluntarily provide when registering on the platform, including:</p>
<ul>
<li>Name and email address</li>
<li>Phone number</li>
<li>Company/Organization name</li>
<li>Event details and descriptions</li>
<li>Payment information (processed securely through third-party providers)</li>
</ul>

<h3>Automatically Collected Data</h3>
<p>When you access our platform, we automatically collect certain information including your IP address, browser type, operating system, access times, and the pages you have viewed directly before and after accessing the website.</p>

<h2>3. How We Use Your Information</h2>
<p>We use the information we collect to:</p>
<ul>
<li>Create and manage your account</li>
<li>Process event listings and sponsorship enquiries</li>
<li>Send you service-related communications</li>
<li>Respond to your inquiries and provide customer support</li>
<li>Send promotional communications (with your consent)</li>
<li>Improve our platform and develop new features</li>
<li>Detect, prevent, and address technical issues</li>
<li>Comply with legal obligations</li>
</ul>

<h2>4. Information Sharing</h2>
<p>We may share your information in the following situations:</p>
<ul>
<li><strong>With Sponsors:</strong> When sponsors express interest in your event, we share relevant event details and contact information.</li>
<li><strong>With Event Organizers:</strong> When you submit an enquiry, your contact information is shared with the event organizer.</li>
<li><strong>Service Providers:</strong> We may share your data with third-party vendors who assist in operating our platform (payment processors, email services, analytics).</li>
<li><strong>Legal Requirements:</strong> We may disclose information if required by law or in response to valid legal requests.</li>
</ul>

<h2>5. Data Security</h2>
<p>We implement appropriate technical and organizational security measures to protect your personal information. However, no method of transmission over the Internet or electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security.</p>

<h2>6. Data Retention</h2>
<p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this privacy policy, unless a longer retention period is required or permitted by law. When we no longer need to process your information, we will delete or anonymize it.</p>

<h2>7. Your Rights</h2>
<p>Depending on your location, you may have the following rights:</p>
<ul>
<li>Access your personal data</li>
<li>Correct inaccurate data</li>
<li>Request deletion of your data</li>
<li>Object to processing of your data</li>
<li>Request data portability</li>
<li>Withdraw consent at any time</li>
</ul>
<p>To exercise these rights, please contact us at privacy@eventsdomain.com.</p>

<h2 id="cookies">8. Cookies and Tracking</h2>
<p>We use cookies and similar tracking technologies to track activity on our platform and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our platform.</p>

<h2>9. Third-Party Links</h2>
<p>Our platform may contain links to third-party websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services. We strongly advise you to review the privacy policy of every site you visit.</p>

<h2>10. Children's Privacy</h2>
<p>Our platform is not intended for use by children under the age of 18. We do not knowingly collect personal information from children under 18. If you become aware that a child has provided us with personal information, please contact us.</p>

<h2>11. Changes to This Policy</h2>
<p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.</p>

<h2>12. Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us:</p>
<ul>
<li>Email: privacy@eventsdomain.com</li>
<li>Address: Ahmedabad, Gujarat India</li>
</ul>

    </div>
</section>
HTML
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'is_published' => true,
                'meta_title' => 'Terms of Service - EventsDomain',
                'meta_description' => 'EventsDomain terms of service - rules and guidelines for using our platform',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Terms of Service</h1>
        <p class="text-xl text-white/80">Last updated: January 14, 2026</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 prose prose-lg">

<h2>1. Acceptance of Terms</h2>
<p>By accessing and using EventsDomain ("the Platform"), you accept and agree to be bound by the terms and provisions of this agreement. If you do not agree to abide by these terms, please do not use this Platform. These Terms of Service govern your use of the Platform and all services provided therein.</p>

<h2>2. Description of Service</h2>
<p>EventsDomain is an online marketplace that connects event organizers seeking sponsorship with potential sponsors. We provide a platform for organizers to list their events and for sponsors to discover and connect with events that align with their brand objectives. We facilitate connections but do not participate in the actual sponsorship negotiations or agreements between parties.</p>

<h2>3. User Accounts</h2>
<p>To access certain features of the Platform, you must register for an account. You agree to:</p>
<ul>
<li>Provide accurate, current, and complete information during registration</li>
<li>Maintain and promptly update your account information</li>
<li>Maintain the security of your password and account</li>
<li>Accept responsibility for all activities that occur under your account</li>
<li>Notify us immediately of any unauthorized use of your account</li>
</ul>

<h2>4. Event Listings</h2>

<h3>For Event Organizers</h3>
<p>When listing an event on the Platform, you agree that:</p>
<ul>
<li>All information provided is accurate, complete, and not misleading</li>
<li>You have the legal right and authority to list the event</li>
<li>The event complies with all applicable laws and regulations</li>
<li>You will respond to sponsor enquiries in a timely and professional manner</li>
<li>Listing fees are non-refundable unless otherwise stated</li>
</ul>

<h3>For Sponsors</h3>
<p>When using the Platform to find sponsorship opportunities, you acknowledge that EventsDomain does not guarantee the accuracy of event listings or the success of any sponsorship arrangement. You are responsible for conducting your own due diligence before entering into any agreement.</p>

<h2>5. Fees and Payments</h2>
<p>Event organizers are required to pay listing fees as specified on our Pricing page. By submitting payment, you agree that:</p>
<ul>
<li>All payment information provided is accurate and authorized</li>
<li>You are responsible for all applicable taxes</li>
<li>Fees are charged in advance and are non-refundable except as outlined in our Refund Policy</li>
<li>We may change our pricing at any time with reasonable notice</li>
<li>Failed payments may result in suspension of your listing</li>
</ul>

<h2>6. Prohibited Activities</h2>
<p>You agree not to engage in any of the following activities:</p>
<ul>
<li>Posting false, misleading, or fraudulent event listings</li>
<li>Impersonating any person or entity</li>
<li>Violating any applicable laws or regulations</li>
<li>Infringing upon intellectual property rights of others</li>
<li>Transmitting spam, viruses, or harmful code</li>
<li>Attempting to gain unauthorized access to the Platform</li>
<li>Interfering with the proper working of the Platform</li>
<li>Scraping or collecting user data without permission</li>
<li>Using the Platform for any illegal or unauthorized purpose</li>
</ul>

<h2>7. Content and Intellectual Property</h2>
<p>You retain ownership of content you submit to the Platform. However, by submitting content, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, modify, and display such content in connection with providing our services.</p>
<p>The Platform and its original content (excluding user content), features, and functionality are owned by EventsDomain and are protected by international copyright, trademark, and other intellectual property laws.</p>

<h2>8. Disclaimer of Warranties</h2>
<p>THE PLATFORM IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. EVENTSDOMAIN MAKES NO WARRANTIES, EXPRESSED OR IMPLIED, AND HEREBY DISCLAIMS ALL OTHER WARRANTIES INCLUDING, WITHOUT LIMITATION, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. WE DO NOT WARRANT THAT THE PLATFORM WILL BE UNINTERRUPTED, SECURE, OR ERROR-FREE.</p>

<h2>9. Limitation of Liability</h2>
<p>IN NO EVENT SHALL EVENTSDOMAIN, ITS DIRECTORS, EMPLOYEES, PARTNERS, AGENTS, SUPPLIERS, OR AFFILIATES BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING WITHOUT LIMITATION, LOSS OF PROFITS, DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES, RESULTING FROM YOUR ACCESS TO OR USE OF OR INABILITY TO ACCESS OR USE THE PLATFORM.</p>

<h2>10. Indemnification</h2>
<p>You agree to defend, indemnify, and hold harmless EventsDomain and its officers, directors, employees, and agents from and against any claims, liabilities, damages, losses, and expenses, including without limitation reasonable legal fees, arising out of or in any way connected with your access to or use of the Platform, your violation of these Terms, or your violation of any third-party rights.</p>

<h2>11. Termination</h2>
<p>We may terminate or suspend your account and bar access to the Platform immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever, including but not limited to a breach of the Terms. Upon termination, your right to use the Platform will immediately cease.</p>

<h2>12. Governing Law</h2>
<p>These Terms shall be governed and construed in accordance with the laws of India, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights.</p>

<h2>13. Dispute Resolution</h2>
<p>Any disputes arising out of or relating to these Terms or the use of the Platform shall first be attempted to be resolved through good-faith negotiations. If negotiations fail, disputes shall be resolved through binding arbitration in Ahmedabad, Gujarat India, in accordance with the rules of the Indian Arbitration and Conciliation Act.</p>

<h2>14. Changes to Terms</h2>
<p>We reserve the right to modify or replace these Terms at any time at our sole discretion. We will provide notice of any significant changes by posting the new Terms on this page. Your continued use of the Platform after any such changes constitutes your acceptance of the new Terms.</p>

<h2>15. Contact Us</h2>
<p>If you have any questions about these Terms of Service, please contact us:</p>
<ul>
<li>Email: legal@eventsdomain.com</li>
<li>Address: Ahmedabad, Gujarat India</li>
</ul>

    </div>
</section>
HTML
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'is_published' => true,
                'meta_title' => 'Contact Us - EventsDomain',
                'meta_description' => 'Get in touch with EventsDomain - we\'d love to hear from you',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Contact Us</h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">Have questions? We'd love to hear from you.</p>
    </div>
</section>

<section class="py-20">
    <div class="container-page">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
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
HTML
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'is_published' => true,
                'meta_title' => 'FAQ - EventsDomain',
                'meta_description' => 'Frequently asked questions about EventsDomain platform',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Frequently Asked Questions</h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">Find answers to common questions about EventsDomain</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6" x-data="{ open: null }">
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
HTML
            ],
            [
                'title' => 'Pricing',
                'slug' => 'pricing',
                'is_published' => true,
                'meta_title' => 'Pricing - EventsDomain',
                'meta_description' => 'Simple, transparent pricing for EventsDomain - start for free, pay only when you close a deal',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Simple, Transparent Pricing</h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">Start for free. Pay only when you close a deal.</p>
    </div>
</section>

<section class="py-20">
    <div class="container-page">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card border border-gray-200 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Starter</h3>
                <p class="text-gray-500 mb-6">Perfect for getting started</p>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900">&#x20B9;0</span>
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
                <a href="/register" class="btn-outline w-full block text-center">Get Started</a>
            </div>

            <div class="card shadow-lg border-2 border-terracotta-500 p-8 relative">
                <div class="absolute top-0 right-0 bg-terracotta-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-xl text-sm font-semibold">
                    Popular
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Professional</h3>
                <p class="text-gray-500 mb-6">For serious organizers</p>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-gray-900">&#x20B9;4,999</span>
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
                <a href="/register" class="btn-primary w-full block text-center">Start Free Trial</a>
            </div>

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
HTML
            ],
            [
                'title' => 'Refund Policy',
                'slug' => 'refund',
                'is_published' => true,
                'meta_title' => 'Refund Policy - EventsDomain',
                'meta_description' => 'EventsDomain refund policy - terms and conditions for refunds and chargebacks',
                'created_at' => $now,
                'updated_at' => $now,
                'content' => <<<'HTML'
<section class="bg-gradient-to-br from-terracotta-900 to-terracotta-700 py-20">
    <div class="container-page text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Refund Policy</h1>
        <p class="text-xl text-white/80">Last updated: January 16, 2026</p>
    </div>
</section>

<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 prose prose-lg">

<h2>1. Overview</h2>
<p>At EventsDomain, we strive to provide excellent service to all our users. This Refund Policy outlines the circumstances under which refunds may be granted for event listing fees paid on our platform. Please read this policy carefully before making any payment.</p>

<h2>2. Refund Eligibility</h2>

<h3>Eligible for Refund</h3>
<p>You may be eligible for a refund in the following situations:</p>
<ul>
<li><strong>Event Rejected:</strong> If your event listing is rejected during our review process, you are entitled to a full refund of the listing fee.</li>
<li><strong>Duplicate Payment:</strong> If you have been charged multiple times for the same event listing due to a technical error.</li>
<li><strong>Platform Error:</strong> If a technical issue on our platform prevented your event from being listed despite successful payment.</li>
<li><strong>Cancellation Before Approval:</strong> If you request cancellation of your listing before it has been approved and gone live.</li>
</ul>

<h3>Not Eligible for Refund</h3>
<p>Refunds will not be granted in the following situations:</p>
<ul>
<li>Your event has already been approved and is live on the platform</li>
<li>You wish to cancel an approved listing due to change of plans</li>
<li>Your event has expired naturally at the end of its listing period</li>
<li>Your listing was removed due to violation of our Terms of Service</li>
<li>You are dissatisfied with the number of enquiries received</li>
<li>The event was cancelled or postponed after listing went live</li>
</ul>

<h2>3. Refund Request Window</h2>
<p>Refund requests must be submitted within the following timeframes:</p>
<ul>
<li><strong>For rejected events:</strong> Within 30 days of receiving the rejection notification</li>
<li><strong>For duplicate payments:</strong> Within 60 days of the duplicate charge</li>
<li><strong>For platform errors:</strong> Within 7 days of the issue occurring</li>
<li><strong>For pre-approval cancellation:</strong> Before your listing is approved</li>
</ul>
<p>Requests submitted after these windows may not be eligible for refund.</p>

<h2>4. How to Request a Refund</h2>
<p>To request a refund, please follow these steps:</p>
<ol>
<li>Email our support team at support@eventsdomain.com</li>
<li>Include "Refund Request" in the subject line</li>
<li>Provide your registered email address and event title</li>
<li>Include your payment transaction reference or receipt</li>
<li>Clearly state the reason for your refund request</li>
<li>Attach any supporting documentation if applicable</li>
</ol>

<h2>5. Refund Processing</h2>

<h3>Review Timeline</h3>
<p>We aim to review all refund requests within 5-7 business days. Complex cases may require additional time for investigation. You will receive an email notification once a decision has been made.</p>

<h3>Refund Method</h3>
<p>Approved refunds will be processed using the same payment method used for the original transaction:</p>
<ul>
<li><strong>Credit/Debit Card:</strong> Refund credited within 7-10 business days</li>
<li><strong>UPI/Bank Transfer:</strong> Refund credited within 5-7 business days</li>
<li><strong>Other Methods:</strong> Timeline varies based on payment provider</li>
</ul>
<p>Please note that your bank or payment provider may have their own processing times which are outside our control.</p>

<h2>6. Partial Refunds</h2>
<p>In certain circumstances, we may offer partial refunds at our discretion. This may apply when a service was partially delivered or when there are extenuating circumstances. Partial refund amounts will be determined on a case-by-case basis.</p>

<h2>7. Plan Upgrades and Downgrades</h2>
<p>If you upgrade your listing plan:</p>
<ul>
<li>You will only be charged the difference between plans</li>
<li>Upgrades are non-refundable once applied</li>
</ul>
<p>Downgrades are not available once a listing has been approved. You would need to let the current listing expire and submit a new listing with the desired plan.</p>

<h2>8. Waived Listing Fees</h2>
<p>If your listing fee was waived as part of a promotional offer or partnership agreement, no refund is applicable as no payment was made. Any disputes regarding waived fees should be directed to our partnerships team.</p>

<h2>9. Exceptions</h2>
<p>We reserve the right to make exceptions to this policy in extraordinary circumstances, including but not limited to:</p>
<ul>
<li>Natural disasters or force majeure events affecting the event</li>
<li>Government-mandated cancellations or restrictions</li>
<li>Serious technical failures on our platform lasting extended periods</li>
<li>Death or serious illness of the primary event organizer</li>
</ul>
<p>Such exceptions are granted at our sole discretion and require appropriate documentation.</p>

<h2>10. Disputes</h2>
<p>If you disagree with our refund decision, you may escalate the matter by emailing support@eventsdomain.com with "Refund Appeal" in the subject line. Appeals will be reviewed by a senior team member, and a final decision will be communicated within 14 business days.</p>

<h2>11. Changes to This Policy</h2>
<p>We may update this Refund Policy from time to time. Any changes will be posted on this page with an updated "Last updated" date. We encourage you to review this policy periodically. Continued use of our services after changes constitutes acceptance of the updated policy.</p>

<h2>12. Contact Us</h2>
<p>If you have any questions about this Refund Policy, please contact us:</p>
<ul>
<li>Email: support@eventsdomain.com</li>
<li>Phone: +91 97250 98250</li>
<li>Address: Ahmedabad, Gujarat India</li>
</ul>

    </div>
</section>
HTML
            ],
        ];

        foreach ($pages as $page) {
            CmsPage::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }

        $this->command->info('Seeded '.count($pages).' CMS pages.');
    }
}
