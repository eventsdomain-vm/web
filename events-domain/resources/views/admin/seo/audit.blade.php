<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">SEO Audit</h2>
            <form method="POST" action="{{ route('admin.seo.schedule-scan') }}">
                @csrf
                <button type="submit" class="btn-primary text-sm">Run Scan</button>
            </form>
        </div>
    </x-slot>

    <div class="space-y-4">
        @foreach($seoIssues as $issue)
            <div class="card p-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="w-2.5 h-2.5 rounded-full {{ $issue['severity'] === 'high' ? 'bg-red-500' : ($issue['severity'] === 'medium' ? 'bg-yellow-500' : 'bg-blue-500') }}"></span>
                    <div>
                        <p class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $issue['type']) }}</p>
                        <p class="text-sm text-gray-500 capitalize">Severity: {{ $issue['severity'] }}</p>
                    </div>
                </div>
                <span class="text-2xl font-bold {{ $issue['count'] > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $issue['count'] }}</span>
            </div>
        @endforeach
    </div>
</x-app-layout>
