<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
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

        return view('sponsor.pipeline.index', compact('columns', 'columnTotals', 'proposals'));
    }
}
