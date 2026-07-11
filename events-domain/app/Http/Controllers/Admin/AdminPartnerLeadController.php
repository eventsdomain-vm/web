<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerLead;
use Illuminate\Http\Request;

class AdminPartnerLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerLead::with(['partner', 'sponsor', 'event', 'createdBy', 'assignedTo']);

        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $leads = $query->latest()->paginate(20);
        $stages = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];

        return view('admin.partner-leads.index', compact('leads', 'stages'));
    }

    public function show(PartnerLead $lead)
    {
        $lead->load(['partner', 'sponsor', 'event', 'createdBy', 'assignedTo']);

        return view('admin.partner-leads.show', compact('lead'));
    }
}
