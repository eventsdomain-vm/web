<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\PartnerBid;
use App\Models\PartnerService;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index()
    {
        $bids = auth()->user()->partnerBids()
            ->with('event', 'service')
            ->latest()
            ->paginate(10);

        return view('partner.bids.index', compact('bids'));
    }

    public function show(PartnerBid $bid)
    {
        if ($bid->partner_id !== auth()->id()) {
            abort(403);
        }

        $bid->load('event', 'service.category');

        return view('partner.bids.show', compact('bid'));
    }

    public function opportunities(Request $request)
    {
        $query = Event::published()
            ->upcoming()
            ->with('organizer', 'category')
            ->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $events = $query->paginate(12)->withQueryString();
        $services = PartnerService::where('partner_id', auth()->id())
            ->available()
            ->get();
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('partner.opportunities.index', compact('events', 'services', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'service_id' => 'required|exists:partner_services,id',
            'quote_amount' => 'required|numeric|min:0',
            'quote_note' => 'nullable|string|max:5000',
        ]);

        $validated['partner_id'] = auth()->id();
        $validated['status'] = 'pending';

        $bid = PartnerBid::create($validated);

        $partner = $bid->partner;
        $partner->notify(new PartnerBidNotification(
            eventTitle: $bid->event->title,
            eventId: $bid->event_id,
            bidStatus: $bid->status,
            bidId: $bid->id,
        ));

        return redirect()->route('partner.bids.show', $bid)
            ->with('success', 'Bid submitted successfully!');
    }

    public function accept($id)
    {
        $bid = PartnerBid::findOrFail($id);

        if ($bid->partner_id !== auth()->id()) {
            abort(403);
        }

        $bid->update(['status' => 'accepted']);

        $bid->partner->notify(new PartnerBidNotification(
            eventTitle: $bid->event->title,
            eventId: $bid->event_id,
            bidStatus: 'accepted',
            bidId: $bid->id,
        ));

        return redirect()->route('partner.bids.show', $bid)
            ->with('success', 'Bid accepted!');
    }

    public function reject($id)
    {
        $bid = PartnerBid::findOrFail($id);

        if ($bid->partner_id !== auth()->id()) {
            abort(403);
        }

        $bid->update(['status' => 'rejected']);

        $bid->partner->notify(new PartnerBidNotification(
            eventTitle: $bid->event->title,
            eventId: $bid->event_id,
            bidStatus: 'rejected',
            bidId: $bid->id,
        ));

        return redirect()->route('partner.bids.show', $bid)
            ->with('success', 'Bid rejected.');
    }
}
