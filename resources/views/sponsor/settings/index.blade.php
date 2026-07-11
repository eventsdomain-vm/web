<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings</h2>
    </x-slot>

    <div class="space-y-6 max-w-3xl">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Organization Profile</h3>
            </div>
            <form action="{{ route('sponsor.settings.update-org') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Legal Name</label>
                        <input type="text" name="name" value="{{ old('name', $sponsor->name) }}" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Organization Type</label>
                        <select name="org_type" class="w-full rounded-lg border-gray-200 text-sm">
                            <option value="">-- Select --</option>
                            @foreach(['Corporate', 'Government', 'Non-Profit', 'Educational Institution', 'Association', 'Startup', 'SME', 'Enterprise', 'Holding Company'] as $type)
                                <option value="{{ $type }}" {{ ($sponsor->org_type ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                        <input type="text" name="industry" value="{{ old('industry', $sponsor->industry) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" value="{{ old('website', $sponsor->website) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                        <input type="text" name="registration_number" value="{{ old('registration_number', $sponsor->registration_number) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tax ID</label>
                        <input type="text" name="tax_id" value="{{ old('tax_id', $sponsor->tax_id) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Headquarters</label>
                        <input type="text" name="headquarters" value="{{ old('headquarters', $sponsor->headquarters) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Email</label>
                        <input type="email" name="business_email" value="{{ old('business_email', $sponsor->business_email) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Phone</label>
                        <input type="text" name="business_phone" value="{{ old('business_phone', $sponsor->business_phone) }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                        <select name="timezone" class="w-full rounded-lg border-gray-200 text-sm">
                            <option value="">-- Select --</option>
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ ($sponsor->timezone ?? '') === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Currency</label>
                        <select name="default_currency" class="w-full rounded-lg border-gray-200 text-sm">
                            @foreach(['INR' => 'INR - Indian Rupee', 'USD' => 'USD - US Dollar', 'EUR' => 'EUR - Euro', 'GBP' => 'GBP - British Pound', 'AED' => 'AED - Dirham'] as $code => $label)
                                <option value="{{ $code }}" {{ ($sponsor->default_currency ?? 'INR') === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fiscal Year</label>
                        <input type="text" name="fiscal_year" value="{{ old('fiscal_year', $sponsor->fiscal_year) }}" placeholder="e.g., 2025-2026" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-200 text-sm">{{ old('description', $sponsor->description) }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary text-sm px-4 py-2">Save Organization Profile</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Brand Profiles</h3>
                <button x-data @click="$dispatch('open-modal', 'create-brand-modal')" class="btn-primary text-sm px-3 py-1.5">Add Brand</button>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($brands as $brand)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-medium text-gray-900">{{ $brand->name }}</h4>
                                    @if($brand->is_primary)
                                        <span class="badge badge-success text-[10px]">Primary</span>
                                    @endif
                                </div>
                                @if($brand->tagline)
                                    <p class="text-sm text-gray-500">{{ $brand->tagline }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $brand->assets->count() }} assets</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button x-data @click="$dispatch('open-modal', 'edit-brand-{{ $brand->id }}')" class="text-sm text-terracotta-500 hover:underline">Edit</button>
                                <form action="{{ route('sponsor.settings.brands.delete', $brand) }}" method="POST" onsubmit="return confirm('Delete this brand?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500 text-sm">No brands yet. Add your first brand profile.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Create Brand Modal --}}
    <div x-data="{ open: false }" @keydown.escape.window="open = false" x-show="open" x-cloak
         @open-modal.window="if ($event.detail === 'create-brand-modal') open = true"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.away="open = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Create Brand</h3>
            <form action="{{ route('sponsor.settings.brands.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" class="w-full rounded-lg border-gray-200 text-sm" maxlength="300">
                </div>
                <label class="flex items-center gap-2">
                    <input type="hidden" name="is_primary" value="0">
                    <input type="checkbox" name="is_primary" value="1" class="rounded border-gray-300">
                    <span class="text-sm text-gray-700">Set as primary brand</span>
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                    <button type="submit" class="btn-primary text-sm px-3 py-1.5">Create Brand</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Brand Modals --}}
    @foreach($brands as $brand)
        <div x-data="{ open: false }" @keydown.escape.window="open = false" x-show="open" x-cloak
             @open-modal.window="if ($event.detail === 'edit-brand-{{ $brand->id }}') open = true"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div @click.away="open = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Brand: {{ $brand->name }}</h3>
                <form action="{{ route('sponsor.settings.brands.update', $brand) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                        <input type="text" name="name" value="{{ $brand->name }}" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="{{ $brand->tagline }}" class="w-full rounded-lg border-gray-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Colors (JSON)</label>
                        <textarea name="brand_colors" rows="2" class="w-full rounded-lg border-gray-200 text-sm font-mono">{{ json_encode($brand->brand_colors) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Guidelines (JSON)</label>
                        <textarea name="brand_guidelines" rows="3" class="w-full rounded-lg border-gray-200 text-sm font-mono">{{ json_encode($brand->brand_guidelines) }}</textarea>
                    </div>
                    <label class="flex items-center gap-2">
                        <input type="hidden" name="is_primary" value="0">
                        <input type="checkbox" name="is_primary" value="1" {{ $brand->is_primary ? 'checked' : '' }} class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Primary brand</span>
                    </label>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="open = false" class="btn-outline text-sm px-3 py-1.5">Cancel</button>
                        <button type="submit" class="btn-primary text-sm px-3 py-1.5">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</x-app-layout>
