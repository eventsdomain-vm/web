<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sponsor Profile & Plan</h2>
                <p class="text-sm text-gray-500 mt-1">Your complete sponsorship plan at a glance.</p>
            </div>
            <span class="px-3 py-1 bg-terracotta-50 text-terracotta-700 text-sm font-medium rounded-full capitalize">{{ $profile['profile']['org_type'] ?? 'Not Set' }} Sponsor</span>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                {{-- Organization Profile --}}
                <section class="card overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-5m-9 0H3m2 0h5M7 7h1v1H7V7zm5 0h1v1h-1V7zm-5 4h1v1H7v-1zm5 0h1v1h-1v-1z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Organization Profile</h3>
                                <p class="text-sm text-gray-500">Core details about your company.</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full whitespace-nowrap">{{ $profile['completion_percentage'] }}% Complete</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Legal Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $profile['profile']['name'] }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Industry</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $profile['profile']['industry'] ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Organization Type</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $profile['profile']['org_type'] ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Business Email</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $profile['profile']['business_email'] }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Website</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">
                                    <a href="{{ $profile['profile']['website'] }}" target="_blank" class="text-terracotta-500 hover:underline">{{ $profile['profile']['website'] }}</a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Budget (Current FY)</label>
                                <p class="mt-1 text-sm font-medium text-gray-900">₹{{ number_format($profile['plan_status']['budget']['current_fiscal_year']['total_budget'] ?? 0) }}</p>
                            </div>
                        </div>

                        @if(!empty($profile['next_steps']))
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <h4 class="text-sm font-semibold text-yellow-800">Next Steps to Complete Your Profile</h4>
                                <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                    @foreach($profile['next_steps'] as $step)
                                        <li class="flex gap-2"><span>•</span><span>{{ $step }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Sponsorship Objectives --}}
                <section class="card overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Sponsorship Objectives</h3>
                                <p class="text-sm text-gray-500">What you want to achieve.</p>
                            </div>
                        </div>
                        <button x-data @click="$dispatch('open-modal', 'create-objective-modal')" class="btn-primary text-sm px-3.5 py-2 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Objective
                        </button>
                    </div>

                    @if($objectives->isNotEmpty())
                        <div class="divide-y divide-gray-100">
                            @foreach($objectives as $objective)
                                <div class="p-6 hover:bg-gray-50 transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900">{{ $objective->name }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">{{ $objective->description }}</p>
                                            <div class="flex flex-wrap items-center gap-3 mt-3">
                                                <span class="px-2 py-1 bg-terracotta-100 text-terracotta-700 text-xs font-medium rounded">{{ str_replace('_', ' ', $objective->objective_type) }}</span>
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
                                        <a href="{{ route('sponsor.plan.objectives') }}" class="text-terracotta-500 hover:underline text-sm font-medium shrink-0">Manage</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a9 9 0 01-9 9 9a9 0 01-9-9 9 0 0118 0z"/></svg>
                            <p class="text-sm">No sponsorship objectives defined yet</p>
                            <p class="text-xs text-gray-400 mt-1">Set objectives to guide AI recommendations</p>
                        </div>
                    @endif
                </section>

                {{-- Target Preferences & AI Matching --}}
                <section class="card overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Target Preferences & AI Matching</h3>
                                <p class="text-sm text-gray-500">Who and what you want to sponsor.</p>
                            </div>
                        </div>
                        <a href="{{ route('sponsor.plan.preferences') }}" class="btn-primary text-sm px-3.5 py-2 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Set Preferences
                        </a>
                    </div>

                    @if($profile['plan_status']['preferences']['exists'])
                        <div class="divide-y divide-gray-100">
                            <div class="p-6">
                                <h4 class="font-medium text-gray-900 mb-3 text-sm">Target Industries</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profile['plan_status']['preferences']['industry_targets'] ?? [] as $industry)
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">{{ $industry }}</span>
                                    @endforeach
                                    @if(!count($profile['plan_status']['preferences']['industry_targets'] ?? []))
                                        <span class="text-sm text-gray-500">No industry preferences set</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-medium text-gray-900 mb-3 text-sm">Event Types & Formats</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php $formats = $profile['plan_status']['preferences']['formats_preferred'] ?? []; @endphp
                                    @foreach(['physical', 'virtual', 'hybrid', 'digital'] as $format)
                                        <span class="px-2.5 py-1 {{ in_array($format, $formats) ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-500' }} text-xs font-medium rounded-full">{{ ucfirst($format) }} {{ in_array($format, $formats) ? '✓' : '' }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-medium text-gray-900 mb-3 text-sm">Budget & Audience Range</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-500">Min Audience</label>
                                        <p class="text-sm font-medium text-gray-900">{{ $profile['plan_status']['preferences']['min_audience_size'] ?? 'Not set' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500">Max Audience</label>
                                        <p class="text-sm font-medium text-gray-900">{{ $profile['plan_status']['preferences']['max_audience_size'] ?? 'Not set' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500">Budget Range</label>
                                        <p class="text-sm font-medium text-gray-900">
                                            @php $budgetRange = $profile['plan_status']['preferences']['budget_range'] ?? []; @endphp
                                            {{ isset($budgetRange['min']) ? '₹' . number_format($budgetRange['min']) : 'Not set' }}
                                            @if(isset($budgetRange['min']) && isset($budgetRange['max'])) – ₹{{ number_format($budgetRange['max']) }}@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <p class="text-sm">No targeting preferences set</p>
                            <p class="text-xs text-gray-400 mt-1">Set preferences to improve AI matching</p>
                        </div>
                    @endif
                </section>

                {{-- Budget Allocations --}}
                <section class="card overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Budget Allocations</h3>
                                <p class="text-sm text-gray-500">Your planned spend by fiscal year.</p>
                            </div>
                        </div>
                        <a href="{{ route('sponsor.plan.budgets') }}" class="btn-primary text-sm px-3.5 py-2 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Manage Budgets
                        </a>
                    </div>

                    @if($profile['plan_status']['budget']['current_fiscal_year'])
                        @php
                            $fy = $profile['plan_status']['budget']['current_fiscal_year'];
                            $used = ($fy['total_budget'] ?? 0) > 0 ? min(100, (($fy['allocated_so_far'] ?? 0) / $fy['total_budget']) * 100) : 0;
                            $rem = ($fy['total_budget'] ?? 0) - ($fy['allocated_so_far'] ?? 0);
                        @endphp
                        <div class="p-6">
                            <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="font-semibold text-lg text-gray-900">{{ $fy['fiscal_year'] }} Fiscal Year</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ ucfirst($fy['status']) }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Budget</p>
                                    <p class="text-2xl font-bold text-gray-900">₹{{ number_format($fy['total_budget'] ?? 0, 2) }}</p>
                                </div>
                            </div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="text-gray-500">Utilization</span>
                                <span class="font-medium text-gray-700">{{ number_format($used, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-terracotta-500 h-2.5 rounded-full transition-all" style="width: {{ $used }}%"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-5">
                                <div class="p-3.5 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Allocated</p>
                                    <p class="text-sm font-semibold text-gray-900">₹{{ number_format($fy['allocated_so_far'] ?? 0, 2) }}</p>
                                </div>
                                <div class="p-3.5 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Remaining</p>
                                    <p class="text-sm font-semibold text-gray-900">₹{{ number_format($rem, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2.5a2.5 2.5 0 010 5H17v7a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm">No budget allocation set yet</p>
                            <p class="text-xs text-gray-400 mt-1">Define fiscal year and total budget</p>
                        </div>
                    @endif
                </section>
            </div>

            <div class="space-y-6">
                {{-- AI Recommendations --}}
                <section class="card overflow-hidden" x-data="recommendationsPanel()" x-ref="panel">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-terracotta-50 text-terracotta-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">AI Recommendations</h3>
                            <p class="text-sm text-gray-500">Personalized for your plan.</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <template x-for="rec in items" :key="rec.key">
                            <div class="p-4 rounded-xl border" :class="rec.cardClass">
                                <div class="flex items-start gap-3">
                                    <div class="text-xl leading-none" x-text="rec.emoji"></div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold" :class="rec.titleClass" x-text="rec.title"></h4>
                                        <p class="text-xs mt-1" :class="rec.bodyClass" x-text="rec.message"></p>
                                        <p class="text-xs font-semibold mt-2" :class="rec.roiClass" x-text="'Potential ROI: ' + rec.potential_roi"></p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <form x-ref="form" action="{{ route('sponsor.plan.generate-recommendations') }}" method="POST" @submit.prevent="generate($refs.form)" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full btn-primary text-sm px-4 py-2.5 inline-flex items-center justify-center gap-2" :class="loading ? 'opacity-70 cursor-wait' : ''" :disabled="loading">
                                <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                <span x-text="loading ? 'Generating…' : 'Generate Fresh Recommendations'">Generate Fresh Recommendations</span>
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Quick Actions --}}
                <section class="card overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-2">
                        <a href="{{ route('sponsor.plan.objectives') }}" class="w-full text-left px-4 py-2.5 text-sm rounded-lg hover:bg-gray-50 transition flex items-center gap-2"><span class="text-terracotta-500">•</span> Create Sponsorship Objectives</a>
                        <a href="{{ route('sponsor.plan.preferences') }}" class="w-full text-left px-4 py-2.5 text-sm rounded-lg hover:bg-gray-50 transition flex items-center gap-2"><span class="text-terracotta-500">•</span> Set Target Preferences & AI Matching</a>
                        <a href="{{ route('sponsor.plan.budgets') }}" class="w-full text-left px-4 py-2.5 text-sm rounded-lg hover:bg-gray-50 transition flex items-center gap-2"><span class="text-terracotta-500">•</span> Allocate Budget for Fiscal Year</a>
                        <a href="{{ route('sponsor.events.index') }}" class="w-full text-left px-4 py-2.5 text-sm rounded-lg hover:bg-gray-50 transition flex items-center gap-2"><span class="text-terracotta-500">•</span> Browse Events & Start Proposals</a>
                    </div>
                </section>
            </div>
        </div>
    </div>

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

    <script>
        function recommendationsPanel() {
            const meta = {
                optimize_budget_allocation: { title: 'Optimize Budget Allocation', emoji: '🚀', tone: 'terracotta' },
                target_audience_refinement: { title: 'Target Audience Refinement', emoji: '🎯', tone: 'blue' },
                event_type_expansion: { title: 'Event Type Expansion', emoji: '🔄', tone: 'purple' },
            };
            const tones = {
                terracotta: { card: 'bg-terracotta-50 border-terracotta-200', title: 'text-terracotta-800', body: 'text-terracotta-700', roi: 'text-terracotta-600' },
                blue: { card: 'bg-blue-50 border-blue-200', title: 'text-blue-800', body: 'text-blue-700', roi: 'text-blue-600' },
                purple: { card: 'bg-purple-50 border-purple-200', title: 'text-purple-800', body: 'text-purple-700', roi: 'text-purple-600' },
            };
            const defaults = [
                { key: 'optimize_budget_allocation', message: 'Based on your sponsorship objectives, consider allocating more budget to lead_generation objectives', impact: 'high', potential_roi: '+23%' },
                { key: 'target_audience_refinement', message: 'Your target audience demographics could be refined for better event matching', impact: 'medium', potential_roi: '+15%' },
                { key: 'event_type_expansion', message: 'Consider expanding to virtual/hybrid events to reach wider audience', impact: 'medium', potential_roi: '+8%' },
            ];
            function buildList(obj) {
                return Object.entries(obj).map(([key, val]) => ({ key, ...val }));
            }
            function build(list) {
                return list.map(r => {
                    const m = meta[r.key] || { title: r.key, emoji: '💡', tone: 'terracotta' };
                    const t = tones[m.tone];
                    return { key: r.key, emoji: m.emoji, title: m.title, message: r.message, impact: r.impact, potential_roi: r.potential_roi, cardClass: t.card, titleClass: t.title, bodyClass: t.body, roiClass: t.roi };
                });
            }
            return {
                items: build(defaults),
                loading: false,
                async generate(form) {
                    this.loading = true;
                    const token = document.querySelector('input[name="_token"]').value;
                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                        });
                        if (res.ok) {
                            const data = await res.json();
                            if (data.recommendations) {
                                this.items = build(buildList(data.recommendations));
                            }
                        } else {
                            alert('Could not generate recommendations. Please try again.');
                        }
                    } catch (e) {
                        alert('Network error. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
    </script>
</x-app-layout>
