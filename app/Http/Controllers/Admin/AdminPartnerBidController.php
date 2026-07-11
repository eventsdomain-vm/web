<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerBid;
use Illuminate\Http\Request;

class AdminPartnerBidController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerBid::with(['partner', 'event', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            });
        }

        $bids = $query->latest()->paginate(20);

        return view('admin.partner-bids.index', compact('bids'));
    }

    public function show(PartnerBid $bid)
    {
        $bid->load(['partner', 'event', 'service', 'service.category']);

        return view('admin.partner-bids.show', compact('bid'));
    }
}
