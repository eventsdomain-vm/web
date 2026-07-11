<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\SponsorCampaign;
use App\Models\SponsorProposal;
use App\Models\SponsorSavedEvent;
use App\Models\SponsorshipRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Legacy stats
        $oldActiveSponsorships = $user->sponsorshipRequests()->accepted()->count();
        $oldPendingRequests = $user->sponsorshipRequests()->pending()->count();
        $oldTotalInvested = $user->sponsorshipRequests()
            ->accepted()
            ->with('package')
            ->get()
            ->sum('package.price');

        // New marketplace stats
        $stats = [
            'active_sponsorships' => SponsorProposal::where('sponsor_id', $user->id)
                ->whereIn('status', ['active', 'contracted', 'payment_pending'])
                ->count() ?: $oldActiveSponsorships,
            'pending_requests' => SponsorProposal::where('sponsor_id', $user->id)
                ->whereIn('status', ['submitted', 'viewed', 'shortlisted'])
                ->count() ?: $oldPendingRequests,
            'negotiating' => SponsorProposal::where('sponsor_id', $user->id)
                ->whereIn('status', ['negotiating', 'counter_offer'])
                ->count(),
            'total_invested' => SponsorProposal::where('sponsor_id', $user->id)
                ->whereIn('status', ['agreed', 'contracted', 'payment_pending', 'active', 'completed'])
                ->sum('budget_offer') ?: $oldTotalInvested,
            'saved_count' => SponsorSavedEvent::where('sponsor_id', $user->id)->count(),
            'active_campaigns' => SponsorCampaign::where('sponsor_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'avg_roi' => SponsorCampaign::where('sponsor_id', $user->id)
                ->whereNotNull('roi')
                ->avg('roi'),
        ];

        $recentRequests = $user->sponsorshipRequests()
            ->with('event', 'package')
            ->latest()
            ->take(5)
            ->get();

        $recentProposals = SponsorProposal::where('sponsor_id', $user->id)
            ->with('event', 'package')
            ->latest()
            ->take(5)
            ->get();

        $savedEvents = SponsorSavedEvent::where('sponsor_id', $user->id)
            ->with('event.category')
            ->latest()
            ->take(4)
            ->get();

        $recentCampaigns = SponsorCampaign::where('sponsor_id', $user->id)
            ->with('event')
            ->latest()
            ->take(3)
            ->get();

        $budget = $user->sponsorBudgets()
            ->forYear(now()->year)
            ->first();

        return view('sponsor.dashboard', compact(
            'stats',
            'recentRequests',
            'recentProposals',
            'savedEvents',
            'recentCampaigns',
            'budget',
        ));
    }

    public function index(Request $request)
    {
        $query = Event::published()
            ->upcoming()
            ->with('organizer', 'category', 'packages')
            ->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sponsorship_type')) {
            $query->where('sponsorship_type', $request->sponsorship_type);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('target_age_group')) {
            $query->where('target_age_group', $request->target_age_group);
        }

        if ($request->filled('target_gender')) {
            $query->where('target_gender', $request->target_gender);
        }

        if ($request->filled('venue_type')) {
            $query->where('venue_type', $request->venue_type);
        }

        if ($request->filled('budget_min')) {
            $query->where('budget_max', '>=', $request->budget_min);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget_min', '<=', $request->budget_max);
        }

        if ($request->filled('audience_min')) {
            $query->where('expected_audience', '>=', $request->audience_min);
        }

        if ($request->filled('audience_max')) {
            $query->where('expected_audience', '<=', $request->audience_max);
        }

        if ($request->filled('ticket_price_min')) {
            $query->where('ticket_price_max', '>=', $request->ticket_price_min);
        }

        if ($request->filled('ticket_price_max')) {
            $query->where('ticket_price_min', '<=', $request->ticket_price_max);
        }

        if ($request->filled('has_celebrity')) {
            $query->where('has_celebrity', true);
        }

        if ($request->filled('has_govt_support')) {
            $query->where('has_govt_support', true);
        }

        if ($request->filled('has_media_coverage')) {
            $query->where('has_media_coverage', true);
        }

        if ($request->filled('instagram_reach_min')) {
            $query->where('instagram_reach', '>=', $request->instagram_reach_min);
        }

        if ($request->filled('youtube_reach_min')) {
            $query->where('youtube_reach', '>=', $request->youtube_reach_min);
        }

        if ($request->filled('website_traffic_min')) {
            $query->where('website_traffic', '>=', $request->website_traffic_min);
        }

        if ($request->filled('start_from')) {
            $query->where('start_date', '>=', $request->start_from);
        }

        if ($request->filled('start_to')) {
            $query->where('start_date', '<=', $request->start_to);
        }

        $events = $query->paginate(12)->withQueryString();
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        $cities = Event::published()->upcoming()->whereNotNull('city')->distinct()->pluck('city')->sort();

        return view('sponsor.events.index', compact('events', 'categories', 'cities'));
    }

    public function show(Event $event)
    {
        $event->load('organizer', 'category', 'packages.benefitRecords');

        $isSaved = auth()->user()->sponsorSavedEvents()
            ->where('event_id', $event->id)
            ->exists();

        $savedCount = SponsorSavedEvent::where('event_id', $event->id)->count();

        $existingProposal = SponsorProposal::where('sponsor_id', auth()->id())
            ->where('event_id', $event->id)
            ->latest()
            ->first();

        return view('sponsor.events.show', compact('event', 'isSaved', 'savedCount', 'existingProposal'));
    }

    public function requestSponsorship(Request $request, Event $event)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:sponsor_packages,id',
            'message' => 'required|string|max:2000',
            'budget_offer' => 'nullable|numeric|min:0',
        ]);

        SponsorshipRequest::create([
            'event_id' => $event->id,
            'sponsor_id' => auth()->id(),
            'package_id' => $validated['package_id'],
            'message' => $validated['message'],
            'budget_offer' => $validated['budget_offer'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Sponsorship request submitted successfully!');
    }
}
