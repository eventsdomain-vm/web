<x-app-layout>
    <x-slot name="title">Submit Event - EventsDomain</x-slot>

    @php
        $ageGroups = ['All Ages', '18-24', '25-34', '35-44', '45-54', '55+'];
        $genders = ['All', 'Male', 'Female', 'Non-Binary', 'Any'];
        $incomeLevels = ['All', 'Lower-Middle', 'Middle', 'Upper-Middle', 'High'];
        $industries = ['Technology', 'Finance', 'Healthcare', 'Education', 'Entertainment', 'Sports', 'Fashion', 'Food & Beverage', 'Real Estate', 'Automotive', 'Government', 'Non-Profit'];
        $reaches = ['Local', 'Regional', 'National', 'International'];
        $timezones = ['Asia/Kolkata', 'America/New_York', 'America/Los_Angeles', 'Europe/London', 'Europe/Berlin', 'Asia/Dubai', 'Asia/Singapore', 'Australia/Sydney'];
    @endphp

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-gradient-to-r from-orange-500 to-rose-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Event Submission Form</h2>
                <p class="text-sm text-gray-500">Fill in all details to submit your event for sponsorship opportunities</p>
            </div>
        </div>

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data"
          x-data="wizard()"
          x-init="init()"
          @submit.prevent="submit"
          class="space-y-6">

        @csrf
        <input type="hidden" name="event_id" x-model="eventId">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Submit Event</h1>
                <p class="text-gray-500 text-sm mt-1">Fill in all details to submit your event for sponsorship opportunities.</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <template x-if="saving">
                    <span class="flex items-center gap-1.5 text-amber-600 font-medium">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Saving...
                    </span>
                </template>
                <template x-if="draftSaved && !saving">
                    <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Draft saved
                    </span>
                </template>
                <button type="button" @click="clearDraft" class="text-gray-400 hover:text-red-500 transition text-xs">Clear Draft</button>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
            <div class="flex flex-wrap justify-center gap-2">
                <template x-for="(s, i) in steps" :key="i">
                    <button type="button" @click="goTo(i)" class="flex items-center gap-2 py-2 px-3 rounded-lg transition text-sm"
                            :class="i === currentStep ? 'bg-orange-50 border border-[#F26C4F] text-[#F26C4F] font-medium' : (i < completedSteps ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-gray-50 border border-gray-200 text-gray-500 hover:bg-gray-100')">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                              :class="i < completedSteps ? 'bg-green-500 text-white' : (i === currentStep ? 'bg-[#F26C4F] text-white' : 'bg-gray-300 text-gray-600')">
                            <template x-if="i < completedSteps">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="i >= completedSteps">
                                <span x-text="i + 1"></span>
                            </template>
                        </span>
                        <span class="hidden sm:inline" x-text="s"></span>
                    </button>
                </template>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-3">
                <div class="bg-[#F26C4F] h-2 rounded-full transition-all duration-500" :style="'width: ' + ((currentStep + 1) / steps.length * 100) + '%'"></div>
            </div>
        </div>

        {{-- Step 1: Basic Info --}}
        <div x-show="currentStep === 0" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Basic Information</h2>
            <p class="text-sm text-gray-500 -mt-4">Tell us about your event — what makes it unique?</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Title <span class="text-red-500">*</span></label>
                    <input type="text" x-model="form.title" @input.debounce.1000ms="autosave" name="title" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., TechSummit India 2026">
                    <template x-if="errors.title"><p class="text-red-500 text-xs mt-1" x-text="errors.title"></p></template>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tagline</label>
                    <input type="text" x-model="form.tagline" @input.debounce.1000ms="autosave" name="tagline" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="One-line hook for your event">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                    <textarea x-model="form.description" @input.debounce.1000ms="autosave" name="description" rows="5" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Describe your event — theme, activities, speakers, what makes it unique..."></textarea>
                    <template x-if="errors.description"><p class="text-red-500 text-xs mt-1" x-text="errors.description"></p></template>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                    <select x-model="form.category_id" @change="autosave" name="category_id" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <optgroup label="{{ $cat->name }}">
                                @foreach($cat->children as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <template x-if="errors.category_id"><p class="text-red-500 text-xs mt-1" x-text="errors.category_id"></p></template>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Type <span class="text-red-500">*</span></label>
                    <select x-model="form.event_type" @change="autosave" name="event_type" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        <option value="">Select Type</option>
                        <option value="physical">In-Person</option>
                        <option value="virtual">Virtual</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                    <template x-if="errors.event_type"><p class="text-red-500 text-xs mt-1" x-text="errors.event_type"></p></template>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                    <input type="date" x-model="form.start_date" @change="autosave" name="start_date" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                    <template x-if="errors.start_date"><p class="text-red-500 text-xs mt-1" x-text="errors.start_date"></p></template>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">End Date <span class="text-red-500">*</span></label>
                    <input type="date" x-model="form.end_date" @change="autosave" name="end_date" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                    <template x-if="errors.end_date"><p class="text-red-500 text-xs mt-1" x-text="errors.end_date"></p></template>
                </div>
            </div>
        </div>

        {{-- Step 2: Dates & Schedule --}}
        <div x-show="currentStep === 1" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Dates & Schedule</h2>
                    <p class="text-sm text-gray-500 mt-1">Add one or more date sessions for your event.</p>
                </div>
                <button type="button" @click="addDate()" class="text-sm text-[#F26C4F] hover:text-[#E35336] font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Date
                </button>
            </div>
            <template x-for="(dt, idx) in form.dates" :key="idx">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 relative">
                    <button type="button" @click="form.dates.splice(idx, 1)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition" title="Remove date">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Label</label>
                            <input type="text" x-model="dt.label" :name="'dates[' + idx + '][label]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Day 1, Workshop">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                            <input type="date" x-model="dt.start_date" :name="'dates[' + idx + '][start_date]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">End Date</label>
                            <input type="date" x-model="dt.end_date" :name="'dates[' + idx + '][end_date]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Time</label>
                            <input type="time" x-model="dt.start_time" :name="'dates[' + idx + '][start_time]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">End Time</label>
                            <input type="time" x-model="dt.end_time" :name="'dates[' + idx + '][end_time]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Timezone</label>
                            <select x-model="dt.timezone" :name="'dates[' + idx + '][timezone]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                @foreach($timezones as $tz)
                                    <option value="{{ $tz }}">{{ $tz }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="dt.all_day" :name="'dates[' + idx + '][all_day]'" true-value="1" false-value="0" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                <span class="text-sm text-gray-600">All Day Event</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="form.dates.length === 0">
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm">No dates added yet</p>
                    <p class="text-xs text-gray-400 mt-1">Click "Add Date" to create a session</p>
                </div>
            </template>
        </div>

        {{-- Step 3: Venues --}}
        <div x-show="currentStep === 2" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Venues</h2>
                    <p class="text-sm text-gray-500 mt-1">Add physical or virtual venues for your event.</p>
                </div>
                <button type="button" @click="addVenue()" class="text-sm text-[#F26C4F] hover:text-[#E35336] font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Venue
                </button>
            </div>
            <template x-for="(v, idx) in form.venues" :key="idx">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 relative">
                    <button type="button" @click="form.venues.splice(idx, 1)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition" title="Remove venue">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Venue Type</label>
                            <select x-model="v.venue_type" :name="'venues[' + idx + '][venue_type]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="physical">Physical</option>
                                <option value="virtual">Virtual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Venue Name</label>
                            <input type="text" x-model="v.venue_name" :name="'venues[' + idx + '][venue_name]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Mumbai Convention Center">
                        </div>
                        <div class="md:col-span-2" x-show="v.venue_type === 'physical'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                            <input type="text" x-model="v.address" :name="'venues[' + idx + '][address]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Full venue address">
                        </div>
                        <div x-show="v.venue_type === 'physical'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                            <input type="text" x-model="v.city" :name="'venues[' + idx + '][city]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Mumbai">
                        </div>
                        <div x-show="v.venue_type === 'physical'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">State</label>
                            <input type="text" x-model="v.state" :name="'venues[' + idx + '][state]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Maharashtra">
                        </div>
                        <div x-show="v.venue_type === 'physical'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Country</label>
                            <input type="text" x-model="v.country" :name="'venues[' + idx + '][country]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" value="India">
                        </div>
                        <div x-show="v.venue_type === 'virtual'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Virtual URL</label>
                            <input type="url" x-model="v.virtual_url" :name="'venues[' + idx + '][virtual_url]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="https://zoom.us/j/...">
                        </div>
                        <div x-show="v.venue_type === 'virtual'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Platform</label>
                            <input type="text" x-model="v.virtual_platform" :name="'venues[' + idx + '][virtual_platform]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Zoom, Teams">
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="v.is_primary" :name="'venues[' + idx + '][is_primary]'" true-value="1" false-value="0" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]">
                                <span class="text-sm text-gray-600">Primary Venue</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="form.venues.length === 0">
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-sm">No venues added yet</p>
                    <p class="text-xs text-gray-400 mt-1">Click "Add Venue" to specify a location</p>
                </div>
            </template>
        </div>

        {{-- Step 4: Sponsorship --}}
        <div x-show="currentStep === 3" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Sponsorship Details</h2>
            <p class="text-sm text-gray-500 -mt-4">Define sponsorship parameters and budget.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Expected Audience <span class="text-red-500">*</span></label>
                    <input type="number" x-model="form.expected_audience" @input.debounce.1000ms="autosave" name="expected_audience" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., 5000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sponsorship Type</label>
                    <select x-model="form.sponsorship_type" @change="autosave" name="sponsorship_type" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                        <option value="">Select Type</option>
                        <option value="paid">Cash</option>
                        <option value="barter">Barter</option>
                        <option value="hybrid">Cash + Barter</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Budget Min (₹)</label>
                    <input type="number" x-model="form.budget_min" @input.debounce.1000ms="autosave" name="budget_min" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., 100000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Budget Max (₹)</label>
                    <input type="number" x-model="form.budget_max" @input.debounce.1000ms="autosave" name="budget_max" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., 500000">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Sponsor Levels</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['Title', 'Co', 'Associate', 'Powered By', 'Media Partner', 'Other'] as $level)
                        <label class="flex items-center gap-2 px-4 py-2.5 rounded-lg border cursor-pointer transition"
                               :class="(form.sponsor_levels || []).includes('{{ $level }}') ? 'border-[#F26C4F] bg-orange-50 text-[#F26C4F]' : 'border-gray-200 text-gray-600 hover:border-gray-300'">
                            <input type="checkbox" value="{{ $level }}" class="sr-only" @change="toggleLevel('{{ $level }}')">
                            <span class="text-sm font-medium">{{ $level }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma separated)</label>
                <input type="text" x-model="form.tags" @input.debounce.1000ms="autosave" name="tags" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., technology, startup, networking">
            </div>
        </div>

        {{-- Step 5: Packages --}}
        <div x-show="currentStep === 4" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Sponsorship Packages</h2>
                    <p class="text-sm text-gray-500 mt-1">Create sponsorship tiers with pricing and benefits.</p>
                </div>
                <button type="button" @click="addPackage()" class="text-sm text-[#F26C4F] hover:text-[#E35336] font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Package
                </button>
            </div>
            <div class="space-y-4" x-ref="packagesContainer">
                <template x-for="(pkg, idx) in packages" :key="idx">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 relative">
                        <button type="button" @click="removePackage(idx)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition" title="Remove package">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Package Name <span class="text-red-500">*</span></label>
                                <input type="text" x-model="pkg.name" :name="'packages[' + idx + '][name]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Title Sponsor, Gold Package">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Price (₹) <span class="text-red-500">*</span></label>
                                <input type="number" x-model.number="pkg.price" :name="'packages[' + idx + '][price]'" min="0" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., 500000">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                            <textarea x-model="pkg.description" :name="'packages[' + idx + '][description]'" rows="2" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="What does this package include?"></textarea>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Benefits (one per line)</label>
                            <textarea x-model="pkg.benefits_text" :name="'packages[' + idx + '][benefits]'" rows="3" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm font-mono text-xs" placeholder="Logo on website&#10;Booth space&#10;Speaking slot&#10;Social media mentions"></textarea>
                            <p class="text-xs text-gray-400 mt-1">Enter each benefit on a new line</p>
                        </div>
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Slots Available</label>
                                <input type="number" x-model.number="pkg.slots_available" :name="'packages[' + idx + '][slots_available]'" min="1" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="1">
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="packages.length === 0">
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="text-sm">No sponsorship packages added yet</p>
                        <p class="text-xs text-gray-400 mt-1">Click "Add Package" to create your first package</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Step 6: Audience --}}
        <div x-show="currentStep === 5" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Target Audience</h2>
            <p class="text-sm text-gray-500 -mt-4">Describe who your event is for — helps sponsors find the right fit.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Age Groups <span class="text-red-500">*</span></label>
                    <div class="space-y-2">
                        @foreach($ageGroups as $age)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" value="{{ $age }}" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]" x-model="form.audience_age_groups" @change="autosave">
                                <span class="text-sm text-gray-600">{{ $age }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <div class="space-y-2">
                        @foreach($genders as $g)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" value="{{ $g }}" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]" x-model="form.audience_gender" @change="autosave">
                                <span class="text-sm text-gray-600">{{ $g }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Income Level</label>
                    <div class="space-y-2">
                        @foreach($incomeLevels as $inc)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" value="{{ $inc }}" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]" x-model="form.audience_income" @change="autosave">
                                <span class="text-sm text-gray-600">{{ $inc }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Industry</label>
                    <div class="space-y-1 max-h-48 overflow-y-auto">
                        @foreach($industries as $ind)
                            <label class="flex items-center gap-2.5 cursor-pointer py-0.5">
                                <input type="checkbox" value="{{ $ind }}" class="rounded border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]" x-model="form.audience_industries" @change="autosave">
                                <span class="text-sm text-gray-600">{{ $ind }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Geographic Reach</label>
                    <div class="space-y-2">
                        @foreach($reaches as $r)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="radio" value="{{ $r }}" name="audience_reach" class="border-gray-300 text-[#F26C4F] focus:ring-[#F26C4F]" x-model="form.audience_reach" @change="autosave">
                                <span class="text-sm text-gray-600">{{ $r }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Market Summary</label>
                    <textarea x-model="form.audience_description" @input.debounce.1000ms="autosave" name="audience_description" rows="3" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Describe your target audience — demographics, interests, job roles..."></textarea>
                </div>
            </div>
        </div>

        {{-- Step 7: Media --}}
        <div x-show="currentStep === 6" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Media & Branding</h2>
            <p class="text-sm text-gray-500 -mt-4">Upload images and links to showcase your event.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Logo</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-[#F26C4F] transition cursor-pointer relative overflow-hidden" @click="$refs.logo.click()">
                        <template x-if="!previews.logo">
                            <div>
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-gray-400">Click to upload logo</p>
                                <p class="text-xs text-gray-300 mt-1">JPEG, PNG or WebP • Max 2MB</p>
                            </div>
                        </template>
                        <template x-if="previews.logo">
                            <img :src="previews.logo" class="w-full h-28 object-contain rounded-lg" alt="Logo preview">
                        </template>
                    </div>
                    <input type="file" x-ref="logo" name="logo" accept="image/jpeg,image/png,image/webp" class="hidden" @change="fileSelected($event, 'logo')">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cover Image</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-[#F26C4F] transition cursor-pointer relative overflow-hidden" @click="$refs.cover.click()">
                        <template x-if="!previews.cover_image">
                            <div>
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-gray-400">Click to upload cover image</p>
                                <p class="text-xs text-gray-300 mt-1">16:9 ratio recommended</p>
                            </div>
                        </template>
                        <template x-if="previews.cover_image">
                            <img :src="previews.cover_image" class="w-full h-28 object-cover rounded-lg" alt="Cover preview">
                        </template>
                    </div>
                    <input type="file" x-ref="cover" name="cover_image" accept="image/jpeg,image/png,image/webp" class="hidden" @change="fileSelected($event, 'cover_image')">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Banner Image</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-[#F26C4F] transition cursor-pointer relative overflow-hidden" @click="$refs.banner.click()">
                        <template x-if="!previews.banner_image">
                            <div>
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-gray-400">Click to upload banner image</p>
                                <p class="text-xs text-gray-300 mt-1">21:9 ratio recommended</p>
                            </div>
                        </template>
                        <template x-if="previews.banner_image">
                            <img :src="previews.banner_image" class="w-full h-28 object-cover rounded-lg" alt="Banner preview">
                        </template>
                    </div>
                    <input type="file" x-ref="banner" name="banner_image" accept="image/jpeg,image/png,image/webp" class="hidden" @change="fileSelected($event, 'banner_image')">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Promotional Video URL</label>
                <input type="url" x-model="form.video_url" @input.debounce.1000ms="autosave" name="video_url" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="https://www.youtube.com/watch?v=...">
            </div>
        </div>

        {{-- Step 8: Participants --}}
        <div x-show="currentStep === 7" x-cloak class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Speakers & Participants</h2>
                    <p class="text-sm text-gray-500 mt-1">Add speakers, panelists, or performers for your event.</p>
                </div>
                <button type="button" @click="addParticipant()" class="text-sm text-[#F26C4F] hover:text-[#E35336] font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Participant
                </button>
            </div>
            <template x-for="(p, idx) in form.participants" :key="idx">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 relative">
                    <button type="button" @click="form.participants.splice(idx, 1)" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition" title="Remove participant">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-red-500">*</span></label>
                            <input type="text" x-model="p.name" :name="'participants[' + idx + '][name]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Full name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Type</label>
                            <select x-model="p.participant_type_id" :name="'participants[' + idx + '][participant_type_id]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm">
                                <option value="">Select Type</option>
                                @foreach($participantTypes as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Role Label</label>
                            <input type="text" x-model="p.role_label" :name="'participants[' + idx + '][role_label]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Keynote Speaker">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Session Title</label>
                            <input type="text" x-model="p.session_title" :name="'participants[' + idx + '][session_title]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., Future of AI">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Organization</label>
                            <input type="text" x-model="p.organization" :name="'participants[' + idx + '][organization]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Company or affiliation">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Designation</label>
                            <input type="text" x-model="p.designation" :name="'participants[' + idx + '][designation]'" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="e.g., CEO, CTO">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                            <textarea x-model="p.bio" :name="'participants[' + idx + '][bio]'" rows="2" class="w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-[#F26C4F] focus:ring-1 focus:ring-[#F26C4F] px-4 py-2.5 text-sm" placeholder="Short biography"></textarea>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="form.participants.length === 0">
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-sm">No participants added yet</p>
                    <p class="text-xs text-gray-400 mt-1">Click "Add Participant" to add speakers or panelists</p>
                </div>
            </template>
        </div>

        {{-- Step 9: Plan & Review --}}
        <div x-show="currentStep === 8" x-cloak class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900">Choose Your Plan</h2>
                <p class="text-sm text-gray-500 mt-1">Select a visibility plan for your event listing.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                    <label class="relative border-2 rounded-xl p-5 cursor-pointer transition" :class="form.plan === 'basic' ? 'border-[#F26C4F] bg-orange-50' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" value="basic" x-model="form.plan" class="sr-only">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-bold text-gray-900">Basic</p>
                                <p class="text-sm text-gray-500">Free</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="form.plan === 'basic' ? 'border-[#F26C4F]' : 'border-gray-300'">
                                <div x-show="form.plan === 'basic'" class="w-2.5 h-2.5 rounded-full bg-[#F26C4F]"></div>
                            </div>
                        </div>
                        <ul class="space-y-1.5 text-sm text-gray-600">
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Standard listing</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 1 sponsor level</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Basic analytics</li>
                        </ul>
                    </label>
                    <label class="relative border-2 rounded-xl p-5 cursor-pointer transition" :class="form.plan === 'featured' ? 'border-[#F26C4F] bg-orange-50' : 'border-gray-200 hover:border-gray-300'">
                        <div class="absolute -top-2.5 right-3 bg-[#F26C4F] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">POPULAR</div>
                        <input type="radio" value="featured" x-model="form.plan" class="sr-only">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-bold text-gray-900">Featured</p>
                                <p class="text-sm text-gray-500">Paid</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="form.plan === 'featured' ? 'border-[#F26C4F]' : 'border-gray-300'">
                                <div x-show="form.plan === 'featured'" class="w-2.5 h-2.5 rounded-full bg-[#F26C4F]"></div>
                            </div>
                        </div>
                        <ul class="space-y-1.5 text-sm text-gray-600">
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Featured placement</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Unlimited sponsor levels</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Advanced analytics</li>
                        </ul>
                    </label>
                    <label class="relative border-2 rounded-xl p-5 cursor-pointer transition" :class="form.plan === 'homepage' ? 'border-[#F26C4F] bg-orange-50' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" value="homepage" x-model="form.plan" class="sr-only">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-bold text-gray-900">Homepage</p>
                                <p class="text-sm text-gray-500">Premium</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="form.plan === 'homepage' ? 'border-[#F26C4F]' : 'border-gray-300'">
                                <div x-show="form.plan === 'homepage'" class="w-2.5 h-2.5 rounded-full bg-[#F26C4F]"></div>
                            </div>
                        </div>
                        <ul class="space-y-1.5 text-sm text-gray-600">
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Homepage spotlight</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> All featured benefits</li>
                            <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Dedicated account manager</li>
                        </ul>
                    </label>
                </div>
                <template x-if="errors.plan"><p class="text-red-500 text-xs mt-3" x-text="errors.plan"></p></template>
            </div>

            {{-- Review Summary --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Review & Submit</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Title:</span><p class="font-medium text-gray-900" x-text="form.title || '—'"></p></div>
                    <div><span class="text-gray-500">Event Type:</span><p class="font-medium text-gray-900" x-text="form.event_type || '—'"></p></div>
                    <div><span class="text-gray-500">Start Date:</span><p class="font-medium text-gray-900" x-text="form.start_date || '—'"></p></div>
                    <div><span class="text-gray-500">End Date:</span><p class="font-medium text-gray-900" x-text="form.end_date || '—'"></p></div>
                    <div><span class="text-gray-500">Dates:</span><p class="font-medium text-gray-900" x-text="form.dates.length + ' session(s)'"></p></div>
                    <div><span class="text-gray-500">Venues:</span><p class="font-medium text-gray-900" x-text="form.venues.length + ' venue(s)'"></p></div>
                    <div><span class="text-gray-500">Expected Audience:</span><p class="font-medium text-gray-900" x-text="form.expected_audience || '—'"></p></div>
                    <div><span class="text-gray-500">Plan:</span><p class="font-medium text-gray-900 capitalize" x-text="form.plan || '—'"></p></div>
                    <div><span class="text-gray-500">Participants:</span><p class="font-medium text-gray-900" x-text="form.participants.length + ' added'"></p></div>
                    <div class="md:col-span-2">
                        <span class="text-gray-500">Sponsorship Packages:</span>
                        <template x-if="packages.length > 0">
                            <ul class="mt-1 space-y-1">
                                <template x-for="(pkg, idx) in packages" :key="idx">
                                    <li class="text-xs font-medium text-gray-900 flex items-center gap-2">
                                        <span x-text="pkg.name"></span>
                                        <span class="text-gray-500 text-sm" x-text="'₹' + pkg.price.toLocaleString()"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>
                        <template x-if="packages.length === 0">
                            <p class="text-sm text-gray-400 mt-1">No packages added</p>
                        </template>
                    </div>
                </div>
                <template x-if="Object.keys(errors).length > 0">
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm font-medium text-red-700 mb-1">Please fix the following before submitting:</p>
                        <ul class="list-disc list-inside text-xs text-red-600 space-y-0.5">
                            <template x-for="(msg, field) in errors" :key="field">
                                <li x-text="msg"></li>
                            </template>
                        </ul>
                    </div>
                </template>
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex items-center justify-between mt-6 bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div>
                <button type="button" @click="prevStep" x-show="currentStep > 0" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    &larr; Previous
                </button>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="nextStep" x-show="currentStep < steps.length - 1" class="px-5 py-2.5 text-sm font-medium text-white bg-[#F26C4F] rounded-lg hover:bg-orange-600 transition">
                    Next &rarr;
                </button>
                <button type="submit" x-show="currentStep === steps.length - 1" class="px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                    <span x-show="!submitting">Submit Event</span>
                    <span x-show="submitting" class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Submitting...
                    </span>
                </button>
            </div>
        </div>
    </form>


</x-app-layout>
