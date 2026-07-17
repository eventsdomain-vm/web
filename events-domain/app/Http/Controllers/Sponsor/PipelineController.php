<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\SponsorProposal;
use App\Models\SponsorshipRequest;
use Illuminate\View\View;

class PipelineController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();

        // Merge proposals and sponsorship requests
        $proposals = SponsorProposal::where('sponsor_id', $userId)
            ->with(['event', 'package'])
            ->latest()
            ->get()
            ->each(fn($p) => $p->pipeline_type = 'proposal');

        $requests = SponsorshipRequest::where('sponsor_id', $userId)
            ->with(['event', 'package'])
            ->latest()
            ->get()
            ->each(fn($r) => $r->pipeline_type = 'request');

        $allItems = $proposals->concat($requests);

        $columns = [
            'discovery' => $allItems->whereIn('status', ['draft', 'viewed']),
            'interest' => $allItems->whereIn('status', ['shortlisted', 'interested']),
            'proposal' => $allItems->whereIn('status', ['submitted', 'in_review', 'pending']),
            'negotiation' => $allItems->whereIn('status', ['negotiating', 'counter_offer']),
            'closed_won' => $allItems->whereIn('status', ['agreed', 'contracted', 'active', 'completed', 'accepted']),
            'closed_lost' => $allItems->whereIn('status', ['rejected', 'withdrawn', 'cancelled']),
        ];

        $columnTotals = [];
        foreach ($columns as $key => $items) {
            $columnTotals[$key] = [
                'count' => $items->count(),
                'value' => $items->sum('budget_offer'),
            ];
        }

        // Discover events matching sponsor preferences
        $discoveryEvents = collect();
        if ($sponsor) {
            $preferences = $sponsor->preferences()->first();

            $query = Event::published()->upcoming()
                ->with('packages', 'category')
                ->whereDoesntHave('sponsorProposals', fn($q) => $q->where('sponsor_id', $userId))
                ->whereDoesntHave('sponsorshipRequests', fn($q) => $q->where('sponsor_id', $userId));

            if ($preferences) {
                if ($preferences->geographic_preferences) {
                    $query->whereIn('city', $preferences->geographic_preferences);
                }
                if ($preferences->min_audience_size) {
                    $query->where('expected_audience', '>=', $preferences->min_audience_size);
                }
                if ($preferences->max_audience_size) {
                    $query->where('expected_audience', '<=', $preferences->max_audience_size);
                }
                if ($preferences->industry_targets) {
                    $ids = Category::whereIn('name', $preferences->industry_targets)->pluck('id');
                    if ($ids->isNotEmpty()) {
                        $query->whereIn('category_id', $ids);
                    }
                }
                if ($preferences->event_types) {
                    $query->whereIn('event_type', $preferences->event_types);
                }
            }

            $discoveryEvents = $query->take(10)->get();
        }

        return view('sponsor.pipeline.index', compact('columns', 'columnTotals', 'allItems', 'discoveryEvents'));
    }
}
