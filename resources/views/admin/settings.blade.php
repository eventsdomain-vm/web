<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Platform Settings</h2>
    </x-slot>

    @php
        $tabs = [
            'general' => ['label' => 'General', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            'branding' => ['label' => 'Branding', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            'social' => ['label' => 'Social Links', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
            'social-login' => ['label' => 'Social Login', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            'integrations' => ['label' => 'Integrations', 'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
            'ai' => ['label' => 'AI Config', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            'email' => ['label' => 'Email', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            'sponsorship' => ['label' => 'Sponsorship', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
            'maintenance' => ['label' => 'Maintenance', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z'],
            'sms' => ['label' => 'SMS & WhatsApp', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            'backup' => ['label' => 'Backup', 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4'],
            'notifications' => ['label' => 'Notifications', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
            'features' => ['label' => 'Feature Flags', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'performance' => ['label' => 'Performance', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            'security' => ['label' => 'Security', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
            'cache' => ['label' => 'Cache', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
            'api-keys' => ['label' => 'API Keys', 'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
            'payment' => ['label' => 'Payment', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
            'gst' => ['label' => 'GST', 'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z'],
            'storage' => ['label' => 'Storage', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ];
        $currentTab = request()->get('tab', 'general');
        if (!array_key_exists($currentTab, $tabs)) $currentTab = 'general';
    @endphp

    <div x-data="settingsTabs()" x-init="initTabs('{{ $currentTab }}')" class="max-w-6xl mx-auto">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="flex gap-6">
            {{-- Vertical Tab Sidebar --}}
            <div class="w-56 shrink-0 hidden lg:block">
                <div class="sticky top-24 space-y-0.5 bg-gray-50 rounded-xl p-1.5 max-h-[calc(100vh-8rem)] overflow-y-auto no-scrollbar">
                    @foreach($tabs as $key => $tab)
                        <button @click="switchTab('{{ $key }}')"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg transition text-left"
                            :class="tab === '{{ $key }}' ? 'bg-white text-gray-900 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-900 hover:bg-white/60'">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}"/></svg>
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Mobile Tab Dropdown --}}
            <div class="lg:hidden w-full mb-4">
                <select x-model="tab" @change="window.location.hash = tab" class="input-field w-full">
                    @foreach($tabs as $key => $tab)
                        <option value="{{ $key }}" {{ $key === $currentTab ? 'selected' : '' }}>{{ $tab['label'] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- General --}}
                    <div x-show="tab === 'general'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">General Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="label">Platform Name</label><input type="text" name="site_name" value="{{ old('site_name', $settings['general']['site_name'] ?? 'EventsDomain') }}" class="input-field"></div>
                            <div><label class="label">Tagline</label><input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['general']['site_tagline'] ?? '') }}" class="input-field"></div>
                            <div><label class="label">Contact Email</label><input type="email" name="contact_email" value="{{ old('contact_email', $settings['general']['contact_email'] ?? '') }}" class="input-field"></div>
                            <div><label class="label">Support Phone</label><input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['general']['contact_phone'] ?? '') }}" class="input-field"></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Branding --}}
                    <div x-show="tab === 'branding'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Branding</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="label">Logo</label><input type="file" name="branding_logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" class="input-field">@if(!empty($settings['branding']['branding_logo']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_logo']) }}" alt="Logo" class="h-10 object-contain border rounded"><p class="text-xs text-gray-400 mt-1">Upload to replace</p></div>@endif</div>
                            <div><label class="label">White Logo</label><input type="file" name="branding_white_logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" class="input-field">@if(!empty($settings['branding']['branding_white_logo']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_white_logo']) }}" alt="White Logo" class="h-10 object-contain border rounded bg-gray-800"></div>@endif</div>
                            <div><label class="label">Favicon</label><input type="file" name="branding_favicon" accept="image/x-icon,image/png,image/svg+xml" class="input-field">@if(!empty($settings['branding']['branding_favicon']))<div class="mt-2 flex items-center gap-2"><img src="{{ Storage::url($settings['branding']['branding_favicon']) }}" alt="Favicon" class="w-6 h-6 object-contain border rounded"><span class="text-xs text-gray-400">Upload to replace</span></div>@endif</div>
                            <div><label class="label">Apple Touch Icon</label><input type="file" name="branding_apple_touch_icon" accept="image/png,image/jpg,image/jpeg,image/webp" class="input-field">@if(!empty($settings['branding']['branding_apple_touch_icon']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_apple_touch_icon']) }}" alt="Apple Touch Icon" class="w-10 h-10 object-contain border rounded"></div>@endif</div>
                            <div><label class="label">OG Image</label><input type="file" name="branding_og_image" accept="image/png,image/jpg,image/jpeg,image/webp" class="input-field">@if(!empty($settings['branding']['branding_og_image']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_og_image']) }}" alt="OG Image" class="h-16 object-contain border rounded"></div>@endif</div>
                            <div><label class="label">Login Background</label><input type="file" name="branding_login_bg" accept="image/png,image/jpg,image/jpeg,image/webp" class="input-field">@if(!empty($settings['branding']['branding_login_bg']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_login_bg']) }}" alt="Login Background" class="h-16 object-cover border rounded"></div>@endif</div>
                            <div><label class="label">Admin Logo</label><input type="file" name="branding_admin_logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" class="input-field">@if(!empty($settings['branding']['branding_admin_logo']))<div class="mt-2"><img src="{{ Storage::url($settings['branding']['branding_admin_logo']) }}" alt="Admin Logo" class="h-10 object-contain border rounded"></div>@endif</div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div x-show="tab === 'social'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Links</h3>
                        <p class="text-sm text-gray-500 mb-4">Global social media profile links displayed in the website footer.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="label">Facebook</label><input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['social']['facebook_url'] ?? '') }}" class="input-field" placeholder="https://facebook.com/eventsdomain"></div>
                            <div><label class="label">X (Twitter)</label><input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['social']['twitter_url'] ?? '') }}" class="input-field" placeholder="https://x.com/eventsdomain"></div>
                            <div><label class="label">Instagram</label><input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['social']['instagram_url'] ?? '') }}" class="input-field" placeholder="https://instagram.com/eventsdomain"></div>
                            <div><label class="label">LinkedIn</label><input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['social']['linkedin_url'] ?? '') }}" class="input-field" placeholder="https://linkedin.com/company/eventsdomain"></div>
                            <div><label class="label">YouTube</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['social']['youtube_url'] ?? '') }}" class="input-field" placeholder="https://youtube.com/@eventsdomain"></div>
                            <div><label class="label">WhatsApp</label><input type="url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings['social']['whatsapp_url'] ?? '') }}" class="input-field" placeholder="https://wa.me/919725098250"></div>
                            <div><label class="label">Telegram</label><input type="url" name="telegram_url" value="{{ old('telegram_url', $settings['social']['telegram_url'] ?? '') }}" class="input-field" placeholder="https://t.me/eventsdomain"></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Social Login --}}
                    <div x-show="tab === 'social-login'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Login & Posting Configuration</h3>
                        <p class="text-sm text-gray-500 mb-4">Configure OAuth credentials for Organizer and Partner social media login and social posting (Facebook, LinkedIn, Google/YouTube).</p>

                        <details class="border border-gray-200 rounded-lg p-4 mb-4">
                            <summary class="cursor-pointer font-medium text-gray-900">Google OAuth</summary>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">Client ID</label><input type="text" name="social_google_client_id" value="{{ old('social_google_client_id', $settings['social-login']['social_google_client_id'] ?? '') }}" class="input-field" placeholder="xxxxxxxx.apps.googleusercontent.com"></div>
                                <div><label class="label">Client Secret</label><input type="password" name="social_google_client_secret" value="{{ old('social_google_client_secret', $settings['social-login']['social_google_client_secret'] ?? '') }}" class="input-field"></div>
                                <div class="md:col-span-2"><label class="label">Allowed Redirect URIs</label><div class="bg-gray-50 text-sm text-gray-600 rounded p-2">{{ url('/organizer/social/google/callback') }}<br>{{ url('/login/google/callback') }}</div></div>
                            </div>
                        </details>

                        <details class="border border-gray-200 rounded-lg p-4 mb-4">
                            <summary class="cursor-pointer font-medium text-gray-900">LinkedIn OAuth</summary>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">Client ID</label><input type="text" name="social_linkedin_client_id" value="{{ old('social_linkedin_client_id', $settings['social-login']['social_linkedin_client_id'] ?? '') }}" class="input-field"></div>
                                <div><label class="label">Client Secret</label><input type="password" name="social_linkedin_client_secret" value="{{ old('social_linkedin_client_secret', $settings['social-login']['social_linkedin_client_secret'] ?? '') }}" class="input-field"></div>
                                <div class="md:col-span-2"><label class="label">Allowed Redirect URIs</label><div class="bg-gray-50 text-sm text-gray-600 rounded p-2">{{ url('/organizer/social/linkedin/callback') }}<br>{{ url('/login/linkedin/callback') }}</div></div>
                            </div>
                        </details>

                        <details class="border border-gray-200 rounded-lg p-4 mb-4">
                            <summary class="cursor-pointer font-medium text-gray-900">Facebook OAuth</summary>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">App ID</label><input type="text" name="social_facebook_client_id" value="{{ old('social_facebook_client_id', $settings['social-login']['social_facebook_client_id'] ?? '') }}" class="input-field"></div>
                                <div><label class="label">App Secret</label><input type="password" name="social_facebook_client_secret" value="{{ old('social_facebook_client_secret', $settings['social-login']['social_facebook_client_secret'] ?? '') }}" class="input-field"></div>
                                <div class="md:col-span-2"><label class="label">Allowed Redirect URIs</label><div class="bg-gray-50 text-sm text-gray-600 rounded p-2">{{ url('/organizer/social/facebook/callback') }}<br>{{ url('/login/facebook/callback') }}</div></div>
                            </div>
                        </details>

                        <details class="border border-gray-200 rounded-lg p-4">
                            <summary class="cursor-pointer font-medium text-gray-900">YouTube Data API</summary>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">API Key</label><input type="password" name="social_youtube_api_key" value="{{ old('social_youtube_api_key', $settings['social-login']['social_youtube_api_key'] ?? '') }}" class="input-field"></div>
                                <div><label class="label">Scopes</label><input type="text" value="https://www.googleapis.com/auth/youtube.upload, https://www.googleapis.com/auth/youtube.force-ssl" class="input-field bg-gray-50" readonly></div>
                                <div class="md:col-span-2"><label class="label">Note</label><p class="text-sm text-gray-500">YouTube posting uses Google OAuth scopes. Ensure the Google OAuth Client ID above has the YouTube Data API v3 enabled in Google Cloud Console.</p></div>
                            </div>
                        </details>

                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Integrations --}}
                    <div x-show="tab === 'integrations'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Integrations</h3>
                        <div class="space-y-6">
                            <div><label class="label">Google Maps API Key</label><input type="text" name="google_maps_api_key" value="{{ old('google_maps_api_key', $settings['integrations']['google_maps_api_key'] ?? '') }}" class="input-field" placeholder="AIza..."><p class="text-sm text-gray-500 mt-1">Used for displaying event location maps.</p></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">reCAPTCHA Site Key</label><input type="text" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $settings['integrations']['recaptcha_site_key'] ?? '') }}" class="input-field" placeholder="6L..."></div>
                                <div><label class="label">reCAPTCHA Secret Key</label><input type="password" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key', $settings['integrations']['recaptcha_secret_key'] ?? '') }}" class="input-field" placeholder="6L..."></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">Facebook Pixel ID</label><input type="text" name="facebook_pixel_id" value="{{ old('facebook_pixel_id', $settings['integrations']['facebook_pixel_id'] ?? '') }}" class="input-field" placeholder="1234567890"></div>
                                <div><label class="label">Microsoft Clarity ID</label><input type="text" name="microsoft_clarity_id" value="{{ old('microsoft_clarity_id', $settings['integrations']['microsoft_clarity_id'] ?? '') }}" class="input-field" placeholder="abcdefghij"></div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- AI Configuration --}}
                    <div x-show="tab === 'ai'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">AI Configuration</h3>
                        <div class="space-y-6">
                            <div><label class="label">Default Provider</label><select name="ai_default_provider" class="input-field"><option value="anthropic" {{ ($settings['ai']['ai_default_provider'] ?? 'anthropic') === 'anthropic' ? 'selected' : '' }}>Anthropic (Claude)</option><option value="openai" {{ ($settings['ai']['ai_default_provider'] ?? '') === 'openai' ? 'selected' : '' }}>OpenAI (GPT)</option><option value="gemini" {{ ($settings['ai']['ai_default_provider'] ?? '') === 'gemini' ? 'selected' : '' }}>Google (Gemini)</option><option value="ollama" {{ ($settings['ai']['ai_default_provider'] ?? '') === 'ollama' ? 'selected' : '' }}>Ollama (Local)</option></select></div>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">Anthropic (Claude)</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">API Key</label><input type="password" name="ai_anthropic_key" value="{{ old('ai_anthropic_key', $settings['ai']['ai_anthropic_key'] ?? '') }}" class="input-field" placeholder="sk-ant-..."></div><div><label class="label">Model</label><input type="text" name="ai_anthropic_model" value="{{ old('ai_anthropic_model', $settings['ai']['ai_anthropic_model'] ?? 'claude-opus-4-8') }}" class="input-field" placeholder="claude-opus-4-8"></div></div></details>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">OpenAI (GPT)</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">API Key</label><input type="password" name="ai_openai_key" value="{{ old('ai_openai_key', $settings['ai']['ai_openai_key'] ?? '') }}" class="input-field" placeholder="sk-..."></div><div><label class="label">Model</label><input type="text" name="ai_openai_model" value="{{ old('ai_openai_model', $settings['ai']['ai_openai_model'] ?? 'gpt-4o') }}" class="input-field" placeholder="gpt-4o"></div></div></details>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">Google (Gemini)</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">API Key</label><input type="password" name="ai_gemini_key" value="{{ old('ai_gemini_key', $settings['ai']['ai_gemini_key'] ?? '') }}" class="input-field" placeholder="AIza..."></div><div><label class="label">Model</label><input type="text" name="ai_gemini_model" value="{{ old('ai_gemini_model', $settings['ai']['ai_gemini_model'] ?? 'gemini-2.5-pro') }}" class="input-field" placeholder="gemini-2.5-pro"></div></div></details>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">Ollama (Local)</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">Endpoint</label><input type="url" name="ai_ollama_endpoint" value="{{ old('ai_ollama_endpoint', $settings['ai']['ai_ollama_endpoint'] ?? 'http://localhost:11434') }}" class="input-field" placeholder="http://localhost:11434"></div><div><label class="label">Model</label><input type="text" name="ai_ollama_model" value="{{ old('ai_ollama_model', $settings['ai']['ai_ollama_model'] ?? 'llama3') }}" class="input-field" placeholder="llama3"></div></div></details>
                            <div class="pt-4 border-t border-gray-200"><h4 class="font-medium text-gray-900 mb-3">Feature Toggles</h4><div class="space-y-3">
                                <label class="flex items-center gap-3"><input type="hidden" name="ai_search_enabled" value="0"><input type="checkbox" name="ai_search_enabled" value="1" {{ ($settings['ai']['ai_search_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]"><span class="text-sm text-gray-700">AI-Powered Search</span></label>
                                <label class="flex items-center gap-3"><input type="hidden" name="ai_content_enabled" value="0"><input type="checkbox" name="ai_content_enabled" value="1" {{ ($settings['ai']['ai_content_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]"><span class="text-sm text-gray-700">AI Content Generation</span></label>
                                <label class="flex items-center gap-3"><input type="hidden" name="ai_recommendations_enabled" value="0"><input type="checkbox" name="ai_recommendations_enabled" value="1" {{ ($settings['ai']['ai_recommendations_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-[#E35336] focus:ring-[#E35336]"><span class="text-sm text-gray-700">AI Recommendations</span></label>
                            </div></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200"><div><label class="label">Temperature (0-2)</label><input type="number" name="ai_temperature" value="{{ old('ai_temperature', $settings['ai']['ai_temperature'] ?? '0.7') }}" class="input-field" min="0" max="2" step="0.1"></div><div><label class="label">Max Tokens</label><input type="number" name="ai_max_tokens" value="{{ old('ai_max_tokens', $settings['ai']['ai_max_tokens'] ?? '4096') }}" class="input-field" min="1" max="128000"></div></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div x-show="tab === 'email'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Email Settings</h3>
                        <div class="space-y-6">
                            <div><label class="label">SMTP Host</label><input type="text" name="smtp_host" value="{{ old('smtp_host', $settings['email']['smtp_host'] ?? '') }}" placeholder="smtp.gmail.com" class="input-field"></div>
                            <div class="grid grid-cols-2 gap-6"><div><label class="label">SMTP Port</label><input type="number" name="smtp_port" value="{{ old('smtp_port', $settings['email']['smtp_port'] ?? '587') }}" class="input-field"></div><div><label class="label">Encryption</label><select name="smtp_encryption" class="input-field"><option value="tls" {{ ($settings['email']['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option><option value="ssl" {{ ($settings['email']['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option></select></div></div>
                            <div><label class="label">SMTP Username</label><input type="text" name="smtp_username" value="{{ old('smtp_username', $settings['email']['smtp_username'] ?? '') }}" class="input-field"></div>
                            <div><label class="label">SMTP Password</label><input type="password" name="smtp_password" value="{{ old('smtp_password', $settings['email']['smtp_password'] ?? '') }}" class="input-field"></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Sponsorship --}}
                    <div x-show="tab === 'sponsorship'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sponsorship Settings</h3>
                        <div class="space-y-6">
                            <div><label class="label">Service Fee (%)</label><input type="number" name="service_fee_percentage" value="{{ old('service_fee_percentage', $settings['sponsorship']['service_fee_percentage'] ?? '5') }}" class="input-field" min="0" max="100" step="0.5"><p class="text-sm text-gray-500 mt-1">Percentage fee charged on successful sponsorships</p></div>
                            <div><label class="label">Minimum Sponsorship Amount (Rs)</label><input type="number" name="min_sponsorship_amount" value="{{ old('min_sponsorship_amount', $settings['sponsorship']['min_sponsorship_amount'] ?? '10000') }}" class="input-field" min="0"></div>
                            <div><label class="label">Auto-approve Events</label><select name="auto_approve_events" class="input-field"><option value="0" {{ ($settings['sponsorship']['auto_approve_events'] ?? '0') == '0' ? 'selected' : '' }}>No - Manual approval required</option><option value="1" {{ ($settings['sponsorship']['auto_approve_events'] ?? '') == '1' ? 'selected' : '' }}>Yes - Auto-approve all events</option></select></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Maintenance --}}
                    <div x-show="tab === 'maintenance'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Mode</h3>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div><p class="font-medium text-gray-900">Enable Maintenance Mode</p><p class="text-sm text-gray-500">Temporarily disable access to the platform for non-admin users</p></div>
                            <label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="maintenance_mode" value="0"><input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance']['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- SMS & WhatsApp --}}
                    <div x-show="tab === 'sms'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">SMS & WhatsApp</h3>
                        <p class="text-sm text-gray-500 mb-4">Configure SMS and WhatsApp notification providers.</p>
                        <div class="space-y-4">
                            <div><label class="label">Default SMS Provider</label><select name="sms_provider" class="input-field"><option value="twilio" {{ ($settings['sms']['sms_provider'] ?? 'twilio') === 'twilio' ? 'selected' : '' }}>Twilio</option><option value="msg91" {{ ($settings['sms']['sms_provider'] ?? '') === 'msg91' ? 'selected' : '' }}>MSG91</option><option value="sms77" {{ ($settings['sms']['sms_provider'] ?? '') === 'sms77' ? 'selected' : '' }}>SMS77</option></select></div>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">Twilio</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">Account SID</label><input type="password" name="twilio_account_sid" value="{{ old('twilio_account_sid', $settings['sms']['twilio_account_sid'] ?? '') }}" class="input-field"></div><div><label class="label">Auth Token</label><input type="password" name="twilio_auth_token" value="{{ old('twilio_auth_token', $settings['sms']['twilio_auth_token'] ?? '') }}" class="input-field"></div><div><label class="label">From Number</label><input type="text" name="twilio_from" value="{{ old('twilio_from', $settings['sms']['twilio_from'] ?? '') }}" class="input-field" placeholder="+1234567890"></div></div></details>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">MSG91</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">Auth Key</label><input type="password" name="msg91_auth_key" value="{{ old('msg91_auth_key', $settings['sms']['msg91_auth_key'] ?? '') }}" class="input-field"></div><div><label class="label">Sender ID</label><input type="text" name="msg91_sender_id" value="{{ old('msg91_sender_id', $settings['sms']['msg91_sender_id'] ?? 'EVENTSD') }}" class="input-field" maxlength="6"></div><div><label class="label">Route</label><select name="msg91_route" class="input-field"><option value="1" {{ ($settings['sms']['msg91_route'] ?? '4') === '1' ? 'selected' : '' }}>Promotional</option><option value="4" {{ ($settings['sms']['msg91_route'] ?? '4') === '4' ? 'selected' : '' }}>Transactional</option></select></div></div></details>
                            <details class="border border-gray-200 rounded-lg p-4"><summary class="cursor-pointer font-medium text-gray-900">WhatsApp Cloud API</summary><div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="label">Access Token</label><input type="password" name="whatsapp_access_token" value="{{ old('whatsapp_access_token', $settings['sms']['whatsapp_access_token'] ?? '') }}" class="input-field"></div><div><label class="label">Phone Number ID</label><input type="text" name="whatsapp_phone_number_id" value="{{ old('whatsapp_phone_number_id', $settings['sms']['whatsapp_phone_number_id'] ?? '') }}" class="input-field"></div></div></details>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Backup --}}
                    <div x-show="tab === 'backup'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Backup</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="label">Backup Storage Disk</label><select name="backup_disk" class="input-field"><option value="local" {{ ($settings['backup']['backup_disk'] ?? 'local') === 'local' ? 'selected' : '' }}>Local</option><option value="public" {{ ($settings['backup']['backup_disk'] ?? '') === 'public' ? 'selected' : '' }}>Public</option><option value="s3" {{ ($settings['backup']['backup_disk'] ?? '') === 's3' ? 'selected' : '' }}>Amazon S3</option></select></div>
                                <div><label class="label">Retention (days)</label><input type="number" name="backup_retention_days" value="{{ old('backup_retention_days', $settings['backup']['backup_retention_days'] ?? '7') }}" class="input-field" min="1" max="365"></div>
                                <div><label class="label">Schedule</label><select name="backup_schedule" class="input-field"><option value="manual" {{ ($settings['backup']['backup_schedule'] ?? 'manual') === 'manual' ? 'selected' : '' }}>Manual Only</option><option value="daily" {{ ($settings['backup']['backup_schedule'] ?? '') === 'daily' ? 'selected' : '' }}>Daily</option><option value="weekly" {{ ($settings['backup']['backup_schedule'] ?? '') === 'weekly' ? 'selected' : '' }}>Weekly</option></select></div>
                                <div><label class="label">Include File Uploads</label><select name="backup_include_files" class="input-field"><option value="0" {{ ($settings['backup']['backup_include_files'] ?? '0') == '0' ? 'selected' : '' }}>Database only</option><option value="1" {{ ($settings['backup']['backup_include_files'] ?? '') == '1' ? 'selected' : '' }}>Database + files</option></select></div>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div><p class="font-medium text-gray-900">Manual Backup</p><p class="text-sm text-gray-500">Run a database backup now</p></div>
                                <form action="{{ route('admin.settings.backup') }}" method="POST" onsubmit="return confirm('Start a backup now?')">@csrf<button type="submit" class="px-4 py-2 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] text-sm font-medium transition">Run Backup Now</button></form>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Notifications --}}
                    <div x-show="tab === 'notifications'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Templates</h3>
                        <p class="text-sm text-gray-500 mb-4">Available variables: <code>{user_name}</code>, <code>{event_name}</code>, <code>{site_name}</code>, <code>{action_url}</code>.</p>
                        <div class="space-y-6">
                            @php $notifications = ['welcome' => 'Welcome Email','event_approved' => 'Event Approved','event_rejected' => 'Event Rejected','sponsorship_confirmed' => 'Sponsorship Confirmed','payment_received' => 'Payment Received','account_verified' => 'Account Verified']; @endphp
                            @foreach($notifications as $key => $label)
                                <details class="border border-gray-200 rounded-lg p-4">
                                    <summary class="cursor-pointer font-medium text-gray-900">{{ $label }}</summary>
                                    <div class="mt-4 space-y-4">
                                        <div><label class="label">Email Subject</label><input type="text" name="notify_{{ $key }}_subject" value="{{ old('notify_' . $key . '_subject', $settings['notifications']['notify_' . $key . '_subject'] ?? '') }}" class="input-field" placeholder="{{ $label }}"></div>
                                        <div><label class="label">Email Body</label><textarea name="notify_{{ $key }}_body" class="input-field" rows="4" placeholder="Hello {user_name}, ...">{{ old('notify_' . $key . '_body', $settings['notifications']['notify_' . $key . '_body'] ?? '') }}</textarea></div>
                                        @if(in_array($key, ['welcome', 'event_approved', 'sponsorship_confirmed', 'payment_received']))<div><label class="label">SMS Body</label><input type="text" name="notify_{{ $key }}_sms" value="{{ old('notify_' . $key . '_sms', $settings['notifications']['notify_' . $key . '_sms'] ?? '') }}" class="input-field" placeholder="Hi {user_name}, ..."></div>@endif
                                    </div>
                                </details>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Feature Flags --}}
                    <div x-show="tab === 'features'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Feature Flags</h3>
                        <p class="text-sm text-gray-500 mb-4">Enable or disable platform features globally.</p>
                        <div class="space-y-3">
                            @php $flags = ['flag_registration' => ['label' => 'User Registration', 'desc' => 'Allow new users to sign up', 'default' => '1'],'flag_event_creation' => ['label' => 'Event Creation', 'desc' => 'Allow organizers to create events', 'default' => '1'],'flag_sponsorships' => ['label' => 'Sponsorships', 'desc' => 'Enable sponsorship purchases', 'default' => '1'],'flag_social_login' => ['label' => 'Social Login', 'desc' => 'Enable Google/LinkedIn/Facebook login', 'default' => '0'],'flag_public_profiles' => ['label' => 'Public Profiles', 'desc' => 'Allow public viewing of user profiles', 'default' => '1'],'flag_event_search' => ['label' => 'Event Search', 'desc' => 'Enable public event search and browsing', 'default' => '1']]; @endphp
                            @foreach($flags as $fName => $fData)
                                <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div><p class="font-medium text-gray-900">{{ $fData['label'] }}</p><p class="text-sm text-gray-500">{{ $fData['desc'] }}</p></div>
                                    <label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="{{ $fName }}" value="0"><input type="checkbox" name="{{ $fName }}" value="1" {{ ($settings['features'][$fName] ?? $fData['default']) == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Performance --}}
                    <div x-show="tab === 'performance'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance</h3>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">CDN for Assets</p><p class="text-sm text-gray-500">Serve CSS/JS from CDN when available</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="cdn_enabled" value="0"><input type="checkbox" name="cdn_enabled" value="1" {{ ($settings['performance']['cdn_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label></label>
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">HTML Minification</p><p class="text-sm text-gray-500">Minify HTML output on the fly</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="minify_html" value="0"><input type="checkbox" name="minify_html" value="1" {{ ($settings['performance']['minify_html'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label></label>
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Lazy Load Images</p><p class="text-sm text-gray-500">Defer loading of off-screen images</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="lazy_load_images" value="0"><input type="checkbox" name="lazy_load_images" value="1" {{ ($settings['performance']['lazy_load_images'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label></label>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Security --}}
                    <div x-show="tab === 'security'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Security</h3>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Enforce HTTPS</p><p class="text-sm text-gray-500">Redirect all HTTP traffic to HTTPS</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="enforce_https" value="0"><input type="checkbox" name="enforce_https" value="1" {{ ($settings['security']['enforce_https'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label></label>
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Content Security Policy</p><p class="text-sm text-gray-500">Send CSP headers to prevent XSS</p></div><label class="relative inline-flex items-center cursor-pointer"><input type="hidden" name="enable_csp" value="0"><input type="checkbox" name="enable_csp" value="1" {{ ($settings['security']['enable_csp'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer"><div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#FFB0A1] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E35336]"></div></label></label>
                            <div class="pt-2"><label class="label">CSP Policy (advanced)</label><textarea name="csp_policy" class="input-field" rows="3" placeholder="default-src 'self'; script-src 'self'...">{{ old('csp_policy', $settings['security']['csp_policy'] ?? '') }}</textarea></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                    {{-- Cache --}}
                    <div x-show="tab === 'cache'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cache Management</h3>
                        <p class="text-sm text-gray-500 mb-4">Clear application caches to apply changes or resolve issues.</p>
                        <form action="{{ route('admin.settings.cache') }}" method="POST" onsubmit="return confirm('Clear selected cache?')">@csrf
                            <div class="flex flex-wrap gap-3">
                                <button type="submit" name="action" value="all" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm font-medium transition">Clear All</button>
                                <button type="submit" name="action" value="config" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-medium transition">Config</button>
                                <button type="submit" name="action" value="route" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-medium transition">Route</button>
                                <button type="submit" name="action" value="view" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-medium transition">View</button>
                                <button type="submit" name="action" value="optimize" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-medium transition">Optimize</button>
                            </div>
                        </form>
                    </div>

                    {{-- API Keys --}}
                    <div x-show="tab === 'api-keys'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">API Keys</h3>
                        <p class="text-sm text-gray-500 mb-4">Status of third-party API keys configured for this platform.</p>
                        @php $apiKeys = [['name' => 'Anthropic (Claude)', 'set' => !empty(config('services.anthropic.key'))],['name' => 'Razorpay', 'set' => !empty(config('services.razorpay.key'))],['name' => 'Razorpay Secret', 'set' => !empty(config('services.razorpay.secret'))],['name' => 'Stripe', 'set' => !empty(config('services.stripe.key'))],['name' => 'GST Verification', 'set' => !empty(config('services.gst.key'))],['name' => 'Google reCAPTCHA Site', 'set' => !empty(\App\Models\PlatformSetting::get('recaptcha_site_key'))],['name' => 'Google reCAPTCHA Secret', 'set' => !empty(\App\Models\PlatformSetting::get('recaptcha_secret_key'))],['name' => 'Google Maps', 'set' => !empty(\App\Models\PlatformSetting::get('google_maps_api_key'))],['name' => 'Facebook Pixel', 'set' => !empty(\App\Models\PlatformSetting::get('facebook_pixel_id'))],['name' => 'Microsoft Clarity', 'set' => !empty(\App\Models\PlatformSetting::get('microsoft_clarity_id'))]]; @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($apiKeys as $key)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">{{ $key['name'] }}</span><span class="text-xs font-medium px-2 py-1 rounded-full {{ $key['set'] ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">{{ $key['set'] ? 'Set' : 'Missing' }}</span></div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div x-show="tab === 'payment'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Gateway</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Gateway</p><p class="text-sm text-gray-500 capitalize">{{ $paymentGateway['driver'] }}</p></div><span class="px-3 py-1 text-xs font-medium rounded-full {{ $paymentGateway['razorpay_configured'] ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">{{ $paymentGateway['razorpay_configured'] ? 'Configured' : 'Not Configured' }}</span></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">RAZORPAY_KEY</span><span class="text-sm font-medium {{ $paymentGateway['razorpay_key_set'] ? 'text-emerald-600' : 'text-red-600' }}">{{ $paymentGateway['razorpay_key_set'] ? 'Set' : 'Missing' }}</span></div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">RAZORPAY_SECRET</span><span class="text-sm font-medium {{ $paymentGateway['razorpay_secret_set'] ? 'text-emerald-600' : 'text-red-600' }}">{{ $paymentGateway['razorpay_secret_set'] ? 'Set' : 'Missing' }}</span></div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">RAZORPAY_WEBHOOK_SECRET</span><span class="text-sm font-medium {{ $paymentGateway['razorpay_webhook_secret_set'] ? 'text-emerald-600' : 'text-red-600' }}">{{ $paymentGateway['razorpay_webhook_secret_set'] ? 'Set' : 'Missing' }}</span></div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">SDK Package</span><span class="text-sm font-medium {{ $paymentGateway['razorpay_sdk_installed'] ? 'text-emerald-600' : 'text-red-600' }}">{{ $paymentGateway['razorpay_sdk_installed'] ? 'Installed' : 'Missing' }}</span></div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg"><p class="text-sm font-medium text-gray-900 mb-1">Webhook URL</p><p class="text-sm text-gray-500 break-all">{{ $paymentGateway['webhook_url'] }}</p><p class="text-xs text-gray-400 mt-1">Add this URL in Razorpay Dashboard</p></div>
                        </div>
                    </div>

                    {{-- GST --}}
                    <div x-show="tab === 'gst'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">GST Verification API</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Provider</p><p class="text-sm text-gray-500">{{ $gstApi['provider'] }}</p></div><span class="px-3 py-1 text-xs font-medium rounded-full {{ $gstApi['configured'] ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">{{ $gstApi['configured'] ? 'Configured' : 'Not Configured' }}</span></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">API Key</span><span class="text-sm font-medium {{ $gstApi['key_set'] ? 'text-emerald-600' : 'text-red-600' }}">{{ $gstApi['key_set'] ? 'Set' : 'Missing' }}</span></div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"><span class="text-sm text-gray-600">API Endpoint</span><span class="text-sm font-medium text-gray-600">{{ $gstApi['base_url'] }}</span></div>
                            </div>
                            <p class="text-xs text-gray-400">Configured in <code class="bg-gray-200 px-1 rounded">.env</code> file</p>
                        </div>
                    </div>

                    {{-- Storage --}}
                    <div x-show="tab === 'storage'" x-cloak class="card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Storage</h3>
                        <div class="space-y-4">
                            <div><label class="label">File Storage Disk</label><select name="storage_disk" class="input-field"><option value="local" {{ ($settings['storage']['storage_disk'] ?? 'local') === 'local' ? 'selected' : '' }}>Local</option><option value="public" {{ ($settings['storage']['storage_disk'] ?? '') === 'public' ? 'selected' : '' }}>Public</option><option value="s3" {{ ($settings['storage']['storage_disk'] ?? '') === 's3' ? 'selected' : '' }}>Amazon S3</option></select></div>
                            @php $currentDisk = config('filesystems.default'); @endphp
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"><div><p class="font-medium text-gray-900">Current Disk</p><p class="text-sm text-gray-500">{{ $currentDisk }}</p></div><span class="px-3 py-1 text-xs font-medium {{ $currentDisk === 's3' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-600' }} rounded-full">{{ ucfirst($currentDisk) }}</span></div>
                        </div>
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#E35336] text-white rounded-lg hover:bg-[#9E3A26] font-medium transition text-sm">Save Settings</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function settingsTabs() {
            return {
                tab: 'general',
                initTabs(defaultTab) {
                    const hash = window.location.hash.substring(1);
                    this.tab = hash || defaultTab;
                },
                switchTab(key) {
                    this.tab = key;
                    window.location.hash = key;
                }
            };
        }
    </script>
</x-app-layout>
