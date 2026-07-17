<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\SponsorProposal;
use Illuminate\View\View;

class PipelineController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();

        $proposals = SponsorProposal::where('sponsor_id', $userId)
            ->with(['event', 'package'])
            ->latest()
            ->get();

        $columns = [
            'discovery' => $proposals->whereIn('status', ['draft', 'viewed']),
            'interest' => $proposals->whereIn('status', ['shortlisted', 'interested']),
            'proposal' => $proposals->whereIn('status', ['submitted', 'in_review']),
            'negotiation' => $proposals->whereIn('status', ['negotiating', 'counter_offer']),
            'closed_won' => $proposals->whereIn('status', ['agreed', 'contracted', 'active', 'completed']),
            'closed_lost' => $proposals->whereIn('status', ['rejected', 'withdrawn', 'cancelled']),
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
                ->whereDoesntHave('sponsorProposals', fn($q) => $q->where('sponsor_id', $userId));

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

        return view('sponsor.pipeline.index', compact('columns', 'columnTotals', 'proposals', 'discoveryEvents'));
    }
}
