<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerDiscoveryController extends Controller
{
    /**
     * Show events matching the logged-in partner's stated preferences —
     * this is the core "sponsor discovers events" feature.
     *
     * Route: GET /partner/discover
     */
    public function index(Request $request)
    {
        /** @var Partner $partner */
        $partner = $request->user()->partner; // assumes users.id -> partners.user_id relation

        $industryIds = $partner->industries()->pluck('industries.id');
        $categoryIds = $partner->categories()->pluck('categories.id');
        $cities      = $partner->preferredCities()->pluck('city');

        $events = Event::query()
            ->where('status', 'live')
            ->when($industryIds->isNotEmpty(), fn ($q) => $q->whereHas(
                'industries',
                fn ($sub) => $sub->whereIn('industries.id', $industryIds)
            ))
            ->when($categoryIds->isNotEmpty(), fn ($q) => $q->whereIn('category_id', $categoryIds))
            ->when($cities->isNotEmpty(), fn ($q) => $q->whereIn('city', $cities))
            // budget compatibility: only show events whose ask fits the partner's stated range
            ->when($partner->budget_range, fn ($q) => $q->where('sponsorship_budget_range', '<=', $partner->budget_range))
            ->with(['media', 'sponsorshipLevels', 'audienceTypes'])
            ->latest()
            ->paginate(12);

        // Fallback: if strict filters return nothing, relax to just category+city
        // to avoid an empty "no matches" screen on a mostly-empty dev DB.
        if ($events->isEmpty()) {
            $events = Event::query()
                ->where('status', 'live')
                ->when($cities->isNotEmpty(), fn ($q) => $q->whereIn('city', $cities))
                ->latest()
                ->paginate(12);
        }

        return view('partner.discover', compact('events', 'partner'));
    }
}
