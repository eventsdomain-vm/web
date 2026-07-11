<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post-Event Report: {{ $event->title }}</h2>
            <a href="{{ route('organizer.post-event.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back</a>
        </div>
    </x-slot>
    <div class="container-page">
        <form method="POST" action="{{ route('organizer.post-event.store') }}" class="card p-6 max-w-3xl">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Total Attendance</label>
                    <input type="number" name="total_attendance" min="0" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sponsor Booth Visits</label>
                    <input type="number" name="sponsor_booth_visits" min="0" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Leads Generated</label>
                    <input type="number" name="lead_generated" min="0" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sponsor Satisfaction (1-5)</label>
                    <input type="number" name="sponsor_satisfaction" min="0" max="5" step="0.1" class="w-full rounded-lg border-gray-300 text-sm">
                </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Sponsor Satisfaction (1-5)</label>
                <input type="number" name="sponsor_satisfaction" min="0" max="5" step="0.1" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">ROI (%)</label>
                <input type="number" name="roi_percentage" min="-100" max="1000" step="0.1" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Revenue Generated (₹)</label>
                <input type="number" name="revenue_generated" min="0" step="0.01" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Expenses Incurred (₹)</label>
                <input type="number" name="expenses_incurred" min="0" step="0.01" class="w-full rounded-lg border-gray-300 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Deliverable Fulfillment</label>
                <textarea name="deliverable_fulfillment" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="e.g., Booth presence, branding, speaking slots, etc."></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Media Coverage</label>
                <textarea name="media_coverage" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="e.g., social mentions, press coverage, etc."></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">Feedback Data</label>
                <textarea name="feedback_data" rows="2" class="w-full rounded-lg border-gray-300 text-sm" placeholder="e.g., sponsor surveys, NPS, etc."></textarea>
            </div>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Lessons Learned</label>
                <textarea name="lessons_learned" rows="3" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Improvement Notes</label>
                <textarea name="improvement_notes" rows="3" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
            </div>
            <div class="flex justify-between">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="rounded-lg border-gray-300 text-sm">
                        <option value="draft">Draft</option>
                        <option value="submitted">Submit</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-sm">Save Report</button>
            </div>
        </form>
    </div>
</x-app-layout>
