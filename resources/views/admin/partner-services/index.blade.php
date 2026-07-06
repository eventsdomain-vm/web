<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Partner Services') }}</h2></x-slot>
    <div class="space-y-6">
        <div class="container-page">
            <div class="card p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="pricing_model" class="input-field w-auto">
                        <option value="">All Models</option><option value="cost" {{ request('pricing_model')==='cost'?'selected':'' }}>Cost</option><option value="barter" {{ request('pricing_model')==='barter'?'selected':'' }}>Barter</option><option value="hybrid" {{ request('pricing_model')==='hybrid'?'selected':'' }}>Hybrid</option>
                    </select>
                    <input type="text" name="search" placeholder="Search services..." value="{{ request('search') }}" class="input-field w-64">
                    <button type="submit" class="btn-primary text-sm">Search</button>
                </form>
            </div>
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Partner</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($services as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $service->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $service->partner->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $service->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">&#8377;{{ number_format($service->price) }}</td>
                                    <td class="px-6 py-4 text-sm"><span class="badge badge-info">{{ ucfirst($service->pricing_model) }}</span></td>
                                    <td class="px-6 py-4 text-sm"><span class="badge {{ $service->is_available ? 'badge-success' : 'badge-danger' }}">{{ $service->is_available ? 'Yes' : 'No' }}</span></td>
                                    <td class="px-6 py-4 text-right flex gap-2 justify-end">
                                        <a href="{{ route('admin.partner-services.show', $service) }}" class="text-terracotta-500 hover:underline text-sm">View</a>
                                        <form method="POST" action="{{ route('admin.partner-services.toggle', $service) }}" class="inline">@csrf<button type="submit" class="text-blue-600 hover:underline text-sm">Toggle</button></form>
                                        <form method="POST" action="{{ route('admin.partner-services.destroy', $service) }}" class="inline" onsubmit="return confirm('Delete this service?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline text-sm">Delete</button></form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No services found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t">{{ $services->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
