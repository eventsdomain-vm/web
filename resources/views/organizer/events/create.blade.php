<x-app-layout>
    <x-slot name="title">Submit Event - EventsDomain</x-slot>

    @php
        $timezones = ['Asia/Kolkata', 'America/New_York', 'America/Los_Angeles', 'Europe/London', 'Europe/Berlin', 'Asia/Dubai', 'Asia/Singapore', 'Australia/Sydney'];
    @endphp

    <div x-data="eventCreateWizard(@js($draft->data ?? []), {{ $draft->current_step ?? 1 }})"
         x-init="init()"
         data-plans='@json($plans)'
         data-audience-types='@json($audienceTypes)'
         data-age-groups='@json($ageGroups)'
         data-industries='@json($industries)'
         data-categories='@json($categories)'
         class="max-w-5xl mx-auto space-y-6 pb-12">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 flex items-center gap-2">
            <a href="{{ route('organizer.dashboard') }}" class="hover:text-gray-700 transition">Dashboard</a>
            <span>&rsaquo;</span>
            <span class="text-gray-900 font-medium">Submit Event</span>
        </div>

        {{-- Info Banner --}}
        <div class="bg-white rounded-xl border border-red-100 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-l-4 border-[#F26C4F] relative overflow-hidden">
            <div class="space-y-1">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <span class="text-[#F26C4F] shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </span>
                    List Your Event for Sponsorship
                </h2>
                <p class="text-sm text-gray-500">Complete the form below to submit your event. Our team will review it and contact you regarding listing options.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 md:gap-4 shrink-0 text-xs font-semibold text-gray-700">
                <span class="flex items-center gap-1 bg-rose-50 text-[#F26C4F] px-3 py-1.5 rounded-full border border-rose-100">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Free to submit
                </span>
                <span class="flex items-center gap-1 bg-rose-50 text-[#F26C4F] px-3 py-1.5 rounded-full border border-rose-100">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Review within 24-48 hours
                </span>
                <span class="flex items-center gap-1 bg-rose-50 text-[#F26C4F] px-3 py-1.5 rounded-full border border-rose-100">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Payment discussed after review
                </span>
            </div>
        </div>

        {{-- Auto-save indicator & Clear draft --}}
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-2">
                <div class="text-[#F26C4F] flex items-center gap-1.5 text-sm font-medium">
                    <template x-if="saving">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Saving...
                        </span>
                    </template>
                    <template x-if="!saving">
                        <span class="flex items-center gap-1.5 text-gray-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                            Draft saved
                        </span>
                    </template>
                </div>
            </div>
            <button type="button" @click="clearDraft()" class="text-gray-500 hover:text-red-600 flex items-center gap-1.5 text-sm font-semibold transition py-1 px-3 rounded-lg hover:bg-red-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Clear Draft
            </button>
        </div>

        {{-- Step Tracker --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="relative flex items-center justify-between w-full overflow-x-auto pb-2 scrollbar-none">
                {{-- Background Progress Line --}}
                <div class="absolute left-0 top-[22px] right-0 h-0.5 bg-gray-100 -z-10 min-w-[700px]"></div>
                <div class="absolute left-0 top-[22px] h-0.5 bg-[#F26C4F] transition-all duration-500 -z-10 min-w-[700px]"
                     :style="'width: ' + ((step - 1) / 6 * 100) + '%'"></div>

                <template x-for="(sName, idx) in steps" :key="idx">
                    <button type="button" @click="goToStep(idx + 1)" :disabled="idx + 1 > maxStep"
                            class="flex flex-col items-center text-center gap-2 group transition shrink-0 min-w-[80px]"
                            :class="idx + 1 > maxStep ? 'cursor-not-allowed opacity-60' : 'cursor-pointer'">
                        
                        <div class="w-11 h-11 rounded-full flex items-center justify-center border-2 transition duration-300"
                             :class="idx + 1 < step 
                                ? 'bg-[#F26C4F] border-[#F26C4F] text-white shadow-sm' 
                                : (idx + 1 === step 
                                    ? 'bg-white border-[#F26C4F] text-[#F26C4F] ring-4 ring-rose-50 font-bold' 
                                    : 'bg-white border-gray-200 text-gray-400')">
                            
                            {{-- Step Icons --}}
                            <template x-if="idx + 1 < step">
                                <svg class="w-5 h-5 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="idx + 1 >= step">
                                <span class="text-sm font-semibold">
                                    {{-- SVGs for step items --}}
                                    <template x-if="idx === 0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </template>
                                    <template x-if="idx === 1">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </template>
                                    <template x-if="idx === 2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V5"/></svg>
                                    </template>
                                    <template x-if="idx === 3">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </template>
                                    <template x-if="idx === 4">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </template>
                                    <template x-if="idx === 5">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </template>
                                    <template x-if="idx === 6">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.243.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.906a1 1 0 00.95-.69l1.519-4.674z"/></svg>
                                    </template>
                                </span>
                            </template>
                        </div>
                        <span class="text-xs font-semibold select-none transition" 
                              :class="idx + 1 === step ? 'text-gray-900 font-bold' : 'text-gray-400'"
                              x-text="sName"></span>
                    </button>
                </template>
            </div>
        </div>

        {{-- Form Steps Wrapper --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 md:p-8 space-y-6">

            {{-- STEP 1: Basic Info --}}
            <div x-show="step === 1" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Basic Info</h3>
                    <p class="text-sm text-gray-500">Provide details about your event to help sponsors learn about it.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event Title <span class="text-red-500">*</span></label>
                        <input type="text" x-model="data.title" 
                               class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                               placeholder="Enter your event title">
                        <template x-if="errors.title"><p class="text-red-500 text-xs mt-1" x-text="errors.title"></p></template>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event Description <span class="text-red-500">*</span></label>
                        <textarea x-model="data.description" rows="5" 
                                  class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                                  placeholder="Describe your event, target audience, sponsorship opportunities..."></textarea>
                        <template x-if="errors.description"><p class="text-red-500 text-xs mt-1" x-text="errors.description"></p></template>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Main Category <span class="text-red-500">*</span></label>
                            <select x-model="data.category_id" 
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select main category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <template x-if="errors.category_id"><p class="text-red-500 text-xs mt-1" x-text="errors.category_id"></p></template>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sub Category <span class="text-xs text-gray-400 font-normal">(optional)</span></label>
                            <select x-model="data.subcategory_id" 
                                    :disabled="!data.category_id"
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm disabled:bg-gray-50 disabled:text-gray-400">
                                <option value="">Select sub category</option>
                                <template x-if="data.category_id">
                                    <template x-for="cat in parentCategories" :key="cat.id">
                                        <template x-if="cat.id == data.category_id">
                                            <template x-for="sub in cat.children" :key="sub.id">
                                                <option :value="sub.id" x-text="sub.name"></option>
                                            </template>
                                        </template>
                                    </template>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event Start Date <span class="text-red-500">*</span></label>
                            <input type="date" x-model="data.start_date" 
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                            <template x-if="errors.start_date"><p class="text-red-500 text-xs mt-1" x-text="errors.start_date"></p></template>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Start Time</label>
                            <select x-model="data.start_time" 
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select start time</option>
                                @foreach(range(0, 47) as $slot)
                                    @php $h = floor($slot / 2); $m = ($slot % 2) * 30; $timeStr = sprintf('%02d:%02d', $h, $m); @endphp
                                    <option value="{{ $timeStr }}">{{ $timeStr }}</option>
                                @endforeach
                            </select>
                            <template x-if="errors.start_time"><p class="text-red-500 text-xs mt-1" x-text="errors.start_time"></p></template>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event End Date</label>
                            <input type="date" x-model="data.end_date" 
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                            <template x-if="errors.end_date"><p class="text-red-500 text-xs mt-1" x-text="errors.end_date"></p></template>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">End Time</label>
                            <select x-model="data.end_time" 
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select end time</option>
                                @foreach(range(0, 47) as $slot)
                                    @php $h = floor($slot / 2); $m = ($slot % 2) * 30; $timeStr = sprintf('%02d:%02d', $h, $m); @endphp
                                    <option value="{{ $timeStr }}">{{ $timeStr }}</option>
                                @endforeach
                            </select>
                            <template x-if="errors.end_time"><p class="text-red-500 text-xs mt-1" x-text="errors.end_time"></p></template>
                        </div>
                    </div>

                    {{-- Artist / Speaker / Celebrity Details --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Artist / Speaker / Celebrity Details</label>
                        <p class="text-xs text-gray-400 mb-3">Add key personalities appearing at your event. This information is displayed to sponsors and attendees.</p>

                        <div class="space-y-4">
                            <template x-for="(person, idx) in data.participants" :key="idx">
                                <div class="border border-gray-200 rounded-xl p-4 bg-white relative shadow-sm transition hover:shadow-md">
                                    <button type="button" @click="removeParticipant(idx)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-8">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Name <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="person.name" placeholder="e.g. Arijit Singh, Priyanka Chopra" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Type <span class="text-red-500">*</span></label>
                                            <select x-model="person.type" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm">
                                                <option value="">Select type</option>
                                                <option value="speaker">Speaker</option>
                                                <option value="artist">Artist / Performer</option>
                                                <option value="celebrity">Celebrity</option>
                                                <option value="dj">DJ</option>
                                                <option value="panelist">Panelist</option>
                                                <option value="judge">Judge</option>
                                                <option value="mentor">Mentor</option>
                                                <option value="moderator">Moderator</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Organization / Company</label>
                                            <input type="text" x-model="person.organization" placeholder="e.g. T-Series, MIT" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Designation / Role</label>
                                            <input type="text" x-model="person.designation" placeholder="e.g. Chief Guest, Keynote Speaker" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Bio / Description</label>
                                            <textarea x-model="person.bio" rows="2" placeholder="Brief description about this person..." class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm"></textarea>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Photo</label>
                                            <div class="flex items-center gap-4">
                                                <template x-if="person.photo_url">
                                                    <img :src="person.photo_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                                                </template>
                                                <template x-if="!person.photo_url">
                                                    <div class="w-16 h-16 rounded-lg bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    </div>
                                                </template>
                                                <label class="cursor-pointer">
                                                    <span class="text-xs font-semibold text-[#F26C4F] hover:underline">Upload Photo</span>
                                                    <input type="file" accept="image/*" class="hidden" @change="uploadParticipantPhoto(idx, $event.target.files[0])">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="addParticipant()" class="w-full py-3 rounded-xl border-2 border-dashed border-gray-300 text-sm font-bold text-gray-500 hover:text-[#F26C4F] hover:border-[#F26C4F] hover:bg-rose-50/20 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Add Artist / Speaker / Celebrity
                            </button>
                        </div>
                    </div>

                    {{-- Schedule Performances (assign added artists to dates with times) --}}
                    <div x-show="data.participants.length > 0 && eventDates.length > 0">
                        <div class="border-t border-gray-100 pt-5 mt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Schedule Performances</label>
                            <p class="text-xs text-gray-400 mb-3">Assign your added artists/speakers to specific dates and time slots.</p>

                            <div class="space-y-3">
                                <template x-for="(sch, idx) in data.schedule" :key="idx">
                                    <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl p-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3">
                                            {{-- Date --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Date</label>
                                                <template x-if="eventDates.length === 1">
                                                    <input type="text" :value="eventDates[0]?.label" readonly class="w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-xs text-gray-700">
                                                </template>
                                                <template x-if="eventDates.length > 1">
                                                    <select x-model="sch.date" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-xs">
                                                        <option value="">Select date</option>
                                                        <template x-for="d in eventDates" :key="d.value">
                                                            <option :value="d.value" x-text="d.label"></option>
                                                        </template>
                                                    </select>
                                                </template>
                                            </div>
                                            {{-- Artist --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Artist / Speaker</label>
                                                <select x-model="sch.participant_idx" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-xs">
                                                    <option value="">Select artist</option>
                                                    <template x-for="(p, pIdx) in data.participants" :key="pIdx">
                                                        <option :value="pIdx" x-text="p.name || ('Person #' + (pIdx + 1))"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            {{-- Start Time --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Start Time</label>
                                                <input type="time" x-model="sch.start_time" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-xs">
                                            </div>
                                            {{-- End Time --}}
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 mb-1">End Time</label>
                                                <input type="time" x-model="sch.end_time" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-xs">
                                            </div>
                                        </div>
                                        <button type="button" @click="removeSchedule(idx)" class="text-gray-400 hover:text-red-500 transition p-1 shrink-0">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </template>

                                <button type="button" @click="addSchedule()" class="w-full py-2.5 rounded-xl border-2 border-dashed border-gray-200 text-xs font-bold text-gray-400 hover:text-[#F26C4F] hover:border-[#F26C4F] hover:bg-rose-50/20 transition flex items-center justify-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    Add Time Slot
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="step === 2" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Location</h3>
                    <p class="text-sm text-gray-500">Provide venue and location coordinates so sponsors know where the event is held.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Venue Name <span class="text-red-500">*</span></label>
                        <input type="text" x-model="data.venue_name" 
                               class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                               placeholder="e.g. Nehru Stadium, Convention Center...">
                        <template x-if="errors.venue_name"><p class="text-red-500 text-xs mt-1" x-text="errors.venue_name"></p></template>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Venue Address</label>
                        <textarea x-model="data.venue_address" rows="3" 
                                  class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                                  placeholder="Full address of the venue..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Country <span class="text-red-500">*</span></label>
                            <select x-model="data.country" 
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="India">India</option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Singapore">Singapore</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                            </select>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-sm font-semibold text-gray-700">City <span class="text-red-500">*</span></label>
                                <button type="button" @click="manualCityMode = !manualCityMode; if(!manualCityMode) { data.city = ''; }" 
                                        class="text-xs text-[#F26C4F] hover:underline font-semibold"
                                        x-text="manualCityMode ? 'Select from list' : 'Can\'t find your city?'"></button>
                            </div>

                            {{-- Searchable Autocomplete/Typeahead --}}
                            <div x-show="!manualCityMode">
                                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                    <input type="text" 
                                           class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                                           placeholder="Search and select city"
                                           x-model="cityQuery"
                                           @focus="open = true"
                                           @input="open = true; data.city = ''">
                                    <template x-if="errors.city"><p class="text-red-500 text-xs mt-1" x-text="errors.city"></p></template>

                                    <div x-show="open && filteredCities().length > 0" 
                                         class="absolute left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-1">
                                        <template x-for="c in filteredCities()" :key="c">
                                            <button type="button" @click="data.city = c; cityQuery = c; open = false;"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-rose-50 hover:text-[#F26C4F] transition"
                                                    x-text="c"></button>
                                        </template>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1 pl-1">Select if your city is listed</div>
                                </div>
                            </div>

                            {{-- Manual Input Fallback --}}
                            <div x-show="manualCityMode">
                                <input type="text" x-model="data.city"
                                       class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                                       placeholder="Enter city name manually">
                                <template x-if="errors.city"><p class="text-red-500 text-xs mt-1" x-text="errors.city"></p></template>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">State</label>
                            <input type="text" x-model="data.state"
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm"
                                   placeholder="e.g. Gujarat, Maharashtra">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Contact Phone</label>
                            <input type="tel" x-model="data.contact_no"
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm"
                                   placeholder="e.g. +91 98765 43210">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event Website</label>
                        <input type="url" x-model="data.website_url"
                               class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm"
                               placeholder="https://example.com">
                    </div>
                </div>
            </div>

            {{-- STEP 3: Sponsorship --}}
            <div x-show="step === 3" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Sponsorship Details</h3>
                    <p class="text-sm text-gray-500">Provide info regarding the budget size and select what sponsorship options you offer.</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Expected Audience Size</label>
                            <input type="number" x-model="data.expected_audience_size" 
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" 
                                   placeholder="e.g. 5000">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sponsorship Budget Range</label>
                            <select x-model="data.sponsorship_budget_range" 
                                    class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select budget range</option>
                                <option value="Under ₹1 Lakh">Under ₹1 Lakh</option>
                                <option value="₹1-5 Lakhs">₹1-5 Lakhs</option>
                                <option value="₹5-10 Lakhs">₹5-10 Lakhs</option>
                                <option value="₹10-25 Lakhs">₹10-25 Lakhs</option>
                                <option value="₹25-50 Lakhs">₹25-50 Lakhs</option>
                                <option value="₹50 Lakhs+">₹50 Lakhs+</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sponsorship Type <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-400 mb-3">What type of sponsorship are you looking for?</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="relative border rounded-xl p-5 flex items-start gap-3.5 cursor-pointer hover:border-[#F26C4F] transition-all duration-200"
                                   :class="data.sponsorship_type === 'cash' ? 'border-[#F26C4F] bg-rose-50/20 ring-1 ring-[#F26C4F]' : 'border-gray-200 bg-white'">
                                <input type="radio" name="sponsorship_type" value="cash" x-model="data.sponsorship_type" class="sr-only">
                                <span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center mt-1 shrink-0"
                                      :class="data.sponsorship_type === 'cash' ? 'border-[#F26C4F]' : ''">
                                    <span class="w-2 h-2 rounded-full" :class="data.sponsorship_type === 'cash' ? 'bg-[#F26C4F]' : 'bg-transparent'"></span>
                                </span>
                                <div>
                                    <div class="flex items-center gap-1.5 font-bold text-gray-900 text-sm">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V5"/></svg>
                                        Cash
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Monetary sponsorship</p>
                                </div>
                            </label>

                            <label class="relative border rounded-xl p-5 flex items-start gap-3.5 cursor-pointer hover:border-[#F26C4F] transition-all duration-200"
                                   :class="data.sponsorship_type === 'barter' ? 'border-[#F26C4F] bg-rose-50/20 ring-1 ring-[#F26C4F]' : 'border-gray-200 bg-white'">
                                <input type="radio" name="sponsorship_type" value="barter" x-model="data.sponsorship_type" class="sr-only">
                                <span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center mt-1 shrink-0"
                                      :class="data.sponsorship_type === 'barter' ? 'border-[#F26C4F]' : ''">
                                    <span class="w-2 h-2 rounded-full" :class="data.sponsorship_type === 'barter' ? 'bg-[#F26C4F]' : 'bg-transparent'"></span>
                                </span>
                                <div>
                                    <div class="flex items-center gap-1.5 font-bold text-gray-900 text-sm">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                        Barter
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">In-kind/exchange</p>
                                </div>
                            </label>

                            <label class="relative border rounded-xl p-5 flex items-start gap-3.5 cursor-pointer hover:border-[#F26C4F] transition-all duration-200"
                                   :class="data.sponsorship_type === 'paid_barter' ? 'border-[#F26C4F] bg-rose-50/20 ring-1 ring-[#F26C4F]' : 'border-gray-200 bg-white'">
                                <input type="radio" name="sponsorship_type" value="paid_barter" x-model="data.sponsorship_type" class="sr-only">
                                <span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center mt-1 shrink-0"
                                      :class="data.sponsorship_type === 'paid_barter' ? 'border-[#F26C4F]' : ''">
                                    <span class="w-2 h-2 rounded-full" :class="data.sponsorship_type === 'paid_barter' ? 'bg-[#F26C4F]' : 'bg-transparent'"></span>
                                </span>
                                <div>
                                    <div class="flex items-center gap-1.5 font-bold text-gray-900 text-sm">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Paid + Barter
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Monetary + In-kind</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Sponsorship Levels (pre-defined cards) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Available Sponsorship Levels</label>
                        <p class="text-xs text-gray-400 mb-3">Select the sponsorship opportunities you're offering</p>
                        <div class="space-y-4">
                            <template x-for="(level, idx) in sponsorshipLevelDefs" :key="level.id">
                                <div class="border rounded-xl p-5 bg-white relative transition-all duration-200"
                                     :class="level.checked ? 'border-[#F26C4F] bg-rose-50/10' : 'border-gray-200'">
                                    <div class="flex items-start gap-3">
                                        <input type="checkbox" :checked="level.checked" @change="level.checked = !level.checked"
                                               class="w-5 h-5 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F] mt-0.5 shrink-0">
                                        <div class="flex-1 space-y-3">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[#F26C4F]" x-html="level.icon"></span>
                                                <span class="font-bold text-gray-900 text-sm" x-text="level.name"></span>
                                            </div>
                                            <p class="text-xs text-gray-500" x-text="level.description"></p>

                                            <template x-if="level.checked && level.id !== 'other'">
                                                <div class="space-y-3 pt-2 border-t border-gray-100">
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-xs font-bold text-gray-700">Number of slots:</span>
                                                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                            <button type="button" @click="if(level.slots > 1) level.slots--" class="px-3 py-1.5 text-gray-500 hover:bg-gray-100 transition font-extrabold text-sm">-</button>
                                                            <span class="px-3 py-1.5 text-sm font-bold text-gray-900 min-w-[2rem] text-center" x-text="level.slots"></span>
                                                            <button type="button" @click="if(level.slots < 10) level.slots++" class="px-3 py-1.5 text-gray-500 hover:bg-gray-100 transition font-extrabold text-sm">+</button>
                                                        </div>
                                                        <span class="text-xs text-gray-400">(max 10)</span>
                                                    </div>
                                                    <div>
                                                        <span class="block text-xs font-bold text-gray-700 mb-2">Budget per slot:</span>
                                                        <div class="flex flex-wrap gap-2">
                                                            <template x-for="b in budgetPills" :key="b">
                                                                <button type="button" @click="level.budget = b"
                                                                        class="px-3.5 py-1.5 rounded-full border text-xs font-semibold transition"
                                                                        :class="level.budget === b 
                                                                            ? 'border-[#F26C4F] bg-[#F26C4F] text-white shadow-xs' 
                                                                            : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'"
                                                                        x-text="b"></button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <template x-if="level.checked && level.id === 'other'">
                                                <div class="pt-2 border-t border-gray-100">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" x-model="level.customName" placeholder="Enter custom sponsorship level name"
                                                               class="flex-1 rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-3 py-2 text-sm">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Sponsorship Benefits (categorized accordions) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sponsorship Benefits</label>
                        <p class="text-xs text-gray-400 mb-3">What benefits do you offer to sponsors?</p>
                        <div class="space-y-3">
                            <template x-for="cat in benefitCategories" :key="cat.id">
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <button type="button" @click="cat.open = !cat.open" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition">
                                        <span class="flex items-center gap-2">
                                            <span class="text-[#F26C4F]" x-html="cat.icon"></span>
                                            <span class="text-sm font-bold text-gray-700" x-text="cat.name"></span>
                                        </span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="cat.open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="cat.open" class="p-4">
                                        <button type="button" @click="toggleCategoryBenefits(cat)" class="text-xs text-[#F26C4F] font-semibold mb-3 block hover:underline">Select All</button>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <template x-for="b in cat.benefits" :key="b.id">
                                                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all"
                                                       :class="data.sponsorship_benefits.includes(b.id) ? 'border-[#F26C4F] bg-rose-50/20' : 'border-gray-100 hover:border-gray-200'">
                                                    <input type="checkbox" :value="b.id" @change="toggleBenefit(b.id)" :checked="data.sponsorship_benefits.includes(b.id)" class="w-4 h-4 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700" x-text="b.label"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 4: Add-Ons --}}
            <div x-show="step === 4" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Add-Ons Options</h3>
                    <p class="text-sm text-gray-500">These provide additional monetization opportunities beyond main sponsorship levels.</p>
                </div>

                {{-- Add-ons info banner --}}
                <div class="bg-rose-50/50 border border-rose-100 rounded-xl p-4 text-xs font-semibold text-gray-600">
                    <span class="text-[#F26C4F] font-bold">Add-ons are optional.</span> These provide additional monetization opportunities beyond main sponsorship levels.
                </div>

                <div class="space-y-6">
                    {{-- Stall & Booth Options --}}
                    <div class="border border-gray-200 rounded-xl p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-md bg-rose-100 text-[#F26C4F] flex items-center justify-center text-xs">🏪</span>
                                    Stall & Booth Options
                                </h4>
                                <p class="text-xs text-[#F26C4F] mt-0.5">Add exhibition stalls or brand experience booths</p>
                            </div>
                            <button type="button" @click="addStall()" class="text-xs border border-[#F26C4F] text-[#F26C4F] hover:bg-[#F26C4F] hover:text-white font-semibold py-1.5 px-3 rounded-lg flex items-center gap-1 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Add Stall
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(s, idx) in data.stalls" :key="idx">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 border-b border-gray-100 px-4 py-2.5 flex items-center justify-between">
                                        <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                                            <span class="w-4 h-4 rounded bg-rose-100 text-[#F26C4F] flex items-center justify-center text-[9px]">🏪</span>
                                            <span x-text="'Stall #' + (idx + 1)"></span>
                                        </span>
                                        <button type="button" @click="removeStall(idx)" class="text-gray-400 hover:text-red-500 transition p-1 rounded hover:bg-red-50">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                    <div class="p-4 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Stall Type</label>
                                                <select x-model="s.stall_type" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3">
                                                    <option value="">Select type</option>
                                                    <option value="Exhibition Stall">Exhibition Stall</option>
                                                    <option value="Brand Experience Booth">Brand Experience Booth</option>
                                                    <option value="Demo Booth">Demo Booth</option>
                                                    <option value="Information Desk">Information Desk</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Stall Size</label>
                                                <select x-model="s.stall_size" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3">
                                                    <option value="">Select size</option>
                                                    <option value="Small (6x6 ft)">Small (6x6 ft)</option>
                                                    <option value="Medium (10x10 ft)">Medium (10x10 ft)</option>
                                                    <option value="Large (15x15 ft)">Large (15x15 ft)</option>
                                                    <option value="Extra Large (20x20 ft)">Extra Large (20x20 ft)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Location</label>
                                                <select x-model="s.location" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3">
                                                    <option value="">Select location</option>
                                                    <option value="Entry Area">Entry Area</option>
                                                    <option value="Near Stage">Near Stage</option>
                                                    <option value="Food Zone">Food Zone</option>
                                                    <option value="Main Arena">Main Arena</option>
                                                    <option value="Outdoor Area">Outdoor Area</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Number Available</label>
                                                <input type="number" x-model="s.number_available" min="1" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3" placeholder="1">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="flex items-center justify-between border border-gray-100 rounded-lg p-3 bg-gray-50">
                                                <span class="text-xs font-semibold text-gray-700">Power Supply Required</span>
                                                <button type="button" @click="s.power_supply = !s.power_supply"
                                                    :class="s.power_supply ? 'bg-[#F26C4F]' : 'bg-gray-200'"
                                                    class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors">
                                                    <span :class="s.power_supply ? 'translate-x-4' : 'translate-x-0.5'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm"></span>
                                                </button>
                                            </div>
                                            <div class="flex items-center justify-between border border-gray-100 rounded-lg p-3 bg-gray-50">
                                                <span class="text-xs font-semibold text-gray-700">Furniture Included</span>
                                                <button type="button" @click="s.furniture_included = !s.furniture_included"
                                                    :class="s.furniture_included ? 'bg-[#F26C4F]' : 'bg-gray-200'"
                                                    class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors">
                                                    <span :class="s.furniture_included ? 'translate-x-4' : 'translate-x-0.5'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pricing Type</label>
                                            <div class="flex items-center gap-4">
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'stall_pricing_' + idx" value="cash" x-model="s.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Cash</span>
                                                </label>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'stall_pricing_' + idx" value="barter" x-model="s.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Barter</span>
                                                </label>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'stall_pricing_' + idx" value="both" x-model="s.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Both</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Price per Stall (₹)</label>
                                            <input type="number" x-model="s.price" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3" placeholder="e.g. 50000">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="data.stalls.length === 0">
                                <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-3">
                                    <span class="w-12 h-12 rounded-full bg-rose-50 text-[#F26C4F] flex items-center justify-center text-2xl">🏪</span>
                                    <p class="text-xs text-gray-400 font-medium">No stalls or booths added yet</p>
                                    <button type="button" @click="addStall()" class="text-xs text-[#F26C4F] font-bold hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Add Your First Stall
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Food & Beverage Sponsorship --}}
                    <div class="border border-gray-200 rounded-xl p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-md bg-rose-100 text-[#F26C4F] flex items-center justify-center text-xs">☕</span>
                                    Food & Beverage Sponsorship
                                </h4>
                                <p class="text-xs text-[#F26C4F] mt-0.5">Add F&B partnership opportunities</p>
                            </div>
                            <button type="button" @click="addFnb()" class="text-xs border border-[#F26C4F] text-[#F26C4F] hover:bg-[#F26C4F] hover:text-white font-semibold py-1.5 px-3 rounded-lg flex items-center gap-1 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Add F&B Option
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(f, idx) in data.fnb_options" :key="idx">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 border-b border-gray-100 px-4 py-2.5 flex items-center justify-between">
                                        <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                                            <span class="w-4 h-4 rounded bg-rose-100 text-[#F26C4F] flex items-center justify-center text-[9px]">☕</span>
                                            <span x-text="'F&B Option #' + (idx + 1)"></span>
                                        </span>
                                        <button type="button" @click="removeFnb(idx)" class="text-gray-400 hover:text-red-500 transition p-1 rounded hover:bg-red-50">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                    <div class="p-4 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Partner Type</label>
                                                <select x-model="f.partner_type" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3">
                                                    <option value="">Select partner type</option>
                                                    <option value="Food Stall Partner">Food Stall Partner</option>
                                                    <option value="Beverage Partner">Beverage Partner</option>
                                                    <option value="Snacks Partner">Snacks Partner</option>
                                                    <option value="Water Partner">Water Partner</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Number of Slots</label>
                                                <input type="number" x-model="f.slots" min="1" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3" placeholder="1">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pricing Type</label>
                                            <div class="flex items-center gap-4">
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'fnb_pricing_' + idx" value="cash" x-model="f.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Cash</span>
                                                </label>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'fnb_pricing_' + idx" value="barter" x-model="f.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Barter</span>
                                                </label>
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" :name="'fnb_pricing_' + idx" value="both" x-model="f.pricing_type" class="text-[#F26C4F] focus:ring-[#F26C4F]">
                                                    <span class="text-xs font-medium text-gray-700">Both</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Value (₹)</label>
                                            <input type="number" x-model="f.price" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] text-xs py-2 px-3" placeholder="e.g. 25000">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="data.fnb_options.length === 0">
                                <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-3">
                                    <span class="w-12 h-12 rounded-full bg-rose-50 text-[#F26C4F] flex items-center justify-center text-2xl">☕</span>
                                    <p class="text-xs text-gray-400 font-medium">No F&B sponsorship options added yet</p>
                                    <button type="button" @click="addFnb()" class="text-xs text-[#F26C4F] font-bold hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Add F&B Option
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Advertising Spaces (Categorized Accordion) --}}
                    <div class="border border-gray-200 rounded-xl p-5 space-y-4">
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md bg-rose-100 text-[#F26C4F] flex items-center justify-center text-xs">📢</span>
                                Advertising Spaces
                            </h4>
                            <p class="text-xs text-[#F26C4F] mt-0.5">Select available advertising placements</p>
                        </div>

                        {{-- Physical Advertising --}}
                        <div x-data="{ openPhysical: true }" class="border border-gray-100 rounded-xl overflow-hidden">
                            <button type="button" @click="openPhysical = !openPhysical" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition">
                                <span class="text-xs font-bold text-gray-700 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-orange-100 text-orange-500 flex items-center justify-center text-[10px]">📍</span>
                                    Physical Advertising
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openPhysical ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="openPhysical" class="p-4">
                                <button type="button" @click="toggleAllAdSpaces(['entry_gate_branding','photo_booth_branding','standee_placements','floor_branding','seat_branding','table_branding'], 'physical')" class="text-xs text-[#F26C4F] font-semibold mb-3 block hover:underline">Select All</button>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <template x-for="opt in adSpacePhysical" :key="opt.id">
                                        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all"
                                               :class="data.ad_spaces.includes(opt.id) ? 'border-[#F26C4F] bg-rose-50/20' : 'border-gray-100 hover:border-gray-200'">
                                            <input type="checkbox" :value="opt.id" @change="toggleAdSpace(opt.id)" :checked="data.ad_spaces.includes(opt.id)" class="w-4 h-4 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                            <span class="text-xs font-medium text-gray-700" x-text="opt.label"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Digital Advertising --}}
                        <div x-data="{ openDigital: false }" class="border border-gray-100 rounded-xl overflow-hidden">
                            <button type="button" @click="openDigital = !openDigital" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition">
                                <span class="text-xs font-bold text-gray-700 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-blue-100 text-blue-500 flex items-center justify-center text-[10px]">💻</span>
                                    Digital Advertising
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openDigital ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="openDigital" class="p-4">
                                <button type="button" @click="toggleAllAdSpaces(['website_banner','mobile_app_banner','push_notification','email_blast','social_media_ad'], 'digital')" class="text-xs text-[#F26C4F] font-semibold mb-3 block hover:underline">Select All</button>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <template x-for="opt in adSpaceDigital" :key="opt.id">
                                        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all"
                                               :class="data.ad_spaces.includes(opt.id) ? 'border-[#F26C4F] bg-rose-50/20' : 'border-gray-100 hover:border-gray-200'">
                                            <input type="checkbox" :value="opt.id" @change="toggleAdSpace(opt.id)" :checked="data.ad_spaces.includes(opt.id)" class="w-4 h-4 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                            <span class="text-xs font-medium text-gray-700" x-text="opt.label"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 5: Audience --}}
            <div x-show="step === 5" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Audience Demographics</h3>
                    <p class="text-sm text-gray-500">Define your visitor demographics. This info increases enquiry matching quality.</p>
                </div>

                {{-- Help sponsors understand banner --}}
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-xs font-semibold text-gray-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Help sponsors understand your audience. This information helps sponsors assess fit and increases enquiry quality.
                </div>

                <div class="space-y-5">
                    {{-- Audience Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-1.5">
                            🧑 Audience Type
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <template x-for="t in audienceTypeList" :key="t.id">
                                <label class="border border-gray-200 rounded-xl p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50 transition"
                                       :class="data.audience_type_ids.includes(t.id) ? 'border-rose-300 bg-rose-50/20' : ''">
                                    <input type="checkbox" :value="t.id" x-model="data.audience_type_ids" class="w-4 h-4 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                    <span class="text-xs font-semibold text-gray-700" x-text="t.label"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    {{-- Age Groups --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2.5 flex items-center gap-1.5">
                            📅 Age Groups
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="g in ageGroupList" :key="g.id">
                                <button type="button" @click="toggleAgeGroup(g.id)"
                                        class="px-4 py-2 rounded-full border text-xs font-semibold transition"
                                        :class="data.age_group_ids.includes(g.id) 
                                            ? 'border-[#F26C4F] bg-[#F26C4F] text-white shadow-sm' 
                                            : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'"
                                        x-text="g.label"></button>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Gender Composition --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gender Composition</label>
                            <select x-model="data.gender_composition" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select gender composition</option>
                                <option value="mostly_male">Mostly Male</option>
                                <option value="mostly_female">Mostly Female</option>
                                <option value="balanced">Balanced</option>
                            </select>
                        </div>

                        {{-- Income level --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Income / Spending Capacity</label>
                            <select x-model="data.income_level" class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select income level</option>
                                <option value="low">Low (Students, Budget Conscious)</option>
                                <option value="mid">Mid (Working Professionals)</option>
                                <option value="high">High (Premium Buyers, Executives)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Interest Industry --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-1.5">
                            🌍 Interest / Industry Alignment
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <template x-for="i in industryList" :key="i.id">
                                <label class="border border-gray-200 rounded-xl p-3 flex items-center gap-2 cursor-pointer hover:bg-gray-50 transition"
                                       :class="data.industry_ids.includes(i.id) ? 'border-rose-300 bg-rose-50/20' : ''">
                                    <input type="checkbox" :value="i.id" x-model="data.industry_ids" class="w-4 h-4 rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                    <span class="text-xs font-semibold text-gray-700" x-text="i.label"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    {{-- Geographic Reach --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2.5">Geographic Reach</label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="opt in [
                                { value: 'local', label: 'Local (City)' },
                                { value: 'regional', label: 'Regional (State)' },
                                { value: 'national', label: 'National' },
                                { value: 'international', label: 'International' }
                            ]" :key="opt.value">
                                <button type="button" @click="data.geographic_reach = opt.value"
                                        class="px-4 py-2 rounded-full border text-xs font-semibold transition"
                                        :class="data.geographic_reach === opt.value
                                            ? 'border-[#F26C4F] bg-[#F26C4F] text-white shadow-sm'
                                            : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'"
                                        x-text="opt.label"></button>
                            </template>
                        </div>
                    </div>

                    {{-- Target Market Summary --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Target Market Summary</label>
                        <p class="text-xs text-gray-400 mb-2">Brief description for sponsors (optional)</p>
                        <textarea x-model="data.target_market_summary" rows="3" placeholder="e.g. Young urban professionals aged 22-35, tech-savvy, high disposable income, interested in live music and cultural experiences..." class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm"></textarea>
                    </div>
                </div>
            </div>

            {{-- STEP 6: Media --}}
            <div x-show="step === 6" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Event Media</h3>
                    <p class="text-sm text-gray-500">Upload your event logo, cover image, and gallery photos.</p>
                </div>

                <div class="space-y-6">
                    {{-- Cover Image --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cover Image</label>
                        <p class="text-xs text-gray-400 mb-3">This appears as the hero banner on your event page. Recommended: 1200x600px.</p>
                        <div class="flex items-center gap-4">
                            <template x-if="data.cover_image_url">
                                <div class="relative">
                                    <img :src="data.cover_image_url" class="w-40 h-24 rounded-lg object-cover border border-gray-200">
                                    <button type="button" @click="data.cover_image = ''; data.cover_image_url = ''" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                            <label class="cursor-pointer">
                                <span class="text-xs font-semibold text-[#F26C4F] hover:underline" x-text="data.cover_image_url ? 'Change Cover' : 'Upload Cover Image'"></span>
                                <input type="file" accept="image/*" class="hidden" @change="uploadCoverImage($event.target.files[0])">
                            </label>
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Event Logo</label>
                        <p class="text-xs text-gray-400 mb-3">Square logo for event branding. Recommended: 500x500px.</p>
                        <div class="flex items-center gap-4">
                            <template x-if="data.logo_url">
                                <div class="relative">
                                    <img :src="data.logo_url" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                                    <button type="button" @click="data.logo = ''; data.logo_url = ''" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="!data.logo_url">
                                <div class="w-20 h-20 rounded-lg bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </template>
                            <label class="cursor-pointer">
                                <span class="text-xs font-semibold text-[#F26C4F] hover:underline" x-text="data.logo_url ? 'Change Logo' : 'Upload Logo'"></span>
                                <input type="file" accept="image/*" class="hidden" @change="uploadLogo($event.target.files[0])">
                            </label>
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gallery Images (Max 10)</label>
                        <p class="text-xs text-gray-400 mb-3">Additional photos to showcase your event.</p>

                        <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-250 rounded-xl p-8 bg-gray-50/50 hover:bg-gray-50 transition relative cursor-pointer group"
                             @click="$refs.imagePicker.click()"
                             @dragover.prevent=""
                             @drop.prevent="handleFilesDrop($event)">
                            <input type="file" multiple accept="image/*" class="hidden" x-ref="imagePicker" @change="handleFilesUpload($event.target.files)">
                            
                            <span class="w-12 h-12 rounded-full bg-white text-gray-400 flex items-center justify-center shadow-sm group-hover:scale-105 transition-all">
                                <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </span>
                            <span class="text-sm font-bold text-gray-700 mt-3">Add Images</span>
                        </div>

                        <template x-if="data.image_paths.length > 0">
                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mt-6">
                                <template x-for="(img, index) in data.image_paths" :key="index">
                                    <div class="relative aspect-video sm:aspect-square bg-gray-100 rounded-xl overflow-hidden shadow-sm border border-gray-200 group">
                                        <img :src="getImageUrl(img)" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                            <button type="button" @click="removeImage(index)" class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 transition">
                                                <svg class="w-4 h-4 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    {{-- YouTube Video URL --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">YouTube Video URL (Optional)</label>
                        <div class="relative rounded-lg shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="text" x-model="data.youtube_url" 
                                   class="w-full rounded-lg border-gray-200 focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] pl-9 pr-4 py-2.5 text-sm" 
                                   placeholder="https://youtube.com/watch?v=...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 7: Plan --}}
            <div x-show="step === 7" class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Select Plan</h3>
                    <p class="text-sm text-gray-500">Pick a package tier to complete event submission.</p>
                </div>

                {{-- Plan Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <template x-for="p in planList" :key="p.id">
                        <div class="border rounded-2xl p-6 bg-white flex flex-col justify-between relative transition duration-300 hover:shadow-md"
                             :class="data.plan === p.slug ? 'border-[#F26C4F] bg-rose-50/5 ring-2 ring-[#F26C4F]' : 'border-gray-200'">
                            
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <h4 class="font-bold text-lg text-gray-900" x-text="p.name"></h4>
                                    <div class="flex items-baseline gap-1 mt-2">
                                        <span class="text-3xl font-extrabold text-gray-900" x-text="'₹' + Number(p.price).toLocaleString('en-IN')"></span>
                                        <span class="text-xs text-gray-500 font-semibold">/ per event</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400 block font-semibold mt-1">Payment processed after review</span>
                                </div>

                                {{-- Details list --}}
                                <ul class="space-y-2.5 border-t border-gray-100 pt-4 text-xs font-semibold text-gray-600">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="'Images: ' + (p.slug === 'basic' ? '3' : '5')"></span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="'Analytics: ' + (p.slug === 'basic' ? 'Basic' : 'Advanced')"></span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Enquiries: Unlimited
                                    </li>
                                    <li class="flex items-center gap-2" :class="p.slug === 'basic' ? 'text-gray-300' : ''">
                                        <svg class="w-4 h-4 shrink-0 stroke-[3]" :class="p.slug === 'basic' ? 'text-gray-300' : 'text-emerald-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Featured Badge
                                    </li>
                                    <li class="flex items-center gap-2" :class="p.slug !== 'homepage' ? 'text-gray-300' : ''">
                                        <svg class="w-4 h-4 shrink-0 stroke-[3]" :class="p.slug !== 'homepage' ? 'text-gray-300' : 'text-emerald-600'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Homepage Featured
                                    </li>
                                </ul>
                            </div>

                            <button type="button" @click="data.plan = p.slug" 
                                    class="w-full mt-6 py-2 px-4 rounded-xl border text-xs font-bold text-center transition duration-200"
                                    :class="data.plan === p.slug 
                                        ? 'bg-[#F26C4F] border-[#F26C4F] text-white hover:bg-[#E35336]' 
                                        : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'">
                                Select Plan
                            </button>
                        </div>
                    </template>
                </div>

                {{-- What happens after submission box --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 space-y-3">
                    <h5 class="text-sm font-bold text-gray-900 flex items-center gap-1.5">
                        💬 What happens after submission?
                    </h5>
                    <ul class="list-disc list-inside text-xs font-medium text-gray-600 space-y-1.5 pl-1.5">
                        <li>Our team will review your event within 24-48 hours</li>
                        <li>We'll contact you to discuss payment or complimentary listing options</li>
                        <li>Once approved, your event will go live on the platform</li>
                    </ul>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center justify-between border-t border-gray-150 pt-5 mt-6">
                <button type="button" @click="prevStep()" 
                        class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition flex items-center gap-1"
                        :class="step === 1 ? 'opacity-40 cursor-not-allowed' : ''"
                        :disabled="step === 1">
                    &lsaquo; Previous
                </button>

                <button type="button" @click="step === 7 ? submitForm() : nextStep()" 
                        class="px-5 py-2.5 bg-[#F26C4F] hover:bg-[#E35336] text-white rounded-xl text-sm font-bold shadow-sm transition flex items-center gap-1"
                        :disabled="submitting">
                    <span x-text="step === 7 ? (submitting ? 'Submitting...' : 'Submit Event') : 'Next &rsaquo;'"></span>
                </button>
            </div>

        </div>

    </div>

    {{-- Script context --}}
    <script>
        function eventCreateWizard(initialData, initialStep) {
            return {
                step: initialStep || 1,
                maxStep: initialStep || 1,
                saving: false,
                submitting: false,
                cityQuery: '',
                manualCityMode: false,
                data: {
                    title: '',
                    description: '',
                    category_id: '',
                    subcategory_id: '',
                    start_date: '',
                    start_time: '',
                    end_date: '',
                    end_time: '',
                    venue_name: '',
                    venue_address: '',
                    city: '',
                    state: '',
                    country: 'India',
                    contact_no: '',
                    website_url: '',
                    city: '',
                    expected_audience_size: '',
                    sponsorship_budget_range: '',
                    sponsorship_type: 'cash',
                    sponsorship_levels: [],
                    sponsorship_details: [],
                    sponsorship_benefits: [],
                    stalls: [],
                    fnb_options: [],
                    ad_spaces: [],
                    audience_type_ids: [],
                    age_group_ids: [],
                    gender_composition: '',
                    income_level: '',
                    geographic_reach: '',
                    target_market_summary: '',
                    industry_ids: [],
                    participants: [],
                    schedule: [],
                    image_paths: [],
                    youtube_url: '',
                    cover_image: '',
                    cover_image_url: '',
                    logo: '',
                    logo_url: '',
                    plan: 'basic',
                    ...initialData
                },
                errors: {},
                steps: [
                    'Basic Info',
                    'Location',
                    'Sponsorship',
                    'Add-Ons',
                    'Audience',
                    'Media',
                    'Plan'
                ],

                // Lookup arrays hydrated from server data attributes
                planList: [],
                audienceTypeList: [],
                ageGroupList: [],
                industryList: [],
                parentCategories: [],

                // Static lists
                budgetPills: ['Under ₹1 Lakh', '₹1-5 Lakhs', '₹5-10 Lakhs', '₹10-25 Lakhs', '₹25-50 Lakhs', '₹50 Lakhs+'],

                // Pre-defined sponsorship levels
                sponsorshipLevelDefs: [
                    { id: 'title', name: 'Title Sponsor', description: 'Primary sponsor with maximum visibility', checked: true, slots: 1, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>' },
                    { id: 'co_sponsor', name: 'Co-Sponsor', description: 'Secondary sponsor with significant branding', checked: true, slots: 2, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' },
                    { id: 'associate', name: 'Associate Sponsor', description: 'Supporting sponsor with moderate visibility', checked: true, slots: 4, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>' },
                    { id: 'powered_by', name: 'Powered By', description: 'Technical/infrastructure sponsor', checked: false, slots: 1, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' },
                    { id: 'media_partner', name: 'Media Partner', description: 'Media coverage partner', checked: false, slots: 1, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>' },
                    { id: 'other', name: 'Other', description: 'Custom sponsorship level', checked: false, slots: 1, budget: '', customName: '', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>' },
                ],

                // Categorized benefits
                benefitCategories: [
                    {
                        id: 'branding', name: 'Branding & Visibility', open: true,
                        icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>',
                        benefits: [
                            { id: 'logo_creatives', label: 'Logo on event creatives' },
                            { id: 'logo_website', label: 'Logo on website' },
                            { id: 'logo_banners', label: 'Logo on banners & standees' },
                            { id: 'logo_stage', label: 'Logo on stage backdrop' },
                            { id: 'logo_entry', label: 'Logo on entry gate' },
                            { id: 'logo_led', label: 'Logo on LED screens' },
                            { id: 'logo_merch', label: 'Logo on merchandise' },
                        ]
                    },
                    {
                        id: 'stage', name: 'Stage & Announcement', open: false,
                        icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>',
                        benefits: [
                            { id: 'speaking_slot', label: 'Speaking slot' },
                            { id: 'stage_branding', label: 'Stage branding' },
                            { id: 'anchor_mention', label: 'Anchor mentions' },
                            { id: 'award_sponsor', label: 'Award sponsor' },
                        ]
                    },
                    {
                        id: 'digital', name: 'Digital & Online', open: false,
                        icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
                        benefits: [
                            { id: 'social_media', label: 'Social media mentions' },
                            { id: 'email_blast', label: 'Email blast inclusion' },
                            { id: 'website_banner', label: 'Website banner' },
                            { id: 'app_branding', label: 'App branding' },
                        ]
                    },
                    {
                        id: 'engagement', name: 'Audience Engagement', open: false,
                        icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                        benefits: [
                            { id: 'vip_tickets', label: 'VIP tickets/passes' },
                            { id: 'booth_space', label: 'Booth/stall space' },
                            { id: 'product_demo', label: 'Product demo opportunity' },
                            { id: 'sampling', label: 'Product sampling' },
                        ]
                    },
                ],

                // Ad space option lists
                adSpacePhysical: [
                    { id: 'entry_gate_branding', label: 'Entry gate branding' },
                    { id: 'photo_booth_branding', label: 'Photo booth branding' },
                    { id: 'standee_placements', label: 'Standee placements' },
                    { id: 'floor_branding', label: 'Floor branding' },
                    { id: 'seat_branding', label: 'Seat branding' },
                    { id: 'table_branding', label: 'Table branding' },
                ],
                adSpaceDigital: [
                    { id: 'website_banner', label: 'Website banner' },
                    { id: 'mobile_app_banner', label: 'Mobile app banner' },
                    { id: 'push_notification', label: 'Push notification' },
                    { id: 'email_blast', label: 'Email blast' },
                    { id: 'social_media_ad', label: 'Social media ad' },
                ],

                // Static list of Indian cities for local typeahead
                cityList: [
                    'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Ahmedabad', 'Chennai', 
                    'Kolkata', 'Surat', 'Pune', 'Jaipur', 'Lucknow', 'Kanpur', 'Nagpur', 
                    'Indore', 'Thane', 'Bhopal', 'Visakhapatnam', 'Pimpri-Chinchwad', 
                    'Patna', 'Vadodara', 'Ghaziabad', 'Ludhiana', 'Agra', 'Nashik', 
                    'Faridabad', 'Meerut', 'Rajkot', 'Kalyan-Dombivli', 'Vasai-Virar', 
                    'Varanasi', 'Srinagar', 'Aurangabad', 'Dhanbad', 'Amritsar', 
                    'Navi Mumbai', 'Allahabad', 'Ranchi', 'Howrah', 'Coimbatore', 
                    'Jabalpur', 'Gwalior', 'Vijayawada', 'Jodhpur', 'Madurai', 
                    'Raipur', 'Kota', 'Guwahati', 'Chandigarh', 'Solapur', 
                    'Hubli-Dharwad', 'Bareilly', 'Moradabad', 'Mysore', 'Gurgaon', 
                    'Aligarh', 'Jalandhar', 'Tiruchirappalli', 'Bhubaneswar', 
                    'Salem', 'Mira-Bhayandar', 'Warangal', 'Trivandrum'
                ],

                init() {
                    // Populate from data properties
                    const el = document.querySelector('[x-data^="eventCreateWizard"]');
                    this.planList = JSON.parse(el.getAttribute('data-plans') || '[]');
                    this.audienceTypeList = JSON.parse(el.getAttribute('data-audience-types') || '[]');
                    this.ageGroupList = JSON.parse(el.getAttribute('data-age-groups') || '[]');
                    this.industryList = JSON.parse(el.getAttribute('data-industries') || '[]');
                    this.parentCategories = JSON.parse(el.getAttribute('data-categories') || '[]');

                    // Set city typeahead input value if loading a draft
                    if (this.data.city) {
                        this.cityQuery = this.data.city;
                        if (!this.cityList.includes(this.data.city)) {
                            this.manualCityMode = true;
                        }
                    }

                    // Restore sponsorship level defs from draft
                    if (this.data._sponsorshipLevelDefs) {
                        this.sponsorshipLevelDefs = this.data._sponsorshipLevelDefs;
                        delete this.data._sponsorshipLevelDefs;
                    }

                    // Watch category_id changes to reset subcategory
                    this.$watch('data.category_id', () => {
                        this.data.subcategory_id = '';
                    });

                    // Deep watch data changes and trigger auto-save
                    this.$watch('data', () => {
                        this.debouncedSave();
                    });
                },

                // Filter static city array based on query input
                filteredCities() {
                    if (!this.cityQuery) return [];
                    return this.cityList.filter(c => c.toLowerCase().includes(this.cityQuery.toLowerCase()));
                },

                // Compute event dates range for participant date assignment
                get isMultiDayEvent() {
                    if (!this.data.start_date) return false;
                    const end = this.data.end_date || this.data.start_date;
                    return this.data.start_date !== end;
                },

                get eventDates() {
                    if (!this.data.start_date) return [];
                    const start = new Date(this.data.start_date);
                    const end = this.data.end_date ? new Date(this.data.end_date) : new Date(this.data.start_date);
                    const dates = [];
                    const current = new Date(start);
                    while (current <= end) {
                        const yyyy = current.getFullYear();
                        const mm = String(current.getMonth() + 1).padStart(2, '0');
                        const dd = String(current.getDate()).padStart(2, '0');
                        dates.push({
                            value: `${yyyy}-${mm}-${dd}`,
                            label: current.toLocaleDateString('en-IN', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' })
                        });
                        current.setDate(current.getDate() + 1);
                    }
                    return dates;
                },

                // Auto-save logic
                saveTimeout: null,
                debouncedSave() {
                    clearTimeout(this.saveTimeout);
                    this.saveTimeout = setTimeout(() => {
                        this.saveDraft();
                    }, 1000);
                },

                async saveDraft() {
                    this.saving = true;
                    try {
                        const draftData = {
                            ...this.data,
                            current_step: this.step,
                            _sponsorshipLevelDefs: this.sponsorshipLevelDefs,
                        };
                        const response = await fetch('{{ route("organizer.events.submit-draft") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(draftData)
                        });
                        const res = await response.json();
                        if (res.success) {
                            // draft saved successfully
                        }
                    } catch (e) {
                        console.error('Draft auto-save failed', e);
                    } finally {
                        this.saving = false;
                    }
                },

                async clearDraft() {
                    if (!confirm('Are you sure you want to discard this draft? This will clear all entered form values.')) {
                        return;
                    }
                    try {
                        await fetch('{{ route("organizer.events.clear-submit-draft") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        window.location.reload();
                    } catch (e) {
                        console.error('Failed to clear draft', e);
                    }
                },

                // Navigation controls
                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                    }
                },

                nextStep() {
                    if (this.validateStep()) {
                        this.step++;
                        if (this.step > this.maxStep) {
                            this.maxStep = this.step;
                        }
                        this.saveDraft();
                    }
                },

                goToStep(targetStep) {
                    if (targetStep <= this.maxStep) {
                        this.step = targetStep;
                    }
                },

                // Simple client side validation per step
                validateStep() {
                    this.errors = {};
                    if (this.step === 1) {
                        if (!this.data.title) this.errors.title = 'Event title is required.';
                        if (!this.data.description) this.errors.description = 'Event description is required.';
                        if (!this.data.category_id) this.errors.category_id = 'Please select a category.';
                        if (!this.data.start_date) this.errors.start_date = 'Start date is required.';
                    } else if (this.step === 2) {
                        if (!this.data.venue_name) this.errors.venue_name = 'Venue name is required.';
                        if (!this.data.city) this.errors.city = 'Please select or enter a city.';
                    } else if (this.step === 3) {
                        if (!this.data.sponsorship_type) this.errors.sponsorship_type = 'Sponsorship type is required.';
                    }
                    return Object.keys(this.errors).length === 0;
                },

                // Sponsorship Benefits toggle
                toggleBenefit(id) {
                    const idx = this.data.sponsorship_benefits.indexOf(id);
                    if (idx > -1) {
                        this.data.sponsorship_benefits.splice(idx, 1);
                    } else {
                        this.data.sponsorship_benefits.push(id);
                    }
                },
                toggleCategoryBenefits(cat) {
                    const allChecked = cat.benefits.every(b => this.data.sponsorship_benefits.includes(b.id));
                    cat.benefits.forEach(b => {
                        const idx = this.data.sponsorship_benefits.indexOf(b.id);
                        if (allChecked) {
                            if (idx > -1) this.data.sponsorship_benefits.splice(idx, 1);
                        } else {
                            if (idx === -1) this.data.sponsorship_benefits.push(b.id);
                        }
                    });
                },

                // Stalls Repeater
                addStall() {
                    this.data.stalls.push({ stall_type: '', stall_size: '', location: '', number_available: 1, power_supply: false, furniture_included: false, pricing_type: 'cash', price: '' });
                },
                removeStall(idx) {
                    this.data.stalls.splice(idx, 1);
                },

                // F&B Repeater
                addFnb() {
                    this.data.fnb_options.push({ partner_type: '', slots: 1, pricing_type: 'cash', price: '' });
                },
                removeFnb(idx) {
                    this.data.fnb_options.splice(idx, 1);
                },

                // Ad Space Toggle (now string-based)
                toggleAdSpace(id) {
                    const idx = this.data.ad_spaces.indexOf(id);
                    if (idx > -1) {
                        this.data.ad_spaces.splice(idx, 1);
                    } else {
                        this.data.ad_spaces.push(id);
                    }
                },
                toggleAllAdSpaces(ids) {
                    const allSelected = ids.every(id => this.data.ad_spaces.includes(id));
                    if (allSelected) {
                        ids.forEach(id => {
                            const idx = this.data.ad_spaces.indexOf(id);
                            if (idx > -1) this.data.ad_spaces.splice(idx, 1);
                        });
                    } else {
                        ids.forEach(id => {
                            if (!this.data.ad_spaces.includes(id)) this.data.ad_spaces.push(id);
                        });
                    }
                },

                // Age group multi-toggle helper
                toggleAgeGroup(id) {
                    const idx = this.data.age_group_ids.indexOf(id);
                    if (idx > -1) {
                        this.data.age_group_ids.splice(idx, 1);
                    } else {
                        this.data.age_group_ids.push(id);
                    }
                },

                // Participants (Artists / Speakers / Celebrities)
                addParticipant() {
                    this.data.participants.push({ name: '', type: '', organization: '', designation: '', bio: '', photo_path: '', photo_url: '' });
                },
                removeParticipant(idx) {
                    this.data.participants.splice(idx, 1);
                },
                // Schedule Assignments (date → artist → time)
                addSchedule() {
                    const defaultDate = this.eventDates[0]?.value || this.data.start_date || '';
                    this.data.schedule.push({ date: defaultDate, participant_idx: '', start_time: '', end_time: '' });
                },
                removeSchedule(idx) {
                    this.data.schedule.splice(idx, 1);
                },
                async uploadCoverImage(file) {
                    if (!file) return;
                    const fd = new FormData();
                    fd.append('image', file);
                    try {
                        const response = await fetch('{{ route("organizer.events.upload-image") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: fd
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.data.cover_image = result.path;
                            this.data.cover_image_url = result.url;
                        } else {
                            alert(result.message || 'Cover image upload failed.');
                        }
                    } catch (e) {
                        console.error('Cover image upload failed', e);
                    }
                },
                async uploadLogo(file) {
                    if (!file) return;
                    const fd = new FormData();
                    fd.append('image', file);
                    try {
                        const response = await fetch('{{ route("organizer.events.upload-image") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: fd
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.data.logo = result.path;
                            this.data.logo_url = result.url;
                        } else {
                            alert(result.message || 'Logo upload failed.');
                        }
                    } catch (e) {
                        console.error('Logo upload failed', e);
                    }
                },
                async uploadParticipantPhoto(idx, file) {
                    if (!file) return;
                    const fd = new FormData();
                    fd.append('image', file);
                    try {
                        const response = await fetch('{{ route("organizer.events.upload-image") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: fd
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.data.participants[idx].photo_path = result.path;
                            this.data.participants[idx].photo_url = result.url;
                        } else {
                            alert(result.message || 'Photo upload failed.');
                        }
                    } catch (e) {
                        console.error('Participant photo upload failed', e);
                    }
                },

                // Image upload handlers
                async handleFilesUpload(files) {
                    for (let i = 0; i < files.length; i++) {
                        if (this.data.image_paths.length >= 10) {
                            alert('Maximum limit of 10 images reached.');
                            break;
                        }
                        const file = files[i];
                        const fd = new FormData();
                        fd.append('image', file);

                        try {
                            const response = await fetch('{{ route("organizer.events.upload-image") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: fd
                            });
                            const result = await response.json();
                            if (result.success) {
                                this.data.image_paths.push(result.path);
                            } else {
                                alert(result.message || 'Image upload failed.');
                            }
                        } catch (e) {
                            console.error('Image upload failed', e);
                            alert('An error occurred during file upload.');
                        }
                    }
                },

                handleFilesDrop(event) {
                    const files = event.dataTransfer.files;
                    this.handleFilesUpload(files);
                },

                getImageUrl(path) {
                    if (path.startsWith('http')) return path;
                    return `/storage/${path}`;
                },

                removeImage(index) {
                    this.data.image_paths.splice(index, 1);
                },

                // Final submit action
                async submitForm() {
                    if (!this.data.plan) {
                        alert('Please choose a plan to complete the listing.');
                        return;
                    }
                    this.submitting = true;
                    try {
                        // Transform sponsorship level defs into the format the controller expects
                        const payload = { ...this.data };
                        const checkedLevels = this.sponsorshipLevelDefs.filter(l => l.checked && l.id !== 'other');
                        payload.sponsorship_levels = checkedLevels.map(l => l.id);
                        payload.sponsorship_details = checkedLevels.map(l => ({
                            name: l.name,
                            slots: l.slots,
                            budget_per_slot: l.budget,
                        }));
                        const otherLevel = this.sponsorshipLevelDefs.find(l => l.id === 'other' && l.checked);
                        if (otherLevel && otherLevel.customName) {
                            payload.sponsorship_levels.push('other');
                            payload.sponsorship_details.push({ name: otherLevel.customName, slots: 1, budget_per_slot: '' });
                        }
                        delete payload.sponsorshipLevelDefs;

                        const response = await fetch('{{ route("organizer.events.submit-final") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });
                        const res = await response.json();
                        if (res.success && res.redirect) {
                            window.location.href = res.redirect;
                        } else {
                            alert(res.message || 'An error occurred during submission.');
                        }
                    } catch (e) {
                        console.error('Submit form failed', e);
                        alert('An unexpected network error occurred.');
                    } finally {
                        this.submitting = false;
                    }
                }
            };
        }
    </script>
</x-app-layout>
