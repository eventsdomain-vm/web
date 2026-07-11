<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsorship Objectives</h2>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Your Objectives</h3>
            <button x-data @click="$dispatch('open-modal', 'create-objective-modal')" class="btn-primary text-sm px-3 py-1.5">Add Objective</button>
        </div>

        @if($objectives->isNotEmpty())
            <div class="space-y-4">
                @foreach($objectives as $objective)
                    <div class="card p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900">{{ $objective->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $objective->description }}</p>
                                <div class="flex items-center gap-4 mt-3">
                                    <span class="px-2 py-1 bg-terracotta-100 text-terracotta-700 text-xs font-medium rounded">
                                        {{ str_replace('_', ' ', $objective->objective_type) }}
                                    </span>
                                    @if($objective->target_kpi_value)
                                        <span class="text-xs text-gray-500">Target: {{ $objective->target_kpi_value }} {{ $objective->kpi_unit ?? '' }}</span>
                                    @endif
                                    @if($objective->estimated_cost)
                                        <span class="text-xs text-gray-500">Cost: ₹{{ number_format($objective->estimated_cost) }}</span>
                                    @endif
                                    @if($objective->estimated_roi)
                                        <span class="text-xs text-gray-500">ROI: {{ $objective->estimated_roi }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button x-data @click="$dispatch('open-modal', 'edit-objective-{{ $objective->id }}')" class="text-terracotta-500 hover:underline text-sm">Edit</button>
                                <form action="{{ route('sponsor.plan.objectives.destroy', $objective) }}" method="POST" onsubmit="return confirm('Delete this objective?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a9 9 0 01-9 9 9a9 0 01-9-9 9 0 0118 0z"/></svg>
                <p class="text-sm">No sponsorship objectives defined yet</p>
                <p class="text-xs text-gray-400 mt-1">Set objectives to guide AI recommendations</p>
                <button x-data @click="$dispatch('open-modal', 'create-objective-modal')" class="mt-4 btn-primary text-sm px-3 py-1.5">Create Your First Objective</button>
            </div>
        @endif
    </div>

    {{-- Create Objective Modal --}}
    <x-modal name="create-objective-modal">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Sponsorship Objective</h3>
            <form action="{{ route('sponsor.plan.objectives.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Type</label>
                    <select name="objective_type" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="brand_awareness">Brand Awareness</option>
                        <option value="lead_generation" selected>Lead Generation</option>
                        <option value="sales_conversion">Sales Conversion</option>
                        <option value="csr">CSR / Community</option>
                        <option value="product_launch">Product Launch</option>
                        <option value="market_entry">Market Entry</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target KPI Value</label>
                        <input type="number" name="target_kpi_value" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KPI Unit</label>
                        <input type="text" name="kpi_unit" class="w-full rounded-lg border-gray-200 text-sm" placeholder="e.g., leads, views, revenue">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
                        <input type="number" name="estimated_cost" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated ROI (%)</label>
                        <input type="number" name="estimated_roi" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="show = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Create Objective</button>
                </div>
            </form>
        </div>
    </x-modal>

    @foreach($objectives as $objective)
    <x-modal name="edit-objective-{{ $objective->id }}">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Objective</h3>
            <form action="{{ route('sponsor.plan.objectives.update', $objective) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Name</label>
                    <input type="text" name="name" value="{{ $objective->name }}" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm">{{ $objective->description }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objective Type</label>
                    <select name="objective_type" class="w-full rounded-lg border-gray-200 text-sm">
                        <option value="brand_awareness" {{ $objective->objective_type === 'brand_awareness' ? 'selected' : '' }}>Brand Awareness</option>
                        <option value="lead_generation" {{ $objective->objective_type === 'lead_generation' ? 'selected' : '' }}>Lead Generation</option>
                        <option value="sales_conversion" {{ $objective->objective_type === 'sales_conversion' ? 'selected' : '' }}>Sales Conversion</option>
                        <option value="csr" {{ $objective->objective_type === 'csr' ? 'selected' : '' }}>CSR / Community</option>
                        <option value="product_launch" {{ $objective->objective_type === 'product_launch' ? 'selected' : '' }}>Product Launch</option>
                        <option value="market_entry" {{ $objective->objective_type === 'market_entry' ? 'selected' : '' }}>Market Entry</option>
                        <option value="other" {{ $objective->objective_type === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Target KPI Value</label>
                        <input type="number" name="target_kpi_value" value="{{ $objective->target_kpi_value }}" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KPI Unit</label>
                        <input type="text" name="kpi_unit" value="{{ $objective->kpi_unit }}" class="w-full rounded-lg border-gray-200 text-sm" placeholder="e.g., leads, views, revenue">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost</label>
                        <input type="number" name="estimated_cost" value="{{ $objective->estimated_cost }}" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimated ROI (%)</label>
                        <input type="number" name="estimated_roi" value="{{ $objective->estimated_roi }}" class="w-full rounded-lg border-gray-200 text-sm" step="0.01">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="show = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Update Objective</button>
                </div>
            </form>
        </div>
    </x-modal>
    @endforeach
</x-app-layout>