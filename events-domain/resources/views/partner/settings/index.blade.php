<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">My Profile</h2></x-slot>

    @php
        $user = auth()->user();
        $tab = request('tab', 'profile');
        $socialLinks = $user->profile?->social_links ?? [];
        $refs = old('client_references', $profile->client_references ?? []);
    @endphp

    <div x-data="{ tab: '{{ $tab }}' }" class="max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 p-4 text-white">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-28 h-28 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="relative">
                    <img src="{{ $user->avatar_url }}" class="w-14 h-14 rounded-xl border-2 border-white/50 object-cover shadow">
                    <div class="absolute -bottom-0.5 -right-0.5 w-5 h-5 bg-emerald-400 border-2 border-white rounded-full flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-lg font-bold">{{ $user->name }}</h1>
                    <p class="text-white/80 text-xs">{{ $user->email }}</p>
                    <p class="text-white/60 text-[11px] mt-0.5">{{ $profile->company_name ?? 'Partner' }}</p>
                </div>
            </div>
        </div>

        <div class="flex gap-1 bg-gray-100 rounded-xl p-1.5 overflow-x-auto">
            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-white text-gray-900 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-900'" class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile
            </button>
            <button @click="tab = 'organization'" :class="tab === 'organization' ? 'bg-white text-gray-900 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-900'" class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Organization
            </button>
            <button @click="tab = 'verification'" :class="tab === 'verification' ? 'bg-white text-gray-900 shadow-sm border border-gray-100' : 'text-gray-500 hover:text-gray-900'" class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Verification
            </button>
        </div>

        <form method="POST" action="{{ route('partner.settings.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- Profile Tab --}}
            <div x-show="tab === 'profile'" x-cloak class="card p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Personal Information</h3>
                    <p class="text-sm text-gray-500">Update your personal details and profile photo.</p>
                </div>
                <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl">
                    <div class="relative">
                        <img src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white shadow-sm" id="avatarPreview">
                        <label for="avatar" class="absolute -bottom-1 -right-1 w-7 h-7 bg-white border border-gray-200 rounded-full flex items-center justify-center cursor-pointer shadow-sm hover:bg-gray-50">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </label>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <label for="avatar" class="inline-block mt-2 text-xs text-indigo-500 cursor-pointer hover:underline">Click to change photo</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="document.getElementById('avatarPreview').src = URL.createObjectURL(this.files[0])">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field">
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" value="{{ $user->email }}" class="input-field bg-gray-50" readonly disabled>
                        <p class="text-xs text-gray-400 mt-1">Email cannot be changed</p>
                    </div>
                    <div>
                        <label class="label">Phone / Mobile</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? $profile->phone) }}" class="input-field" placeholder="+91 98765 43210">
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Social Profile URLs</h4>
                    <p class="text-xs text-gray-500 mb-4">Links to your personal social media profiles.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label"><span class="text-blue-600 font-semibold">f</span> Facebook</label>
                            <input type="url" name="social_profile_facebook" value="{{ old('social_profile_facebook', $socialLinks['social_profile_facebook'] ?? '') }}" class="input-field" placeholder="https://facebook.com/your.profile">
                        </div>
                        <div>
                            <label class="label"><span class="text-sky-700 font-semibold">in</span> LinkedIn</label>
                            <input type="url" name="social_profile_linkedin" value="{{ old('social_profile_linkedin', $socialLinks['social_profile_linkedin'] ?? '') }}" class="input-field" placeholder="https://linkedin.com/in/your-profile">
                        </div>
                        <div>
                            <label class="label"><span class="text-pink-600 font-semibold">ig</span> Instagram</label>
                            <input type="url" name="social_profile_instagram" value="{{ old('social_profile_instagram', $socialLinks['social_profile_instagram'] ?? '') }}" class="input-field" placeholder="https://instagram.com/your.handle">
                        </div>
                        <div>
                            <label class="label"><span class="text-red-600 font-semibold">yt</span> YouTube</label>
                            <input type="url" name="social_profile_youtube" value="{{ old('social_profile_youtube', $socialLinks['social_profile_youtube'] ?? '') }}" class="input-field" placeholder="https://youtube.com/@your-channel">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg hover:from-indigo-600 hover:to-purple-700 transition">Save Profile</button>
                </div>
            </div>

            {{-- Organization Tab --}}
            <div x-show="tab === 'organization'" x-cloak class="card p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Organization Details</h3>
                    <p class="text-sm text-gray-500">Your company or organization information.</p>
                </div>

                <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl">
                    <div class="relative">
                        <img src="{{ $profile->company_logo ? Storage::url($profile->company_logo) : asset('images/default-avatar.png') }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white shadow-sm bg-white" id="logoPreview">
                        <label for="company_logo" class="absolute -bottom-1 -right-1 w-7 h-7 bg-white border border-gray-200 rounded-full flex items-center justify-center cursor-pointer shadow-sm hover:bg-gray-50">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </label>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Company Logo</p>
                        <p class="text-xs text-gray-500">Upload your company logo (JPG, PNG, WebP)</p>
                        <input type="file" name="company_logo" id="company_logo" accept="image/*" class="hidden" onchange="document.getElementById('logoPreview').src = URL.createObjectURL(this.files[0])">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="label">Company Name</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" class="input-field" placeholder="Your Company Pvt. Ltd.">
                    </div>
                    <div>
                        <label class="label">Company Type</label>
                        <select name="company_type" class="input-field">
                            <option value="">Select Company Type</option>
                            @foreach(['Freelancer', 'Proprietorship', 'Partnership', 'Pvt. Ltd.', 'Public Ltd.', 'LLP', 'Non-Profit', 'Government', 'Other'] as $type)
                                <option value="{{ $type }}" {{ (old('company_type', $profile->company_type ?? $profile->business_type) === $type) ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Your Designation</label>
                        <input type="text" name="designation" value="{{ old('designation', $profile->designation) }}" class="input-field" placeholder="CEO / Director / Manager">
                    </div>
                    <div>
                        <label class="label">Official Email</label>
                        <input type="email" name="official_email" value="{{ old('official_email', $profile->official_email) }}" class="input-field" placeholder="contact@company.com">
                    </div>
                    <div>
                        <label class="label">Website URL</label>
                        <input type="url" name="website" value="{{ old('website', $profile->website) }}" class="input-field" placeholder="https://www.company.com">
                    </div>
                    <div>
                        <label class="label">LinkedIn Company URL</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="input-field" placeholder="https://linkedin.com/company/your-company">
                    </div>
                    <div>
                        <label class="label">Social Media Link</label>
                        <input type="url" name="social_media_link" value="{{ old('social_media_link', $profile->social_media_link) }}" class="input-field" placeholder="https://instagram.com/your-brand">
                    </div>
                    <div>
                        <label class="label">Years of Experience</label>
                        <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $profile->years_of_experience) }}" class="input-field" min="0" max="100" placeholder="5">
                    </div>
                    <div>
                        <label class="label">Team Size</label>
                        <input type="number" name="team_size" value="{{ old('team_size', $profile->team_size) }}" class="input-field" min="0" placeholder="10">
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Registered Address</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $profile->address) }}" class="input-field" placeholder="Street, building, area">
                        </div>
                        <div>
                            <label class="label">City</label>
                            <input type="text" name="city" value="{{ old('city', $profile->city) }}" class="input-field" placeholder="Mumbai">
                        </div>
                        <div>
                            <label class="label">State</label>
                            <input type="text" name="state" value="{{ old('state', $profile->state) }}" class="input-field" placeholder="Maharashtra">
                        </div>
                        <div>
                            <label class="label">Pincode</label>
                            <input type="text" name="pincode" value="{{ old('pincode', $profile->pincode) }}" class="input-field" placeholder="400001">
                        </div>
                        <div>
                            <label class="label">GST Number</label>
                            <input type="text" name="gst_number" value="{{ old('gst_number', $profile->gst_number ?? $profile->tax_id) }}" class="input-field" placeholder="27AAAPL1234C1Z1">
                        </div>
                        <div>
                            <label class="label">PAN Number</label>
                            <input type="text" name="pan_no" value="{{ old('pan_no', $profile->pan_no) }}" class="input-field" placeholder="AAAPL1234C">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">About</h4>
                    <div>
                        <label class="label">Description / Bio</label>
                        <textarea name="bio" rows="4" class="input-field" placeholder="Tell us about your organization...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg hover:from-indigo-600 hover:to-purple-700 transition">Save Organization</button>
                </div>
            </div>

            {{-- Verification Tab --}}
            <div x-show="tab === 'verification'" x-cloak class="card p-6 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Verification</h3>
                    <p class="text-sm text-gray-500">Verify your GST, PAN, and add client references.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-5 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">GST Verification</h4>
                                    <p class="text-xs text-gray-500">Tax registration status</p>
                                </div>
                            </div>
                            @if($profile->gst_verified)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Verified
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                                </span>
                            @endif
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="label text-xs">GST Number</label>
                                <input type="text" name="gst_number" value="{{ old('gst_number', $profile->gst_number ?? $profile->tax_id) }}" class="input-field text-sm" placeholder="27AAAPL1234C1Z1">
                            </div>
                            <div>
                                <label class="label text-xs">GST Legal Name</label>
                                <input type="text" name="gst_legal_name" value="{{ old('gst_legal_name', $profile->gst_legal_name) }}" class="input-field text-sm" placeholder="Registered business name as per GST">
                            </div>
                        </div>
                    </div>

                    <div class="p-5 border border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">PAN Verification</h4>
                                    <p class="text-xs text-gray-500">Tax identification</p>
                                </div>
                            </div>
                            @if($profile->pan_verified)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Verified
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="label text-xs">PAN Number</label>
                            <input type="text" name="pan_no" value="{{ old('pan_no', $profile->pan_no) }}" class="input-field text-sm" placeholder="AAAPL1234C">
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Client References</h4>
                            <p class="text-xs text-gray-500">Add up to 5 client references (name, mobile, email).</p>
                        </div>
                    </div>

                    <div id="refs-container" class="space-y-3">
                        @for($i = 0; $i < max(5, count($refs)); $i++)
                            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl reference-row">
                                <div class="w-8 h-8 rounded-lg bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-500 shrink-0">{{ $i + 1 }}</div>
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="label text-xs">Name</label>
                                        <input type="text" name="client_references[{{ $i }}][name]" value="{{ $refs[$i]['name'] ?? '' }}" class="input-field text-sm" placeholder="Client name">
                                    </div>
                                    <div>
                                        <label class="label text-xs">Mobile</label>
                                        <input type="text" name="client_references[{{ $i }}][mobile]" value="{{ $refs[$i]['mobile'] ?? '' }}" class="input-field text-sm" placeholder="+91 98765 43210">
                                    </div>
                                    <div>
                                        <label class="label text-xs">Email</label>
                                        <input type="email" name="client_references[{{ $i }}][email]" value="{{ $refs[$i]['email'] ?? '' }}" class="input-field text-sm" placeholder="client@example.com">
                                    </div>
                                </div>
                                @if($i > 0)
                                    <button type="button" onclick="this.closest('.reference-row').remove()" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @else
                                    <div class="w-8 shrink-0"></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                    <button type="button" onclick="addReference()" class="mt-3 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Add Reference
                    </button>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg hover:from-indigo-600 hover:to-purple-700 transition">Save Verification Info</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function addReference() {
            const container = document.getElementById('refs-container');
            const rows = container.querySelectorAll('.reference-row');
            if (rows.length >= 5) return;
            const i = rows.length;
            const div = document.createElement('div');
            div.className = 'flex items-start gap-3 p-4 bg-gray-50 rounded-xl reference-row';
            div.innerHTML = `
                <div class="w-8 h-8 rounded-lg bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-500 shrink-0">${i + 1}</div>
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div><label class="label text-xs">Name</label><input type="text" name="client_references[${i}][name]" class="input-field text-sm" placeholder="Client name"></div>
                    <div><label class="label text-xs">Mobile</label><input type="text" name="client_references[${i}][mobile]" class="input-field text-sm" placeholder="+91 98765 43210"></div>
                    <div><label class="label text-xs">Email</label><input type="email" name="client_references[${i}][email]" class="input-field text-sm" placeholder="client@example.com"></div>
                </div>
                <button type="button" onclick="this.closest('.reference-row').remove()" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>`;
            container.appendChild(div);
            renumerateRefs();
        }
        function renumerateRefs() {
            document.querySelectorAll('#refs-container .reference-row').forEach((row, idx) => {
                row.querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) input.setAttribute('name', name.replace(/\[\d+\]/, `[${idx}]`));
                });
                row.querySelector('div:first-child').textContent = idx + 1;
            });
        }
    </script>
    @endpush
</x-app-layout>