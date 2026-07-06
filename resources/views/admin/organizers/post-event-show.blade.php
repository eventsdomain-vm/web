<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post-Event Report</h2>
            <a href="{{ route('admin.post-events.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">&larr; Back</a>
        </div>
    </x-slot>
    <div class="space-y-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $report->event->title ?? 'N/A' }}</h1>
                <p class="text-gray-600">Organizer: {{ $report->event->organizer->name ?? 'N/A' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="card p-6"><h3 class="font-semibold mb-2">Attendance</h3><p class="text-3xl font-bold text-gray-900">{{ number_format($report->total_attendance ?? 0) }}</p><p class="text-sm text-gray-500 mt-1">Sponsor Booth Visits: {{ number_format($report->sponsor_booth_visits ?? 0) }}</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">Sponsor Satisfaction</h3><p class="text-3xl font-bold text-gray-900">{{ $report->sponsor_satisfaction ?? 'N/A' }} / 5</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">ROI</h3><p class="text-3xl font-bold {{ ($report->roi_percentage ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $report->roi_percentage ?? 'N/A' }}%</p></div>
                <div class="card p-6"><h3 class="font-semibold mb-2">Revenue Generated</h3><p class="text-3xl font-bold text-gray-900">&#8377;{{ number_format($report->revenue_generated ?? 0) }}</p><p class="text-sm text-gray-500 mt-1">Expenses: &#8377;{{ number_format($report->expenses_incurred ?? 0) }}</p></div>
            </div>
            <div class="card p-6 mb-6">
                <h3 class="font-semibold mb-3">Lead Generated</h3><p class="text-2xl font-bold">{{ number_format($report->lead_generated ?? 0) }}</p>
            </div>
            @if($report->deliverable_fulfillment)
            <div class="card p-6 mb-6"><h3 class="font-semibold mb-2">Deliverable Fulfillment</h3><ul class="list-disc pl-5 text-sm">@foreach($report->deliverable_fulfillment as $d) <li>{{ $d }}</li> @endforeach</ul></div>
            @endif
            @if($report->media_coverage)
            <div class="card p-6 mb-6"><h3 class="font-semibold mb-2">Media Coverage</h3><ul class="list-disc pl-5 text-sm">@foreach($report->media_coverage as $m) <li>{{ $m }}</li> @endforeach</ul></div>
            @endif
            @if($report->lessons_learned)
            <div class="card p-6 mb-6"><h3 class="font-semibold mb-2">Lessons Learned</h3><p class="text-gray-700 whitespace-pre-wrap text-sm">{{ $report->lessons_learned }}</p></div>
            @endif
            @if($report->improvement_notes)
            <div class="card p-6"><h3 class="font-semibold mb-2">Improvement Notes</h3><p class="text-gray-700 whitespace-pre-wrap text-sm">{{ $report->improvement_notes }}</p></div>
            @endif
        </div>
    </div>
</x-app-layout>
