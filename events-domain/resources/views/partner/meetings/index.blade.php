<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meetings</h2>
            <a href="{{ route('partner.meetings.create') }}" class="btn-primary text-sm px-4 py-2 rounded-lg">+ Schedule Meeting</a>
        </div>
    </x-slot>
    <div class="container-page">
        <div class="flex gap-2 mb-4 flex-wrap">
            <a href="{{ route('partner.meetings.index') }}" class="text-xs px-3 py-1 rounded-full {{ !request('status') ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
            @foreach(['scheduled','confirmed','completed','cancelled'] as $s)
                <a href="{{ route('partner.meetings.index', ['status' => $s]) }}" class="text-xs px-3 py-1 rounded-full {{ request('status') === $s ? 'bg-terracotta-500 text-white' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($s) }}</a>
            @endforeach
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr><th class="px-4 py-3 text-gray-600 font-medium">Title</th><th class="px-4 py-3 text-gray-600 font-medium">Type</th><th class="px-4 py-3 text-gray-600 font-medium">Start</th><th class="px-4 py-3 text-gray-600 font-medium">Status</th><th class="px-4 py-3 text-gray-600 font-medium">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($meetings as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $m->title }}</td>
                            <td class="px-4 py-3 capitalize">{{ $m->type }}</td>
                            <td class="px-4 py-3">{{ $m->start_time->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3"><span class="badge badge-{{ $m->status === 'completed' ? 'success' : ($m->status === 'cancelled' ? 'danger' : 'info') }} text-xs">{{ $m->status }}</span></td>
                            <td class="px-4 py-3"><a href="{{ route('partner.meetings.show', $m->id) }}" class="text-terracotta-500 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">No meetings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $meetings->links() }}</div>
    </div>
</x-app-layout>
