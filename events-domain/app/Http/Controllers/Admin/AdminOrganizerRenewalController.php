<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerRenewal;
use Illuminate\Http\Request;

class AdminOrganizerRenewalController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizerRenewal::with(['sponsor', 'contract', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('sponsor', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $renewals = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.organizers.renewals', compact('renewals'));
    }

    public function show(OrganizerRenewal $renewal)
    {
        $renewal->load(['sponsor', 'contract', 'user']);

        return view('admin.organizers.renewal-show', compact('renewal'));
    }
}
