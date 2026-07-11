<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
            <a href="{{ route('organizer.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Back to Event</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto space-y-6">
            @csrf
            @method('PUT')

            {{-- Step 1: Basic Information --}}
            <div class="card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-terracotta-100 rounded-lg flex items-center justify-center">
                        <span class="text-terracotta-600 font-bold text-sm">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Basic Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 input-group">
                        <label class="label">Event Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="input-field input-lg" required>
                        @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2 input-group">
                        <label class="label">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $event->tagline) }}" class="input-field input-lg" placeholder="A brief catchy phrase for your event">
                    </div>

                    <div class="md:col-span-2 input-group">
                        <label class="label">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" class="input-field" rows="6" required>{{ old('description', $event->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="input-group">
                        <label class="label">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" class="input-field input-lg" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->children as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ old('category_id', $event->category_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="input-group">
                        <label class="label">Event Type <span class="text-red-500">*</span></label>
                        <select name="event_type" class="input-field input-lg" required>
                            <option value="physical" {{ old('event_type', $event->event_type) === 'physical' ? 'selected' : '' }}>In-Person</option>
                            <option value="virtual" {{ old('event_type', $event->event_type) === 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="hybrid" {{ old('event_type', $event->event_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label class="label">Sponsorship Type</label>
                        <select name="sponsorship_type" class="input-field input-lg">
                            <option value="">Select Sponsorship Type</option>
                            <option value="paid" {{ old('sponsorship_type', $event->sponsorship_type) === 'paid' ? 'selected' : '' }}>Paid Sponsorship</option>
                            <option value="barter" {{ old('sponsorship_type', $event->sponsorship_type) === 'barter' ? 'selected' : '' }}>Barter / In-Kind</option>
                            <option value="hybrid" {{ old('sponsorship_type', $event->sponsorship_type) === 'hybrid' ? 'selected' : '' }}>Paid + Barter (Hybrid)</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label class="label">Tags (comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', is_array($event->tags) ? implode(', ', $event->tags) : '') }}" class="input-field input-lg" placeholder="e.g., technology, startup, networking">
                        <p class="input-hint">Max 5 tags. Separate with commas.</p>
                    </div>
                </div>
            </div>

            {{-- Step 2: Date & Location --}}
            <div class="card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center">
                        <span class="text-sky-600 font-bold text-sm">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Date & Location</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="input-group">
                        <label class="label">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" class="input-field input-lg" required>
                    </div>
                    <div class="input-group">
                        <label class="label">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" class="input-field input-lg" required>
                    </div>
                    <div class="input-group">
                        <label class="label">Registration Deadline</label>
                        <input type="date" name="registration_deadline" value="{{ old('registration_deadline', $event->registration_deadline?->format('Y-m-d')) }}" class="input-field input-lg">
                    </div>
                    <div class="input-group">
                        <label class="label">Venue</label>
                        <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" class="input-field input-lg" placeholder="e.g., Mumbai Convention Center">
                    </div>
                    <div class="md:col-span-2 input-group">
                        <label class="label">Address</label>
                        <input type="text" name="address" value="{{ old('address', $event->address) }}" class="input-field input-lg" placeholder="Full venue address">
                    </div>
                    <div class="input-group">
                        <label class="label">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city', $event->city) }}" class="input-field input-lg" required>
                    </div>
                    <div class="input-group">
                        <label class="label">State</label>
                        <input type="text" name="state" value="{{ old('state', $event->state) }}" class="input-field input-lg" placeholder="e.g. Gujarat, Maharashtra">
                    </div>
                    <div class="input-group">
                        <label class="label">Country <span class="text-red-500">*</span></label>
                        <input type="text" name="country" value="{{ old('country', $event->country) }}" class="input-field input-lg" required>
                    </div>
                    <div class="input-group">
                        <label class="label">Contact Phone</label>
                        <input type="tel" name="contact_no" value="{{ old('contact_no', $event->contact_no) }}" class="input-field input-lg" placeholder="e.g. +91 98765 43210">
                    </div>
                    <div class="input-group">
                        <label class="label">Website URL</label>
                        <input type="url" name="website_url" value="{{ old('website_url', $event->website_url) }}" class="input-field input-lg" placeholder="https://example.com">
                    </div>
                </div>
            </div>

            {{-- Step 3: Audience & Budget --}}
            <div class="card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="text-purple-600 font-bold text-sm">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Audience & Budget</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="input-group">
                        <label class="label">Expected Audience <span class="text-red-500">*</span></label>
                        <input type="number" name="expected_audience" value="{{ old('expected_audience', $event->expected_audience) }}" class="input-field input-lg" required min="1">
                    </div>
                    <div class="input-group">
                        <label class="label">Minimum Budget (₹)</label>
                        <input type="number" name="budget_min" value="{{ old('budget_min', $event->budget_min) }}" class="input-field input-lg" min="0">
                    </div>
                    <div class="input-group">
                        <label class="label">Maximum Budget (₹)</label>
                        <input type="number" name="budget_max" value="{{ old('budget_max', $event->budget_max) }}" class="input-field input-lg" min="0">
                    </div>
                    <div class="input-group">
                        <label class="label">Video URL (YouTube/Vimeo)</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $event->video_url) }}" class="input-field input-lg" placeholder="https://youtube.com/watch?v=...">
                    </div>
                    <div class="md:col-span-2 input-group">
                        <label class="label">Audience Description</label>
                        <textarea name="audience_description" class="input-field" rows="3" placeholder="Describe your target audience - demographics, interests, industry, job roles, etc.">{{ old('audience_description', $event->audience_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Step 4: Media --}}
            <div class="card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <span class="text-emerald-600 font-bold text-sm">4</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Media & Branding</h3>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="input-group">
                            <label class="label">Cover Image</label>
                            @if($event->cover_image_url)
                                <div class="mb-2">
                                    <img src="{{ $event->cover_image_url }}" class="w-40 h-24 rounded-lg object-cover border border-gray-200">
                                </div>
                            @endif
                            <input type="file" name="cover_image" class="input-field" accept="image/jpeg,image/png,image/webp">
                            <p class="input-hint">JPEG, PNG or WebP. Max 2MB. Recommended: 1200x600px.</p>
                        </div>
                        <div class="input-group">
                            <label class="label">Event Logo</label>
                            @if($event->logo_url)
                                <div class="mb-2">
                                    <img src="{{ $event->logo_url }}" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                                </div>
                            @endif
                            <input type="file" name="logo" class="input-field" accept="image/jpeg,image/png,image/webp">
                            <p class="input-hint">JPEG, PNG or WebP. Max 2MB. Recommended: 500x500px.</p>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="label">YouTube Video URL</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $event->video_url) }}" class="input-field input-lg" placeholder="https://youtube.com/watch?v=...">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('organizer.events.show', $event) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</x-app-layout>
