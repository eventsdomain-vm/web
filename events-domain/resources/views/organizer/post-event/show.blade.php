<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report: {{ $report->event?->title ?? 'Event #'.$report->event_id }}</h2>
            <a href="{{ route('organizer.post-event.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="card p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Attendance</span><p class="text-lg font-bold">{{ $report->total_attendance ?? '-' }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Leads</span><p class="text-lg font-bold">{{ $report->lead_generated ?? '-' }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Satisfaction</span><p class="text-lg font-bold">{{ $report->sponsor_satisfaction ?? '-' }}/5</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">ROI</span><p class="text-lg font-bold">{{ $report->roi_percentage !== null ? $report->roi_percentage.'%' : '-' }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Revenue</span><p class="text-lg font-bold">₹{{ number_format($report->revenue_generated ?? 0, 2) }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Expenses</span><p class="text-lg font-bold">₹{{ number_format($report->expenses_incurred ?? 0, 2) }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Booth Visits</span><p class="text-lg font-bold">{{ $report->sponsor_booth_visits ?? '-' }}</p></div>
                <div class="bg-gray-50 p-3 rounded-lg"><span class="text-xs text-gray-500">Status</span><p class="text-lg font-bold">{{ ucfirst($report->status) }}</p></div>
            </div>
            @if ($report->lessons_learned)
                <div class="mb-4"><h3 class="text-sm font-semibold text-gray-900 mb-1">Lessons Learned</h3><p class="text-sm text-gray-600">{{ $report->lessons_learned }}</p></div>
            @endif
            @if ($report->improvement_notes)
                <div><h3 class="text-sm font-semibold text-gray-900 mb-1">Improvement Notes</h3><p class="text-sm text-gray-600">{{ $report->improvement_notes }}</p></div>
            @endif
        </div>
    </div>
</x-app-layout>
