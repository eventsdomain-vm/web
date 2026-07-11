<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerDeal;
use Illuminate\Http\Request;

class AdminPartnerDealController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerDeal::with(['partner', 'sponsor', 'event', 'lead']);

        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $deals = $query->latest()->paginate(20);
        $stages = ['qualification', 'proposal', 'negotiation', 'contract', 'payment', 'active', 'completed', 'lost'];

        return view('admin.partner-deals.index', compact('deals', 'stages'));
    }

    public function show(PartnerDeal $deal)
    {
        $deal->load(['partner', 'sponsor', 'event', 'lead', 'commissions', 'meetings']);

        return view('admin.partner-deals.show', compact('deal'));
    }
}
