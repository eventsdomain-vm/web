<x-guest-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Back Link --}}
        <a href="{{ route('partners.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#F26C4F] mb-6 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Partners
        </a>

        {{-- Partner Header --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
            <div class="h-48 bg-gradient-to-br from-[#F26C4F] to-orange-300 flex items-center justify-center">
                @if($partner->logo_path)
                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->company_name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-6xl font-bold text-white/60">{{ strtoupper(substr($partner->company_name, 0, 1)) }}</span>
                @endif
            </div>

            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $partner->company_name }}</h1>
                        @if($partner->contact_person)
                            <p class="text-sm text-gray-500 mt-1">{{ $partner->contact_person }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        @if($partner->rating > 0)
                            <span class="flex items-center gap-1 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ number_format($partner->rating, 1) }}
                            </span>
                        @endif
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Verified</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mt-4">
                    @if($partner->city)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $partner->city }}, {{ $partner->country }}
                        </span>
                    @endif
                    @if($partner->contact_email)
                        <a href="mailto:{{ $partner->contact_email }}" class="flex items-center gap-1 hover:text-[#F26C4F] transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $partner->contact_email }}
                        </a>
                    @endif
                    @if($partner->contact_phone)
                        <a href="tel:{{ $partner->contact_phone }}" class="flex items-center gap-1 hover:text-[#F26C4F] transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $partner->contact_phone }}
                        </a>
                    @endif
                    @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" rel="noopener" class="flex items-center gap-1 hover:text-[#F26C4F] transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                            Website
                        </a>
                    @endif
                </div>

                @if($partner->budget_range)
                    <div class="mt-4">
                        <span class="text-xs text-gray-500">Budget Range:</span>
                        <span class="ml-1 text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $partner->budget_range)) }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- About --}}
        @if($partner->about)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">About</h2>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $partner->about }}</p>
            </div>
        @endif

        {{-- Services --}}
        @if($partner->services->count())
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Services</h2>
                <div class="space-y-4">
                    @foreach($partner->services as $service)
                        <div class="border border-gray-100 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $service->title }}</h3>
                                    @if($service->category)
                                        <span class="text-xs text-[#F26C4F]">{{ $service->category->name }}</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-semibold text-gray-900">{{ $service->formatted_price }}</span>
                                    <span class="block text-xs text-gray-500">{{ $service->price_type_label }}</span>
                                </div>
                            </div>
                            @if($service->description)
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($service->description, 150) }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                                <span>{{ $service->pricing_model_label }}</span>
                                @if($service->is_available)
                                    <span class="text-green-600">Available</span>
                                @else
                                    <span class="text-red-500">Unavailable</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Profile --}}
        @if($partner->profile)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Company Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    @if($partner->profile->company_name)
                        <div><dt class="text-gray-500">Company</dt><dd class="text-gray-900 font-medium">{{ $partner->profile->company_name }}</dd></div>
                    @endif
                    @if($partner->profile->business_type)
                        <div><dt class="text-gray-500">Business Type</dt><dd class="text-gray-900 font-medium">{{ $partner->profile->business_type }}</dd></div>
                    @endif
                    @if($partner->profile->team_size)
                        <div><dt class="text-gray-500">Team Size</dt><dd class="text-gray-900 font-medium">{{ $partner->profile->team_size }}</dd></div>
                    @endif
                    @if($partner->profile->years_of_experience)
                        <div><dt class="text-gray-500">Experience</dt><dd class="text-gray-900 font-medium">{{ $partner->profile->years_of_experience }} years</dd></div>
                    @endif
                    @if($partner->profile->bio)
                        <div class="sm:col-span-2"><dt class="text-gray-500">Bio</dt><dd class="text-gray-900 mt-1">{{ $partner->profile->bio }}</dd></div>
                    @endif
                </dl>
            </div>
        @endif

    </div>
</x-guest-layout>
