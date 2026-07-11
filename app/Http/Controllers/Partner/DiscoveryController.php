<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscoveryController extends Controller
{
    public function index(Request $request): View
    {
        $partner = $request->user()->partner;

        if (!$partner) {
            abort(404, 'Partner profile not found.');
        }

        $industryIds = $partner->industries()->pluck('industries.id');
        $categoryIds = $partner->categories()->pluck('categories.id');
        $cities = $partner->preferredCities()->pluck('city');

        $events = Event::query()
            ->where('status', 'live')
            ->when($industryIds->isNotEmpty(), fn ($q) => $q->whereHas(
                'audience',
                fn ($sub) => $sub->whereIn('industry_alignment', $industryIds->all())
            ))
            ->when($categoryIds->isNotEmpty(), fn ($q) => $q->whereIn('category_id', $categoryIds))
            ->when($cities->isNotEmpty(), fn ($q) => $q->whereIn('city', $cities))
            ->with(['sponsorshipLevels', 'audience'])
            ->latest()
            ->paginate(12);

        if ($events->isEmpty()) {
            $events = Event::query()
                ->where('status', 'live')
                ->when($cities->isNotEmpty(), fn ($q) => $q->whereIn('city', $cities))
                ->with(['sponsorshipLevels', 'audience'])
                ->latest()
                ->paginate(12);
        }

        return view('partner.discover', compact('events', 'partner'));
    }
}
