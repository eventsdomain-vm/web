<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorBrand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->first();
        $brands = $sponsor?->brands()->with('assets')->get() ?? collect();

        if (! $sponsor) {
            $sponsor = new Sponsor;
            $sponsor->user_id = auth()->id();
        }

        return view('sponsor.settings.index', compact('sponsor', 'brands'));
    }

    public function updateOrg(Request $request): RedirectResponse
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->first() ?? new Sponsor(['user_id' => auth()->id()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'org_type' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
            'headquarters' => 'nullable|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|string|max:50',
            'timezone' => 'nullable|string|max:100',
            'default_currency' => 'nullable|string|max:10',
            'fiscal_year' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.($sponsor->exists ? $sponsor->id : Str::random(8));
        $validated['is_verified'] ??= false;

        if ($sponsor->exists) {
            $sponsor->update($validated);
        } else {
            $sponsor->fill($validated)->save();
        }

        return redirect()->route('sponsor.settings.index')
            ->with('success', 'Organization profile updated.');
    }

    public function storeBrand(Request $request): RedirectResponse
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->first();
        if (! $sponsor) {
            return redirect()->route('sponsor.settings.index')
                ->with('error', 'Create your organization profile first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:300',
            'is_primary' => 'boolean',
        ]);

        $sponsor->brands()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(6),
            'tagline' => $validated['tagline'] ?? null,
            'is_primary' => $request->boolean('is_primary'),
        ]);

        return redirect()->route('sponsor.settings.index')
            ->with('success', 'Brand created.');
    }

    public function updateBrand(Request $request, SponsorBrand $brand): RedirectResponse
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->firstOrFail();

        if ($brand->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:300',
            'brand_colors' => 'nullable|json',
            'brand_guidelines' => 'nullable|json',
            'is_primary' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'is_primary' => $request->boolean('is_primary'),
        ];

        if (! empty($validated['brand_colors'])) {
            $data['brand_colors'] = json_decode($validated['brand_colors'], true);
        }
        if (! empty($validated['brand_guidelines'])) {
            $data['brand_guidelines'] = json_decode($validated['brand_guidelines'], true);
        }

        $brand->update($data);

        return redirect()->route('sponsor.settings.index')
            ->with('success', 'Brand updated.');
    }

    public function deleteBrand(SponsorBrand $brand): RedirectResponse
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->firstOrFail();

        if ($brand->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $brand->delete();

        return redirect()->route('sponsor.settings.index')
            ->with('success', 'Brand deleted.');
    }
}
