<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PartnerService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'total_services' => $user->partnerServices()->count(),
            'active_services' => $user->partnerServices()->available()->count(),
            'total_bids' => $user->partnerBids()->count(),
            'accepted_bids' => $user->partnerBids()->where('status', 'accepted')->count(),
        ];

        $recentServices = $user->partnerServices()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('partner.dashboard', compact('stats', 'recentServices'));
    }

    public function index()
    {
        $services = auth()->user()->partnerServices()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('partner.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('partner.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly,negotiable',
            'pricing_model' => 'required|in:cost,barter,hybrid',
        ]);

        $validated['partner_id'] = auth()->id();
        $validated['is_available'] = true;

        $service = PartnerService::create($validated);

        return redirect()->route('partner.services.show', $service)
            ->with('success', 'Service created successfully!');
    }

    public function show(PartnerService $service)
    {
        $service->load('category', 'reviews.organizer');

        return view('partner.services.show', compact('service'));
    }

    public function edit(PartnerService $service)
    {
        if ($service->partner_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('partner.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, PartnerService $service)
    {
        if ($service->partner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly,negotiable',
            'pricing_model' => 'required|in:cost,barter,hybrid',
            'is_available' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()->route('partner.services.show', $service)
            ->with('success', 'Service updated successfully!');
    }

    public function toggle(PartnerService $service): JsonResponse
    {
        if ($service->partner_id !== auth()->id()) {
            abort(403);
        }

        $service->is_available = ! $service->is_available;
        $service->save();

        return response()->json(['is_available' => $service->is_available]);
    }

    public function unSave(PartnerService $service): RedirectResponse
    {
        if ($service->partner_id !== auth()->id()) {
            abort(403);
        }

        $service->update(['is_available' => false]);

        return redirect()->route('partner.saved.index')
            ->with('success', 'Service removed from saved services!');
    }

    public function destroy(PartnerService $service): RedirectResponse
    {
        if ($service->partner_id !== auth()->id()) {
            abort(403);
        }

        $service->delete();

        return redirect()->route('partner.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    public function saved()
    {
        $savedServices = auth()->user()->partnerServices()
            ->with('category')
            ->where('is_available', false)
            ->latest()
            ->paginate(10);

        return view('partner.saved.index', compact('savedServices'));
    }
}
