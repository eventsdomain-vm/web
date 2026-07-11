<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Post-Event Reports') }}</h2>
    </x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" placeholder="Search event..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organizer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attendance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satisfaction</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ROI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($reports as $report)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $report->event->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $report->event->organizer->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($report->total_attendance ?? 0) }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $report->sponsor_satisfaction ?? 'N/A' }} / 5</td>
                                    <td class="px-6 py-4 text-sm text-green-600">{{ $report->roi_percentage ?? 'N/A' }}%</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">&#8377;{{ number_format($report->revenue_generated ?? 0) }}</td>
                                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.post-events.show', $report) }}" class="text-terracotta-500 hover:underline text-sm">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No reports found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $reports->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
