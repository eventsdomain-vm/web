<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schema Markup</h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($schemas as $key => $schema)
        <div class="card p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-1 capitalize">{{ $key }}</h3>
            <p class="text-xs text-gray-400 mb-3">Type: {{ $schema['type'] ?? 'N/A' }}</p>
            <pre class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 overflow-x-auto max-h-60">{{ json_encode($schema, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endforeach
    </div>
</x-app-layout>
