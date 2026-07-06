<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsorship Budget</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">{{ session('error') }}</div>
            @endif

            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Set Fiscal Year Budget</h3>
                <form action="{{ route('sponsor.budget.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Fiscal Year *</label>
                            <select name="fiscal_year" class="input-field w-full" required>
                                @for($year = date('Y'); $year <= date('Y') + 3; $year++)
                                    <option value="{{ $year }}" {{ ($currentBudget->fiscal_year ?? '') == $year ? 'selected' : '' }}>FY {{ $year }}-{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Total Budget (₹) *</label>
                            <input type="number" name="total_budget" min="0" step="0.01" value="{{ old('total_budget', $currentBudget->total_budget ?? '') }}" class="input-field w-full" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Preferred Event Size</label>
                            <select name="preferred_event_size" class="input-field w-full">
                                <option value="">Any Size</option>
                                <option value="small" {{ ($currentBudget->preferred_event_size ?? '') == 'small' ? 'selected' : '' }}>Small (under 1,000)</option>
                                <option value="medium" {{ ($currentBudget->preferred_event_size ?? '') == 'medium' ? 'selected' : '' }}>Medium (1,000 - 10,000)</option>
                                <option value="large" {{ ($currentBudget->preferred_event_size ?? '') == 'large' ? 'selected' : '' }}>Large (10,000+)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Preferred Categories</label>
                            <select name="preferred_categories[]" multiple class="input-field w-full" size="3">
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, ($currentBudget->preferred_categories ?? [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-primary text-sm">Save Budget</button>
                    </div>
                </form>
            </div>

            @if($budgets->count())
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Budget History</h3>
                <div class="space-y-3">
                    @foreach($budgets as $budget)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div>
                                <span class="font-medium text-gray-900">FY {{ $budget->fiscal_year }}-{{ $budget->fiscal_year + 1 }}</span>
                                <p class="text-sm text-gray-500">Total: ₹{{ number_format($budget->total_budget) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block font-bold text-gray-900">₹{{ number_format($budget->remaining) }}</span>
                                <span class="text-sm text-gray-500">remaining</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($currentBudget)
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Budget Utilization</h3>
                @php
                    $activeProposals = $proposals ?? collect();
                    $committed = $activeProposals->whereIn('status', ['agreed', 'contracted', 'active'])->sum('budget_offer');
                    $pending = $activeProposals->whereIn('status', ['submitted', 'viewed', 'shortlisted', 'negotiating'])->sum('budget_offer');
                    $total = $currentBudget->total_budget;
                    $committedPercent = $total > 0 ? round(($committed / $total) * 100) : 0;
                    $pendingPercent = $total > 0 ? round(($pending / $total) * 100) : 0;
                @endphp
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Committed</span>
                        <span class="font-medium">₹{{ number_format($committed) }} ({{ $committedPercent }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-terracotta-500 h-3 rounded-full" style="width: {{ min($committedPercent, 100) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Pending</span>
                        <span class="font-medium">₹{{ number_format($pending) }} ({{ $pendingPercent }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: {{ min($pendingPercent, 100) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm pt-2 border-t">
                        <span class="font-semibold text-gray-700">Available</span>
                        <span class="font-bold text-green-600">₹{{ number_format($total - $committed - $pending) }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
