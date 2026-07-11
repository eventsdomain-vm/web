<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorBrand;
use App\Models\SponsorBrandAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandAssetController extends Controller
{
    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(): View
    {
        $sponsorId = $this->getSponsorId();

        $brands = $sponsorId
            ? SponsorBrand::where('sponsor_id', $sponsorId)->with('assets')->get()
            : collect();

        $assets = $sponsorId
            ? SponsorBrandAsset::whereHas('brand', fn ($q) => $q->where('sponsor_id', $sponsorId))
                ->with('brand')
                ->latest()
                ->paginate(20)
            : collect();

        return view('sponsor.brand-assets.index', compact('brands', 'assets'));
    }

    public function storeBrand(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:300',
        ]);

        SponsorBrand::create([
            'sponsor_id' => $sponsorId,
            'slug' => str($validated['name'])->slug(),
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
        ]);

        return redirect()->route('sponsor.brand-assets.index')
            ->with('success', 'Brand created.');
    }

    public function storeAsset(Request $request): RedirectResponse
    {
        $sponsorId = $this->getSponsorId();
        if (! $sponsorId) {
            return back()->with('error', 'Sponsor profile not found.');
        }

        $validated = $request->validate([
            'brand_id' => 'required|exists:sponsor_brands,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'file_path' => 'required|string|max:500',
            'tags' => 'nullable|string',
        ]);

        $brand = SponsorBrand::findOrFail($validated['brand_id']);
        if ($brand->sponsor_id !== $sponsorId) {
            abort(403);
        }

        SponsorBrandAsset::create($validated);

        return redirect()->route('sponsor.brand-assets.index')
            ->with('success', 'Asset uploaded.');
    }
}
